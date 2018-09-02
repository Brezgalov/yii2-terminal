<?php
namespace app\controllers\actions\days;

use app\models\WorkShifts;
use app\models\RuleInstances;
use app\models\RuleCultures;
use app\models\RetailersGroups;
use app\models\RetailersGroupRetailers;
use yii\web\NotFoundHttpException;

/**
 * Class ViewAction
 * @package app\controllers\actions\days
 *
 * Возвращает детализацию дня
 */
class ViewAction extends \yii\rest\ViewAction
{
    public function run($id)
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $workShifts = WorkShifts::find()
            ->select(['id', 'start', 'end'])
            ->where(['=', 'day_id', $id])
            ->asArray()
            ->all()
        ;

        foreach ($workShifts as $i => $workShift) {
            $rules = RuleInstances::find()
                ->select([
                    '*',
                    'SUM(`count`) as `countTotal`',
                    'SUM(`quota`) as `quotaTotal`',
                ])
                ->where(['=', 'work_shift_id', $workShift['id']])
                ->groupBy(['rule_id'])
                ->asArray()
                ->all()
            ;
            $rulesAgg = [];
            foreach($rules as $rule) {
                $rulesAgg = $this->getRuleInfo($rule);
            }
            $workShifts[$i]['rules'] = $rulesAgg;
        }

        if (empty($workShifts)) {
            throw new NotFoundHttpException('Object not found: '.$id, 0);
        }
        return ['workShifts' => $workShifts];
    }

    /**
     * Собираем инфу по инстансу
     *
     * @param array $rule
     * @return array
     */
    protected function getRuleInfo($rule) 
    {
        $cultures = RuleCultures::find()
            ->select([
                'cultures.name',
            ])
            ->innerJoin('cultures', 'cultures.id = rule_cultures.culture_id')
            ->where(['=', 'rule_id', $rule['rule_id']])
            ->asArray()
            ->all()
        ;
        $retailersGroups = RetailersGroups::find()
            ->with('retailers')
            ->where(['=', 'rule_id', $rule['rule_id']])
            ->asArray()
            ->all()
        ;           
        
        for ($i=0; $i < count($retailersGroups); $i++) { 
            unset(
                $retailersGroups[$i]['rule_id'],
                $retailersGroups[$i]['retailersGroupRetailers']
            );
        }

        return [
            'id'                => $rule['id'],
            'quota'             => $rule['quotaTotal'],
            'count'             => $rule['countTotal'],
            'cultures'          => array_column($cultures, 'name'),
            'retailersGroups'   => $retailersGroups,
        ];
    }
}
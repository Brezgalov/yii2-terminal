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
            $rulesInstances = RuleInstances::find()
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
            foreach($rulesInstances as $instance) {
                $rulesAgg = $this->getRuleInfo($instance);
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
     * @param array $instance
     * @return array
     */
    protected function getRuleInfo($instance)
    {
        $cultures = RuleCultures::find()
            ->select([
                'cultures.name',
            ])
            ->innerJoin('cultures', 'cultures.id = rule_cultures.culture_id')
            ->where(['=', 'rule_id', $instance['rule_id']])
            ->asArray()
            ->all()
        ;
        $retailersGroups = RetailersGroups::find()
            ->with('retailers')
            ->where(['=', 'rule_id', $instance['rule_id']])
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
            'rule_id'           => $instance['rule_id'],
            'instance_id'       => $instance['id'],
            'quota'             => $instance['quotaTotal'],
            'count'             => $instance['countTotal'],
            'cultures'          => array_column($cultures, 'name'),
            'retailersGroups'   => $retailersGroups,
        ];
    }
}
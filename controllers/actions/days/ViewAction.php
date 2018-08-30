<?php
namespace app\controllers\actions\days;

use app\models\WorkShifts;
use app\models\RuleInstances;
use app\models\RuleCultures;
use app\models\RetailersGroups;
use app\models\RetailersGroupRetailers;

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
                $cultures = RuleCultures::find()
                    ->select([
                        'cultures.name',
                    ])
                    ->innerJoin('cultures', 'cultures.id = rule_cultures.culture_id')
                    ->where(['=', 'rule_id', $rule['rule_id']])
                    ->asArray()
                    ->all()
                ;
                $retailerGroups = RetailersGroups::find()
                    ->where(['=', 'rule_id', $rule['rule_id']])
                    ->asArray()
                    ->all()
                ;
                foreach ($retailerGroups as $i => $retailerGroup) {
                    $groupRetailers = RetailersGroupRetailers::find()
                        ->select([
                            '*',
                            'retailers.name'
                        ])
                        ->innerJoin('retailers', 'retailers.id = retailers_group_retailers.retailer_id')
                        ->where(['=','retailers_group_id', $retailerGroup['id']])
                        ->asArray()
                        ->all()
                    ;
                    $retailerGroups[$i]['retailers'] = array_column($groupRetailers, 'name');
                    unset($retailerGroups[$i]['rule_id']);
                }

                $rulesAgg[] = [
                    'quota'             => $rule['quotaTotal'],
                    'count'             => $rule['countTotal'],
                    'cultures'          => array_column($cultures, 'name'),
                    'retailersGroups'   => $retailerGroups,
                ];
            }
            $workShifts[$i]['rules'] = $rulesAgg;
        }
        return ['workShifts' => $workShifts];
    }
}
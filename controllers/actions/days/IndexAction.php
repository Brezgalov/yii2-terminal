<?php
namespace app\controllers\actions\days;

use yii\db\ActiveQuery;
use app\models\Days;
/**
 * Class IndexAction
 * @package app\controllers\actions\days
 *
 * Возвращает превью дней
 */
class IndexAction extends \yii\rest\IndexAction
{
    public function run()
    {
        $dbDays = Days::find();
        //$this->applyParams($dbDays);
        $days = $dbDays
            ->with(['workShifts.ruleInstances.rule.cultures'])
            ->orderBy('date')
            ->asArray()
            ->all()
        ;

        foreach ($days as $i => $day) {
            $total = [
                'quota' => 0,
                'count'	=> 0,
            ];
            $rules = [];
            foreach ($day['workShifts'] as $j => $workShift) {
                foreach ($workShift['ruleInstances'] as $ruleInst) {
                    //Считаем общую квоту и регистрации за день
                    $total['quota'] += $ruleInst['quota'];
                    $total['count'] += $ruleInst['count'];
                    //Считаем общую квоту и регистрации по каждому правилу
                    $ruleId = $ruleInst['rule_id'];
                    if (!array_key_exists($ruleId, $rules)) {
                        $rules[$ruleId] = [
                            'quota' => $ruleInst['quota'],
                            'count'	=> $ruleInst['count'],
                            'crops' => array_column($ruleInst['rule']['cultures'], 'name'),
                        ];
                    } else {
                        $rules[$ruleId]['quota'] += $ruleInst['quota'];
                        $rules[$ruleId]['count'] += $ruleInst['count'];
                    }
                }
            }
            $days[$i]['total'] = $total;
            $days[$i]['rules'] = array_values($rules);
            unset($days[$i]['workShifts']);
        }

        return ['days' => $days];
    }

    /**
     * @param ActiveQuery $model
     */
    protected function applyParams(ActiveQuery &$model)
    {
        //@TODO: параметры?
//        $month  = intval(\Yii::$app->request->get('month'));
//        $year   = intval(\Yii::$app->request->get('year'));
//        if ($month >= 1 && $month <= 12) {
//            $year           = date('Y', time());
//            $monthPadded    = str_pad($month, 2, '0', STR_PAD_LEFT);
//            $dateLeft       = '2018-'.$monthPadded.'-1';
//            $dateRight      = date('Y-m-t', strtotime($dateLeft));
//            var_dump([$dateLeft, $dateRight]);die();
//            $dbDays         = $dbDays
//                ->where(['>=', 'date', $dateLeft])
//                ->andWhere(['<=', 'date', $dateRight])
//            ;
//        }
    }
}
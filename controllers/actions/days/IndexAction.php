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
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $dbDays = Days::find();
        $this->applyParams($dbDays);
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
        $limit = intval(\Yii::$app->request->get('limit'));
        $offset = intval(\Yii::$app->request->get('offset'));
        if ($limit > 0 && $offset >= 0) {
            $model
                ->limit($limit)
                ->offset($offset)
            ;
        }
    }
}
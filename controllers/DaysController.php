<?php
namespace app\controllers;

use app\models\RetailersGroupRetailers;
use app\models\RetailersGroups;
use app\models\RuleCultures;
use app\models\RuleInstances;
use app\models\RuleRetailers;
use app\models\Rules;
use yii\rest\ActiveController;
use app\models\Days;
use app\models\WorkShifts;

/**
 * Рест контроллер управления днями обслуживания
 */
class DaysController extends ActiveController 
{
    const DAY_FIRST_SECOND  = 0;
    const DAY_LAST_SECOND   = 86400;

	public $modelClass = 'app\models\Days';

    /**
     * @return array
     */
	public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        return $actions;
    }

	/**
     * @SWG\Get(
     *     path="/api/days",
     *     tags={"Days"},
     *     summary="Превью для списка дней",
     *     @SWG\Parameter(
     *          name="month",
     *          in="query",
     *          required=false,
     *          type="integer",
     *          maximum=12,
     *          minimum=1
     *     ),
     *     @SWG\Response(
 	 *      	response=200,
     *          description="123",
 	 *          @SWG\Schema(
 	 *              @SWG\Property(
	 *					property="days",
	 *                  type="array",
     *                  items=@SWG\Items(ref="#/definitions/DayPreview")
 	 *              ),
 	 *          )
 	 *     ),
     * )
     */
	public function actionIndex()
	{
        $dbDays = Days::find();
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
     * @SWG\Get(
     *     path="/api/days/{id}",
     *     tags={"Days"},
     *     summary="Детализация одного дня",
     *     @SWG\Parameter(
     *          in="path",
     *          name="id",
     *          type="integer"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="123",
     *          @SWG\Schema(ref="#/definitions/Day")
     *     )
     * )
     */
	public function actionView($id)
    {
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
                        ->innerJoin('retailers', 'retailers.id = retailers_group_retailers.retailers_group_id')
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
                    'retailersGroups'    => $retailerGroups,
                ];
            }
            $workShifts[$i]['rules'] = $rulesAgg;
        }
        return ['workShifts' => $workShifts];
    }
}
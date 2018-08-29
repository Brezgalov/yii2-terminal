<?php
namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Days;

/**
 * Рест контроллер управления днями обслуживания
 */
class DaysController extends ActiveController 
{
	public $modelClass = 'app\models\Days';

	/**
	 * Возвращаем доступные действия
	 *
	 * @return void
	 */
	public function actions()
	{
		$actions = parent::actions();
		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

		return $actions;
	}

	/**
     * @SWG\Get(path="/days",
     *     tags={"Days"},
     *     summary="Превью для списка дней",
     *     @SWG\Response(
 	 *      	response=200,
 	 *          description="Example extended response",
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
		parent::actionIndex();
	}

	/**
	 * Возвращаем форматированный список дней
	 *
	 * @return void
	 */
	public function prepareDataProvider()
	{
		$dbDays = Days::find();
		$month = intval(\Yii::$app->request->get('month'));
		if ($month >= 1 && $month <= 12) {
			$time = time();
			$dbDays = $dbDays
				->where(['>=', 'date', date('Y-m-1', $time)])
				->andWhere(['<=', 'date', date('Y-m-t', $time)])
			;
		}
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
}
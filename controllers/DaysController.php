<?php
namespace app\controllers;

use app\models\RetailersGroupRetailers;
use app\models\RetailersGroups;
use app\models\RuleCultures;
use app\models\RuleInstances;
use app\models\RuleRetailers;
use app\models\WorkShifts;
use yii\rest\ActiveController;

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
        $actions['index']['class']  = '\app\controllers\actions\days\IndexAction';
        $actions['view']['class']   = '\app\controllers\actions\days\ViewAction';
        //$actions['create']['class'] = '\app\controllers\actions\days\CreateAction';

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
        return parent::actionIndex();
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
        return parent::actionView($id);
    }

    public function actionCreate($id)
    {
        return parent::actionCreate($id);
    }
}
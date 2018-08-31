<?php
namespace app\controllers;

use app\models\RuleRetailers;
use yii\rest\ActiveController;

/**
 * Рест контроллер управления днями обслуживания
 */
class DaysController extends ActiveController
{
	public $modelClass = 'app\models\Days';

    /**
     * @return array
     */
	public function actions()
    {
        $actions = parent::actions();
        $actions['index']['class']  = '\app\controllers\actions\days\IndexAction';
        $actions['view']['class']   = '\app\controllers\actions\days\ViewAction';
        $actions['create']['class'] = '\app\controllers\actions\days\CreateAction';
        $actions['delete']['class'] = '\app\controllers\actions\days\DeleteAction';
        return $actions;
    }

	/**
     * @SWG\Get(
     *     path="/api/days",
     *     tags={"Days"},
     *     summary="Превью для списка дней",
     *     @SWG\Parameter(
     *          in="query",
     *          name="limit",
     *          type="integer",
     *          minimum=1,
     *          required=false,
     *          description="Сколько записей выбрать?"
     *     ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="offset",
     *          type="integer",
     *          minimum=0,
     *          required=false,
     *          description="Сколько записей пропустить?"
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
     *          type="integer",
     *          required=true,
     *          description="Идентификатор дня",
     *          minimum=1
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Успешное выполнение",
     *          @SWG\Schema(ref="#/definitions/DayInfo")
     *     ),
     *     @SWG\Response(
     *          response=404,
     *          description="Идентификатор не найден в системе",
     *          @SWG\Schema(ref="#/definitions/NotFoundHttpException")
     *     )
     * )
     */
	public function actionView($id)
    {
        return parent::actionView($id);
    }

    /**
     * @SWG\Post(
     *     path="/api/days",
     *     tags={"Days"},
     *     summary="Создаем день",
     *     @SWG\Parameter(
     *          in="query",
     *          name="date",
     *          type="string",
     *          required=true,
     *          description="Дата в формате Y-m-d"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Успешное выполнение",
     *          @SWG\Schema(ref="#/definitions/Day")
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="Ошибка валидации",
     *          @SWG\Schema(ref="#/definitions/ValidationError")
     *     )
     * )
     */
    public function actionCreate($id)
    {
        return parent::actionCreate($id);
    }

    /**
     * @SWG\Delete(
     *     path="/api/days/{id}",
     *     tags={"Days"},
     *     summary="Удаление дня и всего что с ним связано",
     *     @SWG\Parameter(
     *          in="path",
     *          name="id",
     *          type="integer",
     *          required=true,
     *          description="Идентификатор удаляемого дня",
     *          minimum=1
     *     ),
     *     @SWG\Response(
     *          response=204,
     *          description="Успешный ответ"
     *     ),
     *     @SWG\Response(
     *          response=404,
     *          description="Удаляемый объект не найден",
     *          @SWG\Schema(ref="#/definitions/NotFoundHttpException")
     *     )
     * )
     */
    public function actionDelete($id)
    {
        return parent::actionDelete($id);
    }
}
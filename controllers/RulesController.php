<?php
namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер управления правилами
 */
class RulesController extends ActiveController
{
	public $modelClass = 'app\models\Rules';

    /**
     * @return array
     */
	public function actions()
    {
		$actions = parent::actions();
		$actions['create']['class'] = '\app\controllers\actions\rules\CreateAction';
		return $actions;
	}

    /**
     * @SWG\Post(
     *     path="/api/rules",
     *     tags={"Rules"},
     *     summary="Создаем правило",
     *     @SWG\Parameter(
     *          in="formData",
     *          name="day_id",
     *          type="integer",
     *          required=true,
     *          minimum=1,
     *          description="Идентификатор дня"
     *     ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="quota",
     *          type="integer",
     *          required=true,
     *          minimum=1,
     *          description="Квота"
     *     ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="cultures",
     *          type="array",
     *          items=@SWG\Items(
     *              type="integer"
     *          )
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="Успешное выполнение",
     *          @SWG\Schema(ref="#/definitions/Days")
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="Ошибка валидации",
     *          @SWG\Schema(ref="#/definitions/ValidationError")
     *     )
     * )
     */
	public function actionCreate()
    {
        return parent::actionCreate();
    }
}
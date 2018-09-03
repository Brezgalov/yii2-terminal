<?php
namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер управления правилами
 */
class RetailersGroupsController extends ActiveController
{
	public $modelClass = 'app\models\RetailersGroups';

	public function actions()
    {
        $actions = parent::actions();
        $actions['create']['class'] = '\app\controllers\actions\retailersgroups\CreateAction';
        return $actions;
    }

    /**
     * @SWG\Post(
     *     path="/api/retailers-groups",
     *     tags={"RetailersGroups"},
     *     summary="Создаем группу",
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
     *          description="Квота на группу"
     *     ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="retailers",
     *          type="array",
     *          description="Массив айдишников перевозчиков",
     *          items=@SWG\Items(
     *              type="integer",
     *              minimum=1
     *          ),
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="Успешное выполнение",
     *          @SWG\Schema(ref="#/definitions/RetailersGroups")
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
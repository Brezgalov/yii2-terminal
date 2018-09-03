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
     *          name="rule_id",
     *          type="integer",
     *          required=true,
     *          minimum=1,
     *          description="Идентификатор правила"
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

    /**
     * @SWG\Delete(
     *     path="/api/retailers-groups/{id}",
     *     tags={"RetailersGroups"},
     *     summary="Удаление группы",
     *     @SWG\Parameter(
     *          in="path",
     *          name="id",
     *          type="integer",
     *          required=true,
     *          description="Идентификатор удаляемой группы",
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
    public function actionDelete()
    {
        return parent::actionDelete();
    }
}
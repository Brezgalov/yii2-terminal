<?php
namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер управления культурами
 */
class CulturesController extends ActiveController
{
	public $modelClass = 'app\models\Cultures';

    /**
     * @SWG\Get(
     *     path="/api/cultures",
     *     tags={"Cultures"},
     *     summary="Получаем список культур",
     *     @SWG\Response(
     *          response=200,
     *          description="Успешный ответ",
     *          @SWG\Schema(
     *              @SWG\Items(ref="#/definitions/Cultures")
     *          )
     *     )
     * )
     */
	public function actionIndex()
    {
        return parent::actionIndex();
    }

    /**
     * @SWG\Get(
     *     path="/api/cultures/{id}",
     *     tags={"Cultures"},
     *     summary="Получаем список культур",
     *     @SWG\Parameter(
     *          in="path",
     *          name="id",
     *          type="integer",
     *          required=true,
     *          description="Идентификатор культуры",
     *          minimum=1
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Успешный ответ",
     *          @SWG\Schema(
     *              ref="#/definitions/Cultures"
     *          )
     *     )
     * )
     */
    public function actionView($id)
    {
        return parent::actionView($id);
    }

    /**
     * @SWG\Post(
     *     path="/api/cultures",
     *     tags={"Cultures"},
     *     summary="Создаем культуру",
     *     @SWG\Parameter(
     *          in="formData",
     *          name="name",
     *          type="string",
     *          required=true,
     *          description="Название культуры"
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="Успешный ответ",
     *          @SWG\Schema(
     *              ref="#/definitions/Cultures"
     *          )
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
     *     path="/api/cultures/{id}",
     *     tags={"Cultures"},
     *     summary="Получаем список культур",
     *     @SWG\Parameter(
     *          in="path",
     *          name="id",
     *          type="integer",
     *          required=true,
     *          description="Идентификатор культуры",
     *          minimum=1
     *     ),
     *     @SWG\Response(
     *          response=204,
     *          description="Успех",
     *     )
     * )
     */
    public function actionDelete($id)
    {
        return parent::actionDelete($id);
    }
}
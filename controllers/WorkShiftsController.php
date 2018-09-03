<?php
namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер для создания смены
 */
class WorkShiftsController extends ActiveController
{
    public $modelClass = 'app\models\WorkShifts';

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['create']['class'] = '\app\controllers\actions\workshifts\CreateAction';
        return $actions;
    }

    /**
     * @SWG\Post(
     *     path="/api/work-shifts",
     *     tags={"WorkShifts"},
     *     summary="Добавляем смену",
     *     @SWG\Parameter(
     *          in="formData",
     *          name="day_id",
     *          type="integer",
     *          required=true,
     *          description="Идентификатор дня",
     *          minimum=1
     *     ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="start",
     *          type="integer",
     *          required=true,
     *          description="Кол-во сек. от начала дня до начала смены",
     *          minimum=0,
     *          maximum=86400
     *     ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="end",
     *          type="integer",
     *          required=true,
     *          description="Кол-во сек. от начала дня до конца смены",
     *          minimum=0,
     *          maximum=86400
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Успех",
     *          @SWG\Schema(ref="#/definitions/WorkShifts")
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
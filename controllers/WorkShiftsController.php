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
}
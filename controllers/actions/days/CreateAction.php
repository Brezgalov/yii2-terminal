<?php
namespace app\controllers\actions\days;

use app\models\Days;
use app\models\WorkShifts;
use yii\web\ServerErrorHttpException;
use Yii;
use yii\helpers\Url;

class CreateAction extends \yii\rest\CreateAction
{
    public function run()
    {
        $model = parent::run();

        if ($model->save()) {
            $workShift          = new WorkShifts();
            $workShift->day_id  = $model->id;
            $workShift->start   = Days::DAY_FIRST_SECOND;
            $workShift->end     = Days::DAY_LAST_SECOND;
            $workShift->save();
        }
        //Валидация за пределами этого метода!!!!!!!!!!!!!!!!!
        //Поэтому возвращаем просто модель
        return $model;
    }
}
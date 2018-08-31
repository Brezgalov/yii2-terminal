<?php
namespace app\controllers\actions\days;

use app\models\Days;
use app\models\Rules;

/**
 * Class DeleteAction
 * @package app\controllers\actions\days
 *
 * Удаляем запись дня и все с ней связанное из бд
 */
class DeleteAction extends \yii\rest\DeleteAction
{
    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        Days::deleteRels($id);
        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }
}
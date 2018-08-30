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

        $ruleIds = Days::find()
            ->select(['days.id','work_shifts.id','rule_instances.*'])
            ->innerJoin('work_shifts', 'work_shifts.day_id = days.id')
            ->innerJoin('rule_instances', 'rule_instances.work_shift_id = work_shifts.id')
            ->where(['=', 'days.id', $id])
            ->groupBy(['rule_instances.rule_id'])
            ->asArray()
            ->all()
        ;
        $rules = Rules::find()->where(['in', 'id', array_column($ruleIds, 'rule_id')])->all();
        foreach ($rules as $rule) {
            if ($rule->delete() === false) {
                throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
            }
        }

        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }
}
<?php
namespace app\controllers\actions\workshifts;

use Yii;
use app\models\WorkShifts;

class CreateAction extends \yii\rest\CreateAction
{
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $model = new WorkShifts([
            'scenario' => $this->scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->saveRuleAgg();
                $model->save();
                $model->concatShifts();
                $transaction->commit();
            } catch (\Exception $ex) {
                $transaction->rollback();
                throw $ex;
            }
        }
        return $model;
    }
}
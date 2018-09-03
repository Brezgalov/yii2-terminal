<?php
namespace app\controllers\actions\retailersgroups;

use app\models\Retailers;
use app\models\RetailersGroupRetailers;
use app\models\RetailersGroups;
use Yii;

/**
 * Создаем группу
 * @package app\controllers\actions\retailersgroups
 */
class CreateAction extends \yii\rest\CreateAction
{
    public function run()
    {
        $model = parent::run();
        if (!$model->hasErrors())
        {
            $this->createRelationsFromRequest($model);
        }
        return $model;
    }

    /**
     * @param RetailersGroups $model
     */
    protected function createRelationsFromRequest(RetailersGroups $model)
    {
        $retailers = Yii::$app->request->post('retailers');
        if (empty($retailers) || !is_array($retailers)) {
            return;
        }
        $realRetailers = Retailers::find()->where(['in', 'id', $retailers])->all();
        foreach ($realRetailers as $realRetailer) {
            $relation                       = new RetailersGroupRetailers();
            $relation->retailer_id          = $realRetailer->id;
            $relation->retailers_group_id   = $model->id;
            $relation->save();
        }
    }
}
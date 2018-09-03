<?php
namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер управления инстансами правил
 */
class RuleInstancesController extends ActiveController
{
	public $modelClass = 'app\models\RuleInstances';

    /**
     * @SWG\Put(
     *     path="/api/rule-instances",
     *     tags={"RuleInstances"},
     *     summary="Редактируем инстанс правила",
     *
     * )
     */
	public function actionUpdate()
    {
        return parent::actionUpdate();
    }
}
<?php
namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер управления инстансами правил
 */
class RuleInstancesController extends ActiveController
{
	public $modelClass = 'app\models\RuleInstances';
}
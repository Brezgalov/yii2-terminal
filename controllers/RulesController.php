<?php
namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер управления правилами
 */
class RulesController extends ActiveController
{
	public $modelClass = 'app\models\Rules';

    /**
     * @return array
     */
	public function actions()
    {
		$actions = parent::actions();
		$actions['create']['class'] = '\app\controllers\actions\rules\CreateAction';
		return $actions;
	}
}
<?php
namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер управления правилами
 */
class RetailersGroupsController extends ActiveController
{
	public $modelClass = 'app\models\RetailersGroups';

    /**
     * @return array
     */
	public function actions()
    {
		$actions = parent::actions();
		return $actions;
	}
}
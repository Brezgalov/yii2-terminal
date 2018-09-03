<?php
namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер управления правилами
 */
class RetailersGroupsController extends ActiveController
{
	public $modelClass = 'app\models\RetailersGroups';

	public function actions()
    {
        $actions = parent::actions();
        $actions['create']['class'] = '\app\controllers\actions\retailersgroups\CreateAction';
        return $actions;
    }
}
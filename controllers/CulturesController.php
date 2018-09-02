<?php
namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер управления культурами
 */
class CulturesController extends ActiveController
{
	public $modelClass = 'app\models\Cultures';
}
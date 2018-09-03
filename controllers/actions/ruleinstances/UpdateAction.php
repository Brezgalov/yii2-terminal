<?php
namespace app\controllers\actions\ruleinstances;

use app\models\RuleInstances;

class UpdateAction extends \yii\rest\UpdateAction
{
    public $scenario = RuleInstances::SCENARIO_UPDATE;

    public function run($id)
    {
        return parent::run($id);
    }
}
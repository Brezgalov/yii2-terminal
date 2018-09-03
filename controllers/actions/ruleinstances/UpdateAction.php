<?php
namespace app\controllers\actions\ruleinstances;

class UpdateAction extends \yii\rest\UpdateAction
{
    public $scenario = 'update';

    public function run($id)
    {
        var_dump($this->scenario);die();
        return parent::run($id);
    }
}
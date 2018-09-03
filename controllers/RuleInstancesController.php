<?php

namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Рест контроллер управления инстансами правил
 */
class RuleInstancesController extends ActiveController
{
    public $modelClass = 'app\models\RuleInstances';

    public function actions()
    {
        $actions = parent::actions();
        $actions['update']['class'] = '\app\controllers\actions\ruleinstances\UpdateAction';//
        return $actions;
    }

    /**
     * @SWG\Put(
     *     path="/api/rule-instances/{id}",
     *     tags={"RuleInstances"},
     *     summary="Редактируем квоту правила через инстанс",
     *     @SWG\Parameter(
     *          in="path",
     *          name="id",
     *          type="integer",
     *          required=true,
     *          description="Идентификатор инстанса",
     *          minimum=1
     *     ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="quota",
     *          type="integer",
     *          description="Квота"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Успешное выполнение",
     *          @SWG\Schema(ref="#/definitions/RuleInstances")
     *     ),
     * )
     */
    public function actionUpdate()
    {
        return parent::actionUpdate();
    }
}
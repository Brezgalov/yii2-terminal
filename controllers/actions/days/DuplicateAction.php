<?php
namespace app\controllers\actions\days;

use app\models\Days;
use app\models\RetailersGroupRetailers;
use app\models\RetailersGroups;
use app\models\RuleCultures;
use app\models\RuleInstances;
use app\models\Rules;
use app\models\WorkShifts;

/**
 * Class DuplicateAction
 * @package app\controllers\actions\days
 *
 * Создаем дубликат дня с указанной датой
 */
class DuplicateAction extends \yii\rest\CreateAction
{
    /**
     * Идентификатор записи для дублирования
     * @var null|integer
     */
    protected $duplicateId = null;

    /**
     * Запускаем экшн
     * @return array|\yii\db\ActiveRecordInterface
     * @throws \yii\web\ServerErrorHttpException
     */
    public function run()
    {
        if (!$this->validate($model)) {
            return $model;
        }
        $model = parent::run();

        if ($model->save()) {
            $this->duplicateRelations($model, $this->duplicateId);
        }

        return $model;
    }

    /**
     * Доп. валидация
     * @param $model - получает \app\models\Days
     * @return bool
     */
    protected function validate(&$model)
    {
        $this->duplicateId = intval(\Yii::$app->request->post('id'));
        $model = new Days();
        if (!$this->duplicateId) {
            $model->addError('id', 'Не указан идентификатор записи для дублирования');
            return false;
        } elseif (Days::find()->where(['=', 'id', $this->duplicateId])->count() == 0) {
            $model->addError('id', 'Запись выбранная для дублирования не существует в системе');
            return false;
        }
        return true;
    }

    /**
     * Производим дублирование связей
     * @param Days $model
     * @param $id
     */
    protected function duplicateRelations(Days $model, $id)
    {
        $rulesMap = [];
        $relationsChain = WorkShifts::find()
            ->with('rulesRel')
            ->where(['=', 'day_id', $id])
            ->all()
        ;

        //Копируем ветку связей
        foreach ($relationsChain as $workShift) {
            //Начинаем со смен
            $WSCopy             = new WorkShifts();
            $WSCopy->attributes = $workShift->attributes;
            $WSCopy->day_id     = $model->id;
            $WSCopy->save();

            //копируем правила
            foreach ($workShift->rulesRel as $rule) {
                if (array_key_exists($rule->id, $rulesMap)) {
                    continue;
                }
                //Скопировали само правило
                $RCopy              = new Rules();
                $RCopy->attributes  = $rule->attributes;
                $RCopy->save();
                $rulesMap[$rule->id] = $RCopy->id;
                //привязываем культуры
                foreach($rule->ruleCultures as $cultureRelation)
                {
                    $CRCopy             = new RuleCultures();
                    $CRCopy->attributes = $cultureRelation->attributes;
                    $CRCopy->rule_id    = $rulesMap[$rule->id];
                    $CRCopy->save();
                }
                //Копируем поставщиков
                foreach ($rule->retailersGroups as $group) {
                    $RGCopy = new RetailersGroups();
                    $RGCopy->attributes = $group->attributes;
                    $RGCopy->rule_id    = $rulesMap[$rule->id];
                    $RGCopy->save();

                    foreach($group->retailersGroupRetailers as $retailerRelation) {
                        $RGRCopy                        = new RetailersGroupRetailers();
                        $RGRCopy->retailers_group_id    = $RGCopy->id;
                        $RGRCopy->retailer_id           = $retailerRelation->retailer_id;
                        $RGRCopy->save();
                    }
                }
            }

            //Создаем инстансы правил
            foreach ($workShift->ruleInstances as $instance) {
                $ICopy                  = new RuleInstances();
                $ICopy->attributes      = $instance->attributes;
                $ICopy->work_shift_id   = $WSCopy->id;
                $ICopy->rule_id         = $rulesMap[$instance->rule_id];
                $ICopy->save();
            }
        }
    }
}
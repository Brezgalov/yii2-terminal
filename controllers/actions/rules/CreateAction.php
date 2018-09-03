<?php
namespace app\controllers\actions\rules;

use app\models\Cultures;
use Yii;
use app\models\WorkShifts;
use app\models\RuleInstances;
use app\models\RuleCultures;
use app\models\forms\rules\CreateForm;

/**
 * Class CreateAction
 * @package app\controllers\actions\rules
 *
 * Создаем инстансы правила для дня в бд
 */
class CreateAction extends \yii\rest\CreateAction
{
	public function run()
    {
		$form = new CreateForm();
		$form->load(Yii::$app->request->post(), '');
		if (!$form->validate()) {
			return $form;
		}

		$transaction = Yii::$app->db->beginTransaction();
		$model = parent::run();
		if ($model->hasErrors()) {
			$transaction->rollback();
			return $model;
		}

		$workShifts = WorkShifts::find()
			->where(['=', 'day_id', $form->day_id])
			->orderBy('start')
			->all()
		;
		$count = count($workShifts);
		$perOne = round($form->quota / $count);
		$sum = 0;
		for ($i = 0; $i < $count; $i++) {
			$instance = new RuleInstances();
			$instance->rule_id = $model->id;
			$instance->work_shift_id = $workShifts[$i]->id;
			$instance->count = 0;
			if ($i + 1 != $count) {
				$instance->quota = $perOne;
				$sum += $perOne;
			} else {				
				$instance->quota = $form->quota - $sum;
			}
			if (!$instance->save()) {
				$transaction->rollback();
				return $instance;
			}
		}

		$realCultures = Cultures::find()->where(['in', 'id', $form->cultures])->all();
		foreach($realCultures as $culture) {
			$cultureRel 			= new RuleCultures();
			$cultureRel->rule_id 	= $model->id;
			$cultureRel->culture_id = $culture->id;
			$cultureRel->save();
		}

		$transaction->commit();
		return $form;
	}
}
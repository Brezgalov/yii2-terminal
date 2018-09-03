<?php
namespace app\models;

/**
 * This is the model class for table "rule_instances".
 *
 * @property int $id
 * @property int $rule_id
 * @property int $work_shift_id
 * @property int $quota
 * @property int $count
 *
 * @property Rules $rule
 * @property WorkShifts $workShift
 */
class RuleInstances extends \app\models\base\RuleInstances
{
    const SCENARIO_UPDATE = 'update';
	/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rule_id', 'work_shift_id'], 'required'],
            [['rule_id', 'work_shift_id', 'quota'], 'integer', 'min' => 0],
            [['rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rules::className(), 'targetAttribute' => ['rule_id' => 'id']],
            [['work_shift_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkShifts::className(), 'targetAttribute' => ['work_shift_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = ['quota', '!work_shift_id','!count','!rule_id'];
        return $scenarios;
    }
}

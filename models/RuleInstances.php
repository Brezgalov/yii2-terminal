<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rule_instances".
 *
 * @property int $id
 * @property int $rule_id
 * @property int $work_shift_id
 * @property int $quota
 * @property int $registered
 *
 * @property Rules $rule
 * @property WorkShifts $workShift
 */
class RuleInstances extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rule_instances';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rule_id', 'work_shift_id'], 'required'],
            [['rule_id', 'work_shift_id', 'quota', 'registered'], 'integer'],
            [['rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rules::className(), 'targetAttribute' => ['rule_id' => 'id']],
            [['work_shift_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkShifts::className(), 'targetAttribute' => ['work_shift_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rule_id' => 'Rule ID',
            'work_shift_id' => 'Work Shift ID',
            'quota' => 'Quota',
            'registered' => 'Registered',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRule()
    {
        return $this->hasOne(Rules::className(), ['id' => 'rule_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkShift()
    {
        return $this->hasOne(WorkShifts::className(), ['id' => 'work_shift_id']);
    }
}

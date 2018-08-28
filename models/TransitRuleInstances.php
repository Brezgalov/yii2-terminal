<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transit_rule_instances".
 *
 * @property int $id
 * @property int $transit_rule_id
 * @property int $work_shift_id
 * @property int $quota
 * @property int $registered
 *
 * @property TransitRules $transitRule
 * @property WorkShifts $workShift
 */
class TransitRuleInstances extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transit_rule_instances';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transit_rule_id', 'work_shift_id'], 'required'],
            [['transit_rule_id', 'work_shift_id', 'quota', 'registered'], 'integer'],
            [['transit_rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransitRules::className(), 'targetAttribute' => ['transit_rule_id' => 'id']],
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
            'transit_rule_id' => 'Transit Rule ID',
            'work_shift_id' => 'Work Shift ID',
            'quota' => 'Quota',
            'registered' => 'Registered',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitRule()
    {
        return $this->hasOne(TransitRules::className(), ['id' => 'transit_rule_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkShift()
    {
        return $this->hasOne(WorkShifts::className(), ['id' => 'work_shift_id']);
    }
}

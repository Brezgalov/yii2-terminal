<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_shifts".
 *
 * @property int $id
 * @property int $day_id
 * @property int $start
 * @property int $end
 *
 * @property TransitRuleInstances[] $transitRuleInstances
 * @property Days $day
 */
class WorkShifts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_shifts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day_id', 'start', 'end'], 'required'],
            [['day_id', 'start', 'end'], 'integer'],
            [['day_id'], 'exist', 'skipOnError' => true, 'targetClass' => Days::className(), 'targetAttribute' => ['day_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day_id' => 'Day ID',
            'start' => 'Start',
            'end' => 'End',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitRuleInstances()
    {
        return $this->hasMany(TransitRuleInstances::className(), ['work_shift_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDay()
    {
        return $this->hasOne(Days::className(), ['id' => 'day_id']);
    }
}

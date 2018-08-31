<?php

namespace app\models\base;

use Yii;
use app\models\WorkShifts;

/**
 * This is the model class for table "days".
 *
 * @property int $id
 * @property string $date
 *
 * @property WorkShifts[] $workShifts
 */
class Days extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'days';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkShifts()
    {
        return $this->hasMany(WorkShifts::className(), ['day_id' => 'id']);
    }
}

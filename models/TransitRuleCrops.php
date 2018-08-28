<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transit_rule_crops".
 *
 * @property int $id
 * @property int $transit_rule_id
 * @property int $crop_id
 *
 * @property Crops $crop
 * @property TransitRules $transitRule
 */
class TransitRuleCrops extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transit_rule_crops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transit_rule_id', 'crop_id'], 'required'],
            [['transit_rule_id', 'crop_id'], 'integer'],
            [['crop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Crops::className(), 'targetAttribute' => ['crop_id' => 'id']],
            [['transit_rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransitRules::className(), 'targetAttribute' => ['transit_rule_id' => 'id']],
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
            'crop_id' => 'Crop ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrop()
    {
        return $this->hasOne(Crops::className(), ['id' => 'crop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitRule()
    {
        return $this->hasOne(TransitRules::className(), ['id' => 'transit_rule_id']);
    }
}

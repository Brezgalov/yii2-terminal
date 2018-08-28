<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transit_rule_retailers".
 *
 * @property int $id
 * @property int $transit_rule_id
 * @property int $retailer_id
 *
 * @property Retailers $retailer
 * @property TransitRules $transitRule
 */
class TransitRuleRetailers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transit_rule_retailers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transit_rule_id', 'retailer_id'], 'required'],
            [['transit_rule_id', 'retailer_id'], 'integer'],
            [['retailer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Retailers::className(), 'targetAttribute' => ['retailer_id' => 'id']],
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
            'retailer_id' => 'Retailer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRetailer()
    {
        return $this->hasOne(Retailers::className(), ['id' => 'retailer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitRule()
    {
        return $this->hasOne(TransitRules::className(), ['id' => 'transit_rule_id']);
    }
}

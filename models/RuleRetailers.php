<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rule_retailers".
 *
 * @property int $id
 * @property int $rule_id
 * @property int $retailer_id
 *
 * @property Retailers $retailer
 * @property Rules $rule
 */
class RuleRetailers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rule_retailers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rule_id', 'retailer_id'], 'required'],
            [['rule_id', 'retailer_id'], 'integer'],
            [['retailer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Retailers::className(), 'targetAttribute' => ['retailer_id' => 'id']],
            [['rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rules::className(), 'targetAttribute' => ['rule_id' => 'id']],
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
    public function getRule()
    {
        return $this->hasOne(Rules::className(), ['id' => 'rule_id']);
    }
}

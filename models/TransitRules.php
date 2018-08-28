<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transit_rules".
 *
 * @property int $id
 *
 * @property TransitRuleCrops[] $transitRuleCrops
 * @property TransitRuleInstances[] $transitRuleInstances
 * @property TransitRuleRetailers[] $transitRuleRetailers
 */
class TransitRules extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transit_rules';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitRuleCrops()
    {
        return $this->hasMany(TransitRuleCrops::className(), ['transit_rule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrops()
    {
        return $this
            ->hasMany(Crops::className(), ['id' => 'crop_id'])
            ->via('transitRuleCrops');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitRuleInstances()
    {
        return $this->hasMany(TransitRuleInstances::className(), ['transit_rule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitRuleRetailers()
    {
        return $this->hasMany(TransitRuleRetailers::className(), ['transit_rule_id' => 'id']);
    }
}

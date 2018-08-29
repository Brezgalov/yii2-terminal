<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rules".
 *
 * @property int $id
 *
 * @property RuleCrops[] $ruleCrops
 * @property RuleInstances[] $ruleInstances
 * @property RuleRetailers[] $ruleRetailers
 */
class RuleRetailers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rules';
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
    public function getRuleCrops()
    {
        return $this->hasMany(RuleCrops::className(), ['rule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleInstances()
    {
        return $this->hasMany(RuleInstances::className(), ['rule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleRetailers()
    {
        return $this->hasMany(RuleRetailers::className(), ['rule_id' => 'id']);
    }
}

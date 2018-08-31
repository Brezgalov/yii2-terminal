<?php

namespace app\models\base;

use Yii;
use app\models\Rules;
use app\models\RetailersGroupRetailers;

/**
 * This is the model class for table "retailers_groups".
 *
 * @property int $id
 * @property int $rule_id
 * @property int $quota
 *
 * @property RetailersGroupRetailers[] $retailersGroupRetailers
 * @property Rules $rule
 */
class RetailersGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'retailers_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rule_id', 'quota'], 'required'],
            [['rule_id', 'quota'], 'integer'],
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
            'quota' => 'Quota',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRetailersGroupRetailers()
    {
        return $this->hasMany(RetailersGroupRetailers::className(), ['retailers_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRule()
    {
        return $this->hasOne(Rules::className(), ['id' => 'rule_id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rule_cultures".
 *
 * @property int $id
 * @property int $rule_id
 * @property int $culture_id
 *
 * @property Cultures $culture
 * @property Rules $rule
 */
class RuleCultures extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rule_cultures';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rule_id', 'culture_id'], 'required'],
            [['rule_id', 'culture_id'], 'integer'],
            [['culture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cultures::className(), 'targetAttribute' => ['culture_id' => 'id']],
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
            'culture_id' => 'Culture ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCulture()
    {
        return $this->hasOne(Cultures::className(), ['id' => 'culture_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRule()
    {
        return $this->hasOne(Rules::className(), ['id' => 'rule_id']);
    }
}

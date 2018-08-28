<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "retailers".
 *
 * @property int $id
 * @property string $name
 *
 * @property TransitRuleRetailers[] $transitRuleRetailers
 */
class Retailers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'retailers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitRuleRetailers()
    {
        return $this->hasMany(TransitRuleRetailers::className(), ['retailer_id' => 'id']);
    }
}

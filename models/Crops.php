<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "crops".
 *
 * @property int $id
 * @property string $name
 *
 * @property TransitRuleCrops[] $transitRuleCrops
 */
class Crops extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crops';
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
    public function getTransitRuleCrops()
    {
        return $this->hasMany(TransitRuleCrops::className(), ['crop_id' => 'id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "retailers".
 *
 * @property int $id
 * @property string $name
 *
 * @property RetailersGroupRetailers[] $retailersGroupRetailers
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
    public function getRetailersGroupRetailers()
    {
        return $this->hasMany(RetailersGroupRetailers::className(), ['retailer_id' => 'id']);
    }
}

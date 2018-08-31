<?php

namespace app\models\base;

use Yii;
use app\models\Retailers;
use app\models\RetailersGroups;

/**
 * This is the model class for table "retailers_group_retailers".
 *
 * @property int $id
 * @property int $retailers_group_id
 * @property int $retailer_id
 *
 * @property Retailers $retailer
 * @property RetailersGroups $retailersGroup
 */
class RetailersGroupRetailers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'retailers_group_retailers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['retailers_group_id', 'retailer_id'], 'required'],
            [['retailers_group_id', 'retailer_id'], 'integer'],
            [['retailer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Retailers::className(), 'targetAttribute' => ['retailer_id' => 'id']],
            [['retailers_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => RetailersGroups::className(), 'targetAttribute' => ['retailers_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'retailers_group_id' => 'Retailers Group ID',
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
    public function getRetailersGroup()
    {
        return $this->hasOne(RetailersGroups::className(), ['id' => 'retailers_group_id']);
    }
}

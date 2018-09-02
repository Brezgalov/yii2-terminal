<?php

namespace app\models;

use Yii;

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
class RetailersGroups extends \app\models\base\RetailersGroups
{
	public function getRetailers()
	{
		return $this->hasMany(Retailers::className(), ['id' => 'retailer_id'])
            ->via('retailersGroupRetailers')
        ;
	}
}

<?php

namespace app\models;

use Yii;

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
class RetailersGroupRetailers extends \app\models\base\RetailersGroupRetailers
{

}

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
class RuleCultures extends \app\models\base\RuleCultures
{
}

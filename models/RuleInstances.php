<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rule_instances".
 *
 * @property int $id
 * @property int $rule_id
 * @property int $work_shift_id
 * @property int $quota
 * @property int $count
 *
 * @property Rules $rule
 * @property WorkShifts $workShift
 */
class RuleInstances extends \app\models\base\RuleInstances
{

}

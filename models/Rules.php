<?php

namespace app\models;

/**
 * This is the model class for table "rules".
 *
 * @property int $id
 *
 * @property RetailersGroups[] $retailersGroups
 * @property RuleCultures[] $ruleCultures
 * @property RuleInstances[] $ruleInstances
 */
class Rules extends \app\models\base\Rules
{
    public function getCultures()
    {
        return $this->hasMany(Cultures::className(), ['id' => 'culture_id'])
            ->via('ruleCultures')
        ;
    }
}

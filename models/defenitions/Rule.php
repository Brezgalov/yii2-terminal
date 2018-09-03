<?php
namespace app\models\definitions;

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="rule_id", type="integer", description="Идентификатор правила")
 * @SWG\Property(property="instance_id", type="integer", description="Идентификатор инстанса")
 * @SWG\Property(property="quota", type="integer", description="Квота на зерновозы")
 * @SWG\Property(property="count", type="integer", description="Использованная квота на зерновозы")
 * @SWG\Property(property="cultures", type="array", items=@SWG\Items(type="string"))
 * @SWG\Property(property="retailersGroups", type="array", items=@SWG\Items(ref="#/definitions/RetailersGroups"))
 */
class Rule {

}
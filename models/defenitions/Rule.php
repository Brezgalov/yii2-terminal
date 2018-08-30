<?php
namespace app\models\definitions;

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="quota", type="integer", description="Квота на зерновозы")
 * @SWG\Property(property="count", type="integer", description="Использованная квота на зерновозы")
 * @SWG\Property(property="cultures", type="array", items=@SWG\Items(type="string"))
 */
class Rule {

}
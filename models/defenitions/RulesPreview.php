<?php
namespace app\models\definitions;

/**
 * Class RulePreview
 * @SWG\Definition()
 *
 * @SWG\Property(property="quota", type="integer", description="Квота на принятие машин")
 * @SWG\Property(property="count", type="integer", description="Количество машин принято")
 * @SWG\Property(property="cultures", type="array", description="Массив названий культур", items=@SWG\Items(type="string"))
 */
class RulesPreview
{

}
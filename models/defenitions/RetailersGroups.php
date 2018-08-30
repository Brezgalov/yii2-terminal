<?php
namespace app\models\definitions;

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="id", type="integer", description="Идентификатор группы")
 * @SWG\Property(property="quota", type="integer", description="Квота на группусду")
 * @SWG\Property(property="retailers", type="array", description="Массив объектов перевозчиков", items=@SWG\Items(type="string"))
 */
class RetailersGroups
{

}
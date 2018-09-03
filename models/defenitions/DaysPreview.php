<?php
namespace app\models\definitions;

/**
 * Class DayPreview
 * @SWG\Definition()
 *
 * @SWG\Property(property="id", type="integer", description="ID дня")
 * @SWG\Property(property="date", type="string", description="Дата в формате Y-m-d")
 * @SWG\Property(property="total", type="object", description="Объект с аггрегацией кол-ва машин",
 *     @SWG\Property(property="quota", type="integer", description="Суммарная квота по всем правилам"),
 *     @SWG\Property(property="count", type="integer", description="Суммарное количество принятых машин по всем правилам")
 * )
 * @SWG\Property(property="rules", type="array", description="Массив данных для превью правил",
 *     items=@SWG\Items(ref="#/definitions/RulePreview")
 * )
 */
class DaysPreview
{

}
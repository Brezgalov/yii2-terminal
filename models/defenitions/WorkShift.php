<?php
namespace app\models\definitions;

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="id", type="integer", description="Идентификатор смены")
 * @SWG\Property(property="start", type="integer", description="Кол-во секунд от начала дня до начала смены")
 * @SWG\Property(property="end", type="integer", description="Кол-во секунд от начала дня до конца смены")
 * @SWG\Property(property="rules", type="array", description="Массив объектов правил", items=@SWG\Items(ref="#/definitions/Rule"))
 */
class WorkShift {

}
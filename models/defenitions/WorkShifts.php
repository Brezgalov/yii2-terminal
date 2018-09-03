<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 03.09.2018
 * Time: 10:44
 */

namespace app\models\definitions;

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="id", type="integer", description="Идентификатор смены")
 * @SWG\Property(property="day_id", type="integer", description="Идентификатор дня")
 * @SWG\Property(property="start", type="integer", description="Кол-во секунд от начала дня до начала смены")
 * @SWG\Property(property="end", type="integer", description="Кол-во секунд от начала дня до конца смены")
 */
class WorkShifts
{

}
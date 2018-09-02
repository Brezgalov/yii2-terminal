<?php
namespace app\models\forms\rules;

use yii\base\Model;
use app\models\Days;

/**
 * Форма создания нового правила (с инстансами сразу)
 */
class CreateForm extends Model
{
	public $day_id;
	public $quota;

	/**
     * @return array the validation rules.
     */
	public function rules()
	{
		return [
			[['day_id', 'quota'], 'safe'],
			[['day_id', 'quota'], 'required', 'message' => 'Поле {attribute} должно быть указано'],
			[['day_id', 'quota'], 'integer', 'min' => 0, 
				'message' => 'Значение поля {attribute} должно быть больше ноля',
			],
			// day_id needs to exist in the column "id" in the table defined in Days class 
			['day_id', 'exist', 'targetClass' => Days::class, 'targetAttribute' => ['day_id' => 'id'],
				'message' => 'День с идентификатором {value} не существует в системе',
			],    
		];
	}
}
<?php
namespace app\models\forms\rules;

use yii\base\Model;
use app\models\Days;
use app\models\Cultures;

/**
 * Форма создания нового правила (с инстансами сразу)
 */
class CreateForm extends Model
{
	public $day_id;
	public $quota;
	protected $culturesArray = [];

	/**
     * @return array the validation rules.
     */
	public function rules()
	{
		return [
			[['day_id', 'quota', 'cultures'], 'safe'],
			[['day_id', 'quota', 'cultures'], 'required', 'message' => 'Поле {attribute} должно быть указано'],
			[['day_id', 'quota'], 'integer', 'min' => 0, 
				'message' => 'Значение поля {attribute} должно быть больше ноля',
			],
			// day_id needs to exist in the column "id" in the table defined in Days class 
			['day_id', 'exist', 'targetClass' => Days::class, 'targetAttribute' => ['day_id' => 'id'],
				'message' => 'День с идентификатором {value} не существует в системе',
			],    
			[['cultures'], 'validateCultures'],
		];
	}

	public function getCultures()
	{
		return $this->culturesArray;
	}

	public function setCultures($value)
	{
		$this->culturesArray = $value;
	}

	/**
	 * Валидатор массива культур
	 *
	 * @param string $attribute
	 * @param array $params
	 * @param $validator
	 * @return void
	 */
	public function validateCultures($attribute, $params, $validator)
	{
		if (!is_array($this->{$attribute})) {
			$this->addErrors([$attribute => 'Параметр '.$attribute.' должен быть массивом']);
			return;
		}
		if (empty($attribute)) {
			$this->addErrors([$attribute => 'В параметре '.$attribute.' не указано ни одной культуры']);
			return;
		}
		
		foreach ($this->{$attribute} as $id) {
			$culturesFound = Cultures::find()->where(['=', 'id', $id])->count();
			if (!$culturesFound) {
				$this->addErrors([$attribute => 'Не удалось обнаружить культуру с id равным '. $id]);
			}
		}				
	}
}
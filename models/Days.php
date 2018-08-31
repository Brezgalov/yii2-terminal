<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "days".
 *
 * @property int $id
 * @property string $date
 *
 * @property WorkShifts[] $workShifts
 */
class Days extends \yii\db\ActiveRecord
{
    const DAY_FIRST_SECOND  = 0;
    const DAY_LAST_SECOND   = 86400;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'days';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required',  'message' => 'Не указана дата'],
            [['date'], 'unique',    'message' => 'Дата {value} уже зарегистрирована в системе'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkShifts()
    {
        return $this->hasMany(WorkShifts::className(), ['day_id' => 'id']);
    }

    /**
     * Удаляем ВСЕ связанные с днем таблицы, включая правила и тд
     * @param integer $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return bool
     */
    public static function deleteRels($id)
    {
        $ruleIds = Days::find()
            ->select(['days.id','work_shifts.id','rule_instances.*'])
            ->innerJoin('work_shifts', 'work_shifts.day_id = days.id')
            ->innerJoin('rule_instances', 'rule_instances.work_shift_id = work_shifts.id')
            ->where(['=', 'days.id', $id])
            ->groupBy(['rule_instances.rule_id'])
            ->asArray()
            ->all()
        ;
        $rules = Rules::find()->where(['in', 'id', array_column($ruleIds, 'rule_id')])->all();
        foreach ($rules as $rule) {
            if ($rule->delete() === false) {
                throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
            }
        }
        return true;
    }
}

<?php

namespace app\models;

use Yii;
use yii\db\Exception;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "work_shifts".
 *
 * @property int $id
 * @property int $day_id
 * @property int $start
 * @property int $end
 *
 * @property RuleInstances[] $ruleInstances
 * @property Days $day
 */
class WorkShifts extends \app\models\base\WorkShifts
{
    /**
     * Аггрегация, необходима при добавлении смены
     * @var array
     */
    protected $rulesAgg = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day_id', 'start', 'end'], 'required'],
            [['day_id'], 'integer'],
            [['day_id'], 'exist', 'skipOnError' => true, 'targetClass' => Days::className(), 'targetAttribute' => ['day_id' => 'id']],
            [['day_id'], 'validateWorkShiftsCount'],
            [['start', 'end'], 'integer', 'min' => Days::DAY_FIRST_SECOND, 'max' => Days::DAY_LAST_SECOND],
        ];
    }

    /**
     * Валидируем кол-во смен
     */
    public function validateWorkShiftsCount($attribute, $params, $validator)
    {
        $count = WorkShifts::find()->where(['=', $attribute, $this->{$attribute}])->count();
        if ($count > 1) {
            $min = (int) WorkShifts::find()
                ->where(['=', $attribute, $this->{$attribute}])
                ->min('start')
            ;
            $max = (int) WorkShifts::find()
                ->where(['=', $attribute, $this->{$attribute}])
                ->max('end');
            if ($min === Days::DAY_FIRST_SECOND && $max === Days::DAY_LAST_SECOND) {
                $this->addError($attribute, 'Этот день уже разбит на смены');
            }            
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRulesRel()
    {
        return $this->hasMany(Rules::className(), ['id' => 'rule_id'])
            ->via('ruleInstances')
        ;
    }

    /**
     * Сохраняем аггрегацию по правилам смен дня для внутр операций
     * @return void
     */
    public function saveRuleAgg()
    {
        $this->rulesAgg = WorkShifts::find()
            ->select([
                'work_shifts.*',
                'rule_instances.*',
                'SUM(rule_instances.count) as countTotal',
                'SUM(rule_instances.quota) as quotaTotal',
            ])
            ->innerJoin('rule_instances', 'rule_instances.work_shift_id = work_shifts.id')
            ->where(['=', 'day_id', $this->day_id])
            ->groupBy(['rule_id'])
            ->asArray()
            ->all()
        ;
    }

    protected function refetchCounts($dayId = null)
    {
        //@TODO: родить что-нибудь адекватное для обновления count
//        $dbDays = Days::find()
//            ->with('workShifts');
//        if (!empty($dayId)) {
//            $dbDays = $dbDays->where(['=', 'id', $dayId]);
//        }
//        $days = $dbDays->all();
//        foreach ($days as $day) {
//            foreach ($day->workShifts as $workShift) {
//                $left = strtotime($day->date) + $workShift->start;
//            }
//
//        }
    }

    /**
     * Вызов concatShifts убивает инстансы, нам нужно собрать их заного и правильно распределить квоты
     */
    protected function rebuildInstancesByAgg()
    {
        if (!empty($this->rulesAgg)) {
            $workShifts = WorkShifts::find()->where(['=', 'day_id', $this->day_id])->all();
            $workShiftsCount = count($workShifts);
            foreach ($this->rulesAgg as $agg) {
                $forOneSec = $agg['quota'] / Days::DAY_TOTAL_SECONDS;
                $sum = 0;
                for ($i = 0; $i < $workShiftsCount; $i++) {
                    $instance                = new RuleInstances();
                    $instance->rule_id       = $agg['rule_id'];
                    $instance->work_shift_id = $workShifts[$i]->id;
                    $instance->count=0;
                    $timePeriod = $workShifts[$i]->end - $workShifts[$i]->start;
                    if ($i + 1 !== $workShiftsCount) {
                        $instance->quota = round($timePeriod * $forOneSec);
                        $sum += $instance->quota;
                    } else {
                        $instance->quota = $agg['quota'] - $sum;
                    }
                    $instance->save();
                }
            }
        }
        $this->refetchCounts($this->day_id);
    }

    /**
     * Пересобирает начало и конец смен привязанных к дню
     * @return bool
     * @throws Exception
     */
    public function concatShifts()
    {
        $workShifts = WorkShifts::find()
            ->where(['=', 'day_id', $this->day_id])
            ->orderBy('start')
            ->asArray()
            ->all()
        ;
        if (empty($workShifts)) {
            return true;
        }

        $prepareBuild = [];//предполагается что существует смена 0-86400 
        $starts = array_column($workShifts, 'start');
        $ends   = array_column($workShifts, 'end');
        $times  = array_merge($starts, $ends);
        sort($times);
        for ($i = 0; $i < count($times)-1; $i++) {
            if ($times[$i+1] <= $times[$i]) {
                continue;
            }
            $prepareBuild[] = [$times[$i], $times[$i+1]];
        }
     
        WorkShifts::deleteAll('day_id = :day_id', [':day_id' => $this->day_id]);
        foreach ($prepareBuild as $timePeriod) {
            $tmp = new WorkShifts();
            $tmp->day_id = $this->day_id;
            $tmp->start = $timePeriod[0];
            $tmp->end   = $timePeriod[1];
            if (!$tmp->save()) {
                throw new Exception("Ошибка сохранения:". json_encode($tmp->errors) ." Обратитесь к администратору сервера.");
            }
        }
            
        $this->rebuildInstancesByAgg();
        return true;
    }
}

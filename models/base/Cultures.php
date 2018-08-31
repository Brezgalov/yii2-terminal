<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "cultures".
 *
 * @property int $id
 * @property string $name
 *
 * @property RuleCultures[] $ruleCultures
 */
class Cultures extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cultures';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleCultures()
    {
        return $this->hasMany(RuleCultures::className(), ['culture_id' => 'id']);
    }
}

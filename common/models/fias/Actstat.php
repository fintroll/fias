<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%actstat}}".
 *
 * @property int $ACTSTATID Идентификатор статуса (ключ)
 * @property string $NAME Наименование
 */
class Actstat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%actstat}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ACTSTATID', 'NAME'], 'required'],
            [['ACTSTATID'], 'integer'],
            [['NAME'], 'string', 'max' => 100],
            [['ACTSTATID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ACTSTATID' => 'Идентификатор статуса (ключ)',
            'NAME' => 'Наименование',
        ];
    }
}

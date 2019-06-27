<?php

namespace common\models\fias;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%actstat}}".
 *
 * @property int $ACTSTATID Идентификатор статуса (ключ)
 * @property string $NAME Наименование
 */
class Actstat extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName():string
    {
        return '{{%ACTSTAT}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules():array
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
    public function attributeLabels():array
    {
        return [
            'ACTSTATID' => 'Идентификатор статуса (ключ)',
            'NAME' => 'Наименование',
        ];
    }
}

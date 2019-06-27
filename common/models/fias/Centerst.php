<?php

namespace common\models\fias;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%centerst}}".
 *
 * @property int $CENTERSTID Идентификатор статуса
 * @property string $NAME Наименование
 */
class Centerst extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%CENTERST}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['CENTERSTID', 'NAME'], 'required'],
            [['CENTERSTID'], 'integer'],
            [['NAME'], 'string', 'max' => 100],
            [['CENTERSTID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'CENTERSTID' => 'Идентификатор статуса',
            'NAME' => 'Наименование',
        ];
    }
}

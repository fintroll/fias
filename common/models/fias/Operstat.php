<?php

namespace common\models\fias;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%operstat}}".
 *
 * @property int $OPERSTATID Идентификатор статуса (ключ)
 * @property string $NAME Наименование
 */
class Operstat extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%OPERSTAT}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['OPERSTATID', 'NAME'], 'required'],
            [['OPERSTATID'], 'integer'],
            [['NAME'], 'string', 'max' => 100],
            [['OPERSTATID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'OPERSTATID' => 'Идентификатор статуса (ключ)',
            'NAME' => 'Наименование',
        ];
    }
}

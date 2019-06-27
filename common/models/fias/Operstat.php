<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%operstat}}".
 *
 * @property int $OPERSTATID Идентификатор статуса (ключ)
 * @property string $NAME Наименование
 */
class Operstat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%OPERSTAT}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'OPERSTATID' => 'Идентификатор статуса (ключ)',
            'NAME' => 'Наименование',
        ];
    }
}

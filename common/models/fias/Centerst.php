<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%centerst}}".
 *
 * @property int $CENTERSTID Идентификатор статуса
 * @property string $NAME Наименование
 */
class Centerst extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%centerst}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'CENTERSTID' => 'Идентификатор статуса',
            'NAME' => 'Наименование',
        ];
    }
}

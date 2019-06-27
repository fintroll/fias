<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%eststat}}".
 *
 * @property int $ESTSTATID Признак владения
 * @property string $NAME Наименование
 * @property string $SHORTNAME Краткое наименование
 */
class Eststat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ESTSTAT}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ESTSTATID', 'NAME'], 'required'],
            [['ESTSTATID'], 'integer'],
            [['NAME', 'SHORTNAME'], 'string', 'max' => 20],
            [['ESTSTATID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ESTSTATID' => 'Признак владения',
            'NAME' => 'Наименование',
            'SHORTNAME' => 'Краткое наименование',
        ];
    }
}

<?php

namespace common\models\fias;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%eststat}}".
 *
 * @property int $ESTSTATID Признак владения
 * @property string $NAME Наименование
 * @property string $SHORTNAME Краткое наименование
 */
class Eststat extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%ESTSTAT}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
    {
        return [
            'ESTSTATID' => 'Признак владения',
            'NAME' => 'Наименование',
            'SHORTNAME' => 'Краткое наименование',
        ];
    }
}

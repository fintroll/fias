<?php

namespace common\models\fias;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%socrbase}}".
 *
 * @property int $LEVEL Уровень адресного объекта
 * @property string $SCNAME Краткое наименование типа объекта
 * @property string $SOCRNAME Полное наименование типа объекта
 * @property string $KOD_T_ST Ключевое поле
 */
class Socrbase extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%SOCRBASE}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['LEVEL', 'SOCRNAME', 'KOD_T_ST'], 'required'],
            [['LEVEL'], 'integer'],
            [['SCNAME'], 'string', 'max' => 10],
            [['SOCRNAME'], 'string', 'max' => 50],
            [['KOD_T_ST'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'LEVEL' => 'Уровень адресного объекта',
            'SCNAME' => 'Краткое наименование типа объекта',
            'SOCRNAME' => 'Полное наименование типа объекта',
            'KOD_T_ST' => 'Ключевое поле',
        ];
    }
}

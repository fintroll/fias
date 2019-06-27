<?php

namespace common\models\fias;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%flattype}}".
 *
 * @property int $FLTYPEID Тип помещения
 * @property string $NAME Наименование
 * @property string $SHORTNAME Краткое наименование
 */
class Flattype extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%FLATTYPE}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['FLTYPEID', 'NAME'], 'required'],
            [['FLTYPEID'], 'integer'],
            [['NAME', 'SHORTNAME'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'FLTYPEID' => 'Тип помещения',
            'NAME' => 'Наименование',
            'SHORTNAME' => 'Краткое наименование',
        ];
    }
}

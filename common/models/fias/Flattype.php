<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%flattype}}".
 *
 * @property int $FLTYPEID Тип помещения
 * @property string $NAME Наименование
 * @property string $SHORTNAME Краткое наименование
 */
class Flattype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%flattype}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'FLTYPEID' => 'Тип помещения',
            'NAME' => 'Наименование',
            'SHORTNAME' => 'Краткое наименование',
        ];
    }
}

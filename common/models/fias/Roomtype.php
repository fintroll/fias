<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%roomtype}}".
 *
 * @property int $RMTYPEID Тип комнаты
 * @property string $NAME Наименование
 * @property string $SHORTNAME Краткое наименование
 */
class Roomtype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%roomtype}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['RMTYPEID', 'NAME'], 'required'],
            [['RMTYPEID'], 'integer'],
            [['NAME', 'SHORTNAME'], 'string', 'max' => 20],
            [['RMTYPEID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'RMTYPEID' => 'Тип комнаты',
            'NAME' => 'Наименование',
            'SHORTNAME' => 'Краткое наименование',
        ];
    }
}

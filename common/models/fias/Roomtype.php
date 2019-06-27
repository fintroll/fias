<?php

namespace common\models\fias;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%roomtype}}".
 *
 * @property int $RMTYPEID Тип комнаты
 * @property string $NAME Наименование
 * @property string $SHORTNAME Краткое наименование
 */
class Roomtype extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%ROOMTYPE}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
    {
        return [
            'RMTYPEID' => 'Тип комнаты',
            'NAME' => 'Наименование',
            'SHORTNAME' => 'Краткое наименование',
        ];
    }
}

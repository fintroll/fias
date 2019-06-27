<?php

namespace common\models\fias;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%ndoctype}}".
 *
 * @property int $NDTYPEID Идентификатор записи (ключ)
 * @property string $NAME Наименование типа нормативного документа
 */
class Ndoctype extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%NDOCTYPE}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['NDTYPEID', 'NAME'], 'required'],
            [['NDTYPEID'], 'integer'],
            [['NAME'], 'string', 'max' => 250],
            [['NDTYPEID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'NDTYPEID' => 'Идентификатор записи (ключ)',
            'NAME' => 'Наименование типа нормативного документа',
        ];
    }
}

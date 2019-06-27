<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%ndoctype}}".
 *
 * @property int $NDTYPEID Идентификатор записи (ключ)
 * @property string $NAME Наименование типа нормативного документа
 */
class Ndoctype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%NDOCTYPE}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'NDTYPEID' => 'Идентификатор записи (ключ)',
            'NAME' => 'Наименование типа нормативного документа',
        ];
    }
}

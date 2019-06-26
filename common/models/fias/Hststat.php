<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%hststat}}".
 *
 * @property int $HOUSESTID Идентификатор статуса
 * @property string $NAME Наименование
 */
class Hststat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hststat}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HOUSESTID', 'NAME'], 'required'],
            [['HOUSESTID'], 'integer'],
            [['NAME'], 'string', 'max' => 60],
            [['HOUSESTID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'HOUSESTID' => 'Идентификатор статуса',
            'NAME' => 'Наименование',
        ];
    }
}

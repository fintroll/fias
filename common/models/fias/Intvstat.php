<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%intvstat}}".
 *
 * @property int $INTVSTATID Идентификатор статуса (обычный, четный, нечетный)
 * @property string $NAME Наименование
 */
class Intvstat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%intvstat}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['INTVSTATID', 'NAME'], 'required'],
            [['INTVSTATID'], 'integer'],
            [['NAME'], 'string', 'max' => 60],
            [['INTVSTATID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'INTVSTATID' => 'Идентификатор статуса (обычный, четный, нечетный)',
            'NAME' => 'Наименование',
        ];
    }
}

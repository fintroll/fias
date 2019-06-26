<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%curentst}}".
 *
 * @property int $CURENTSTID Идентификатор статуса (ключ)
 * @property string $NAME Наименование (0 - актуальный, 1-50, 2-98 – исторический (кроме 51), 51 - переподчиненный, 99 - несуществующий)
 */
class Curentst extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%curentst}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CURENTSTID', 'NAME'], 'required'],
            [['CURENTSTID'], 'integer'],
            [['NAME'], 'string', 'max' => 100],
            [['CURENTSTID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CURENTSTID' => 'Идентификатор статуса (ключ)',
            'NAME' => 'Наименование (0 - актуальный, 1-50, 2-98 – исторический (кроме 51), 51 - переподчиненный, 99 - несуществующий)',
        ];
    }
}

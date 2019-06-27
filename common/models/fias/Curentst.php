<?php

namespace common\models\fias;


use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%curentst}}".
 *
 * @property int $CURENTSTID Идентификатор статуса (ключ)
 * @property string $NAME Наименование (0 - актуальный, 1-50, 2-98 – исторический (кроме 51), 51 - переподчиненный, 99 - несуществующий)
 */
class Curentst extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%CURENTST}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
    {
        return [
            'CURENTSTID' => 'Идентификатор статуса (ключ)',
            'NAME' => 'Наименование (0 - актуальный, 1-50, 2-98 – исторический (кроме 51), 51 - переподчиненный, 99 - несуществующий)',
        ];
    }
}

<?php

namespace common\models\fias;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%intvstat}}".
 *
 * @property int $INTVSTATID Идентификатор статуса (обычный, четный, нечетный)
 * @property string $NAME Наименование
 */
class Intvstat extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%INTVSTAT}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
    {
        return [
            'INTVSTATID' => 'Идентификатор статуса (обычный, четный, нечетный)',
            'NAME' => 'Наименование',
        ];
    }
}

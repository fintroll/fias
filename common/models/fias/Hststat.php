<?php

namespace common\models\fias;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%hststat}}".
 *
 * @property int $HOUSESTID Идентификатор статуса
 * @property string $NAME Наименование
 */
class Hststat extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%HSTSTAT}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
    {
        return [
            'HOUSESTID' => 'Идентификатор статуса',
            'NAME' => 'Наименование',
        ];
    }
}

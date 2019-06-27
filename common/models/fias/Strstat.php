<?php

namespace common\models\fias;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%strstat}}".
 *
 * @property int $STRSTATID Признак строения
 * @property string $NAME Наименование
 * @property string $SHORTNAME Краткое наименование
 */
class Strstat extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%STRSTAT}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['STRSTATID', 'NAME'], 'required'],
            [['STRSTATID'], 'integer'],
            [['NAME', 'SHORTNAME'], 'string', 'max' => 20],
            [['STRSTATID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'STRSTATID' => 'Признак строения',
            'NAME' => 'Наименование',
            'SHORTNAME' => 'Краткое наименование',
        ];
    }
}

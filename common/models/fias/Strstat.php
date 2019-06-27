<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%strstat}}".
 *
 * @property int $STRSTATID Признак строения
 * @property string $NAME Наименование
 * @property string $SHORTNAME Краткое наименование
 */
class Strstat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%STRSTAT}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'STRSTATID' => 'Признак строения',
            'NAME' => 'Наименование',
            'SHORTNAME' => 'Краткое наименование',
        ];
    }
}

<?php

namespace common\models\fias;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%normdoc}}".
 *
 * @property string $NORMDOCID Идентификатор нормативного документа
 * @property string $DOCNAME Наименование документа
 * @property string $DOCDATE Дата документа
 * @property string $DOCNUM Номер документа
 * @property int $DOCTYPE Тип документа
 * @property string $DOCIMGID Идентификатор образа (внешний ключ)
 */
class Normdoc extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%NORMDOC}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['NORMDOCID', 'DOCTYPE'], 'required'],
            [['DOCDATE'], 'safe'],
            [['DOCTYPE'], 'integer'],
            [['NORMDOCID', 'DOCIMGID'], 'string', 'max' => 36],
            [['DOCNAME'], 'string', 'max' => 128],
            [['DOCNUM'], 'string', 'max' => 20],
            [['NORMDOCID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'NORMDOCID' => 'Идентификатор нормативного документа',
            'DOCNAME' => 'Наименование документа',
            'DOCDATE' => 'Дата документа',
            'DOCNUM' => 'Номер документа',
            'DOCTYPE' => 'Тип документа',
            'DOCIMGID' => 'Идентификатор образа (внешний ключ)',
        ];
    }
}

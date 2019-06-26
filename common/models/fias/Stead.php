<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%stead}}".
 *
 * @property string $STEADGUID Глобальный уникальный идентификатор адресного объекта (земельного участка)
 * @property string $NUMBER Номер земельного участка
 * @property string $REGIONCODE Код региона
 * @property string $POSTALCODE Почтовый индекс
 * @property string $IFNSFL Код ИФНС ФЛ
 * @property string $TERRIFNSFL Код территориального участка ИФНС ФЛ
 * @property string $IFNSUL Код ИФНС ЮЛ
 * @property string $TERRIFNSUL Код территориального участка ИФНС ЮЛ
 * @property string $OKATO OKATO
 * @property string $OKTMO OKTMO
 * @property string $UPDATEDATE Дата  внесения записи
 * @property string $PARENTGUID Идентификатор объекта родительского объекта
 * @property string $STEADID Уникальный идентификатор записи. Ключевое поле.
 * @property string $PREVID Идентификатор записи связывания с предыдушей исторической записью
 * @property string $NEXTID Идентификатор записи  связывания с последующей исторической записью
 * @property int $OPERSTATUS Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):
 * @property string $STARTDATE Начало действия записи
 * @property string $ENDDATE Окончание действия записи
 * @property string $NORMDOC Внешний ключ на нормативный документ
 * @property int $LIVESTATUS Признак действующего адресного объекта
 * @property string $CADNUM Кадастровый номер
 * @property int $DIVTYPE Тип адресации:
 */
class Stead extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stead}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['STEADGUID', 'REGIONCODE', 'UPDATEDATE', 'STEADID', 'OPERSTATUS', 'STARTDATE', 'ENDDATE', 'LIVESTATUS', 'DIVTYPE'], 'required'],
            [['UPDATEDATE', 'STARTDATE', 'ENDDATE'], 'safe'],
            [['OPERSTATUS', 'LIVESTATUS', 'DIVTYPE'], 'integer'],
            [['STEADGUID', 'PARENTGUID', 'STEADID', 'PREVID', 'NEXTID', 'NORMDOC'], 'string', 'max' => 36],
            [['NUMBER'], 'string', 'max' => 120],
            [['REGIONCODE'], 'string', 'max' => 2],
            [['POSTALCODE'], 'string', 'max' => 6],
            [['IFNSFL', 'TERRIFNSFL', 'IFNSUL', 'TERRIFNSUL'], 'string', 'max' => 4],
            [['OKATO', 'OKTMO'], 'string', 'max' => 11],
            [['CADNUM'], 'string', 'max' => 100],
            [['STEADID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'STEADGUID' => 'Глобальный уникальный идентификатор адресного объекта (земельного участка)',
            'NUMBER' => 'Номер земельного участка',
            'REGIONCODE' => 'Код региона',
            'POSTALCODE' => 'Почтовый индекс',
            'IFNSFL' => 'Код ИФНС ФЛ',
            'TERRIFNSFL' => 'Код территориального участка ИФНС ФЛ',
            'IFNSUL' => 'Код ИФНС ЮЛ',
            'TERRIFNSUL' => 'Код территориального участка ИФНС ЮЛ',
            'OKATO' => 'OKATO',
            'OKTMO' => 'OKTMO',
            'UPDATEDATE' => 'Дата  внесения записи',
            'PARENTGUID' => 'Идентификатор объекта родительского объекта',
            'STEADID' => 'Уникальный идентификатор записи. Ключевое поле.',
            'PREVID' => 'Идентификатор записи связывания с предыдушей исторической записью',
            'NEXTID' => 'Идентификатор записи  связывания с последующей исторической записью',
            'OPERSTATUS' => 'Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):',
            'STARTDATE' => 'Начало действия записи',
            'ENDDATE' => 'Окончание действия записи',
            'NORMDOC' => 'Внешний ключ на нормативный документ',
            'LIVESTATUS' => 'Признак действующего адресного объекта',
            'CADNUM' => 'Кадастровый номер',
            'DIVTYPE' => 'Тип адресации:',
        ];
    }
}

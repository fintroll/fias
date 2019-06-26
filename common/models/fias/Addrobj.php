<?php

namespace common\models\fias;

use Yii;

/**
 * This is the model class for table "{{%addrobj}}".
 *
 * @property string $AOGUID Глобальный уникальный идентификатор адресного объекта
 * @property string $FORMALNAME Формализованное наименование
 * @property string $REGIONCODE Код региона
 * @property string $AUTOCODE Код автономии
 * @property string $AREACODE Код района
 * @property string $CITYCODE Код города
 * @property string $CTARCODE Код внутригородского района
 * @property string $PLACECODE Код населенного пункта
 * @property string $PLANCODE Код элемента планировочной структуры
 * @property string $STREETCODE Код улицы
 * @property string $EXTRCODE Код дополнительного адресообразующего элемента
 * @property string $SEXTCODE Код подчиненного дополнительного адресообразующего элемента
 * @property string $OFFNAME Официальное наименование
 * @property string $POSTALCODE Почтовый индекс
 * @property string $IFNSFL Код ИФНС ФЛ
 * @property string $TERRIFNSFL Код территориального участка ИФНС ФЛ
 * @property string $IFNSUL Код ИФНС ЮЛ
 * @property string $TERRIFNSUL Код территориального участка ИФНС ЮЛ
 * @property string $OKATO OKATO
 * @property string $OKTMO OKTMO
 * @property string $UPDATEDATE Дата  внесения записи
 * @property string $SHORTNAME Краткое наименование типа объекта
 * @property int $AOLEVEL Уровень адресного объекта
 * @property string $PARENTGUID Идентификатор объекта родительского объекта
 * @property string $AOID Уникальный идентификатор записи. Ключевое поле.
 * @property string $PREVID Идентификатор записи связывания с предыдушей исторической записью
 * @property string $NEXTID Идентификатор записи  связывания с последующей исторической записью
 * @property string $CODE Код адресного объекта одной строкой с признаком актуальности из КЛАДР 4.0.
 * @property string $PLAINCODE Код адресного объекта из КЛАДР 4.0 одной строкой без признака актуальности (последних двух цифр)
 * @property int $ACTSTATUS Статус актуальности адресного объекта ФИАС. Актуальный адрес на текущую дату. Обычно последняя запись об адресном объекте.
 * @property int $CENTSTATUS Статус центра
 * @property int $OPERSTATUS Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):
 * @property int $CURRSTATUS Статус актуальности КЛАДР 4 (последние две цифры в коде)
 * @property string $STARTDATE Начало действия записи
 * @property string $ENDDATE Окончание действия записи
 * @property string $NORMDOC Внешний ключ на нормативный документ
 * @property int $LIVESTATUS Признак действующего адресного объекта
 * @property int $DIVTYPE
 */
class Addrobj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%addrobj}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AOGUID', 'FORMALNAME', 'REGIONCODE', 'AUTOCODE', 'AREACODE', 'CITYCODE', 'CTARCODE', 'PLACECODE', 'PLANCODE', 'EXTRCODE', 'SEXTCODE', 'UPDATEDATE', 'SHORTNAME', 'AOLEVEL', 'AOID', 'ACTSTATUS', 'CENTSTATUS', 'OPERSTATUS', 'CURRSTATUS', 'STARTDATE', 'ENDDATE', 'LIVESTATUS', 'DIVTYPE'], 'required'],
            [['UPDATEDATE', 'STARTDATE', 'ENDDATE'], 'safe'],
            [['AOLEVEL', 'ACTSTATUS', 'CENTSTATUS', 'OPERSTATUS', 'CURRSTATUS', 'LIVESTATUS', 'DIVTYPE'], 'integer'],
            [['AOGUID', 'PARENTGUID', 'AOID', 'PREVID', 'NEXTID', 'NORMDOC'], 'string', 'max' => 36],
            [['FORMALNAME', 'OFFNAME'], 'string', 'max' => 120],
            [['REGIONCODE'], 'string', 'max' => 2],
            [['AUTOCODE'], 'string', 'max' => 1],
            [['AREACODE', 'CITYCODE', 'CTARCODE', 'PLACECODE', 'SEXTCODE'], 'string', 'max' => 3],
            [['PLANCODE', 'STREETCODE', 'EXTRCODE', 'IFNSFL', 'TERRIFNSFL', 'IFNSUL', 'TERRIFNSUL'], 'string', 'max' => 4],
            [['POSTALCODE'], 'string', 'max' => 6],
            [['OKATO', 'OKTMO'], 'string', 'max' => 11],
            [['SHORTNAME'], 'string', 'max' => 10],
            [['CODE'], 'string', 'max' => 17],
            [['PLAINCODE'], 'string', 'max' => 15],
            [['AOID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AOGUID' => 'Глобальный уникальный идентификатор адресного объекта ',
            'FORMALNAME' => 'Формализованное наименование',
            'REGIONCODE' => 'Код региона',
            'AUTOCODE' => 'Код автономии',
            'AREACODE' => 'Код района',
            'CITYCODE' => 'Код города',
            'CTARCODE' => 'Код внутригородского района',
            'PLACECODE' => 'Код населенного пункта',
            'PLANCODE' => 'Код элемента планировочной структуры',
            'STREETCODE' => 'Код улицы',
            'EXTRCODE' => 'Код дополнительного адресообразующего элемента',
            'SEXTCODE' => 'Код подчиненного дополнительного адресообразующего элемента',
            'OFFNAME' => 'Официальное наименование',
            'POSTALCODE' => 'Почтовый индекс',
            'IFNSFL' => 'Код ИФНС ФЛ',
            'TERRIFNSFL' => 'Код территориального участка ИФНС ФЛ',
            'IFNSUL' => 'Код ИФНС ЮЛ',
            'TERRIFNSUL' => 'Код территориального участка ИФНС ЮЛ',
            'OKATO' => 'OKATO',
            'OKTMO' => 'OKTMO',
            'UPDATEDATE' => 'Дата  внесения записи',
            'SHORTNAME' => 'Краткое наименование типа объекта',
            'AOLEVEL' => 'Уровень адресного объекта ',
            'PARENTGUID' => 'Идентификатор объекта родительского объекта',
            'AOID' => 'Уникальный идентификатор записи. Ключевое поле.',
            'PREVID' => 'Идентификатор записи связывания с предыдушей исторической записью',
            'NEXTID' => 'Идентификатор записи  связывания с последующей исторической записью',
            'CODE' => 'Код адресного объекта одной строкой с признаком актуальности из КЛАДР 4.0. ',
            'PLAINCODE' => 'Код адресного объекта из КЛАДР 4.0 одной строкой без признака актуальности (последних двух цифр)',
            'ACTSTATUS' => 'Статус актуальности адресного объекта ФИАС. Актуальный адрес на текущую дату. Обычно последняя запись об адресном объекте.',
            'CENTSTATUS' => 'Статус центра',
            'OPERSTATUS' => 'Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):',
            'CURRSTATUS' => 'Статус актуальности КЛАДР 4 (последние две цифры в коде)',
            'STARTDATE' => 'Начало действия записи',
            'ENDDATE' => 'Окончание действия записи',
            'NORMDOC' => 'Внешний ключ на нормативный документ',
            'LIVESTATUS' => 'Признак действующего адресного объекта',
            'DIVTYPE' => 'Divtype',
        ];
    }
}

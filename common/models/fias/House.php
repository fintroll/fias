<?php

namespace common\models\fias;

use common\models\fias\HouseQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%house}}".
 *
 * @property string $POSTALCODE Почтовый индекс
 * @property string $REGIONCODE Код региона
 * @property string $IFNSFL Код ИФНС ФЛ
 * @property string $TERRIFNSFL Код территориального участка ИФНС ФЛ
 * @property string $IFNSUL Код ИФНС ЮЛ
 * @property string $TERRIFNSUL Код территориального участка ИФНС ЮЛ
 * @property string $OKATO OKATO
 * @property string $OKTMO OKTMO
 * @property string $UPDATEDATE Дата время внесения записи
 * @property string $HOUSENUM Номер дома
 * @property int $ESTSTATUS Признак владения
 * @property string $BUILDNUM Номер корпуса
 * @property string $STRUCNUM Номер строения
 * @property int $STRSTATUS Признак строения
 * @property string $HOUSEID Уникальный идентификатор записи дома
 * @property string $HOUSEGUID Глобальный уникальный идентификатор дома
 * @property string $AOGUID Guid записи родительского объекта (улицы, города, населенного пункта и т.п.)
 * @property string $STARTDATE Начало действия записи
 * @property string $ENDDATE Окончание действия записи
 * @property int $STATSTATUS Состояние дома
 * @property string $NORMDOC Внешний ключ на нормативный документ
 * @property int $COUNTER Счетчик записей домов для КЛАДР 4
 * @property string $CADNUM Кадастровый номер
 * @property int $DIVTYPE Тип адресации:
 *
 *
 * @property Addrobj $address Адрес
 * @property string $fullAddress Полный адрес
 * @property string $fullNumber Полный номер
 * @property string $streetNumber Полный номер
 */
class House extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%HOUSE}}';
    }


    /**
     * @return \common\models\fias\HouseQuery|ActiveQuery
     */
    public static function find()
    {
        return new HouseQuery(self::class);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['UPDATEDATE', 'ESTSTATUS', 'HOUSEID', 'HOUSEGUID', 'AOGUID', 'STARTDATE', 'ENDDATE', 'STATSTATUS', 'COUNTER', 'DIVTYPE'], 'required'],
            [['UPDATEDATE', 'STARTDATE', 'ENDDATE'], 'safe'],
            [['ESTSTATUS', 'STRSTATUS', 'STATSTATUS', 'COUNTER', 'DIVTYPE'], 'integer'],
            [['POSTALCODE'], 'string', 'max' => 6],
            [['REGIONCODE'], 'string', 'max' => 2],
            [['IFNSFL', 'TERRIFNSFL', 'IFNSUL', 'TERRIFNSUL'], 'string', 'max' => 4],
            [['OKATO', 'OKTMO'], 'string', 'max' => 11],
            [['HOUSENUM'], 'string', 'max' => 20],
            [['BUILDNUM', 'STRUCNUM'], 'string', 'max' => 10],
            [['HOUSEID', 'HOUSEGUID', 'AOGUID', 'NORMDOC'], 'string', 'max' => 36],
            [['CADNUM'], 'string', 'max' => 100],
            [['HOUSEID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'POSTALCODE' => 'Почтовый индекс',
            'REGIONCODE' => 'Код региона',
            'IFNSFL' => 'Код ИФНС ФЛ',
            'TERRIFNSFL' => 'Код территориального участка ИФНС ФЛ',
            'IFNSUL' => 'Код ИФНС ЮЛ',
            'TERRIFNSUL' => 'Код территориального участка ИФНС ЮЛ',
            'OKATO' => 'OKATO',
            'OKTMO' => 'OKTMO',
            'UPDATEDATE' => 'Дата время внесения записи',
            'HOUSENUM' => 'Номер дома',
            'ESTSTATUS' => 'Признак владения',
            'BUILDNUM' => 'Номер корпуса',
            'STRUCNUM' => 'Номер строения',
            'STRSTATUS' => 'Признак строения',
            'HOUSEID' => 'Уникальный идентификатор записи дома',
            'HOUSEGUID' => 'Глобальный уникальный идентификатор дома',
            'AOGUID' => 'Guid записи родительского объекта (улицы, города, населенного пункта и т.п.)',
            'STARTDATE' => 'Начало действия записи',
            'ENDDATE' => 'Окончание действия записи',
            'STATSTATUS' => 'Состояние дома',
            'NORMDOC' => 'Внешний ключ на нормативный документ',
            'COUNTER' => 'Счетчик записей домов для КЛАДР 4',
            'CADNUM' => 'Кадастровый номер',
            'DIVTYPE' => 'Тип адресации:',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Addrobj::class, ['AOGUID' => 'AOGUID']);
    }

    /**
     * @return mixed|string
     */
    public function getFullAddress()
    {
        $address = isset($this->address) ? $this->POSTALCODE.', '.$this->address->fullAddress : '';

        $address .= ', '. $this->fullNumber;

        return $address;
    }

    /**
     * @return string
     */
    public function getFullNumber()
    {
        $number = $this->HOUSENUM;

        if (!empty($this->BUILDNUM)) {
            $number .= ' к' . $this->BUILDNUM;
        }

        if (!empty($this->STRUCNUM)) {
            $number .= ' стр. ' . $this->STRUCNUM;
        }

        return $number;
    }

    /**
     * @return string
     */
    public function getStreetNumber()
    {
        return !empty($this->address) ? $this->address->fullName.' д.'.$this->fullNumber : $this->fullNumber;
    }
}
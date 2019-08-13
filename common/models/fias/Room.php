<?php

namespace common\models\fias;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%room}}".
 *
 * @property string $ROOMGUID Глобальный уникальный идентификатор адресного объекта (помещения)
 * @property string $FLATNUMBER Номер помещения или офиса
 * @property int $FLATTYPE Тип помещения
 * @property string $ROOMNUMBER Номер комнаты
 * @property int $ROOMTYPE Тип комнаты
 * @property string $REGIONCODE Код региона
 * @property string $POSTALCODE Почтовый индекс
 * @property string $UPDATEDATE Дата  внесения записи
 * @property string $HOUSEGUID Идентификатор родительского объекта (дома)
 * @property string $ROOMID Уникальный идентификатор записи. Ключевое поле.
 * @property string $PREVID Идентификатор записи связывания с предыдушей исторической записью
 * @property string $NEXTID Идентификатор записи  связывания с последующей исторической записью
 * @property string $STARTDATE Начало действия записи
 * @property string $ENDDATE Окончание действия записи
 * @property int $LIVESTATUS Признак действующего адресного объекта
 * @property string $NORMDOC Внешний ключ на нормативный документ
 * @property int $OPERSTATUS Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):
 * @property string $CADNUM Кадастровый номер помещения
 * @property string $ROOMCADNUM Кадастровый номер комнаты в помещении
 *
 * @property House $house Адрес
 * @property Flattype $flatType тип помещения
 * @property string $flatLabel тип помещения(сокр)
 * @property Roomtype $roomType тип помещения
 * @property string $roomLabel тип помещения(сокр)
 * @property string $fullAddress тип помещения(сокр)
 * @property string $fullNumber номер + сокращение
 */
class Room extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%ROOM}}';
    }


    /**
     * @return RoomQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new RoomQuery(self::class);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['ROOMGUID', 'FLATNUMBER', 'FLATTYPE', 'REGIONCODE', 'UPDATEDATE', 'HOUSEGUID', 'ROOMID', 'STARTDATE', 'ENDDATE', 'LIVESTATUS', 'OPERSTATUS'], 'required'],
            [['FLATTYPE', 'ROOMTYPE', 'LIVESTATUS', 'OPERSTATUS'], 'integer'],
            [['UPDATEDATE', 'STARTDATE', 'ENDDATE'], 'safe'],
            [['ROOMGUID', 'HOUSEGUID', 'ROOMID', 'PREVID', 'NEXTID', 'NORMDOC'], 'string', 'max' => 36],
            [['FLATNUMBER', 'ROOMNUMBER'], 'string', 'max' => 50],
            [['REGIONCODE'], 'string', 'max' => 2],
            [['POSTALCODE'], 'string', 'max' => 6],
            [['CADNUM', 'ROOMCADNUM'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'ROOMGUID' => 'Глобальный уникальный идентификатор адресного объекта (помещения)',
            'FLATNUMBER' => 'Номер помещения или офиса',
            'FLATTYPE' => 'Тип помещения',
            'ROOMNUMBER' => 'Номер комнаты',
            'ROOMTYPE' => 'Тип комнаты',
            'REGIONCODE' => 'Код региона',
            'POSTALCODE' => 'Почтовый индекс',
            'UPDATEDATE' => 'Дата  внесения записи',
            'HOUSEGUID' => 'Идентификатор родительского объекта (дома)',
            'ROOMID' => 'Уникальный идентификатор записи. Ключевое поле.',
            'PREVID' => 'Идентификатор записи связывания с предыдушей исторической записью',
            'NEXTID' => 'Идентификатор записи  связывания с последующей исторической записью',
            'STARTDATE' => 'Начало действия записи',
            'ENDDATE' => 'Окончание действия записи',
            'LIVESTATUS' => 'Признак действующего адресного объекта',
            'NORMDOC' => 'Внешний ключ на нормативный документ',
            'OPERSTATUS' => 'Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):',
            'CADNUM' => 'Кадастровый номер помещения',
            'ROOMCADNUM' => 'Кадастровый номер комнаты в помещении',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHouse()
    {
        return $this->hasOne(House::class, ['HOUSEGUID' => 'HOUSEGUID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlatType()
    {
        return $this->hasOne(Flattype::class, ['FLTYPEID' => 'FLATTYPE']);
    }

    /**
     * @return string
     */
    public function getFlatLabel(): string
    {
        return $this->flatType !== null ? $this->flatType->SHORTNAME . ' ' . $this->FLATNUMBER : $this->FLATNUMBER;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomType()
    {
        return $this->hasOne(Flattype::class, ['RMTYPEID' => 'ROOMTYPE']);
    }

    /**
     * @return string
     */
    public function getRoomLabel(): string
    {
        return $this->roomType !== null ? $this->roomType->SHORTNAME . ' ' . $this->ROOMNUMBER : $this->ROOMNUMBER;
    }

    /**
     * @return string
     */
    public function getFullAddress(): string
    {
        $address = ($this->house !== null && $this->house->fullAddress !== null) ? $this->house->fullAddress : $this->FLATNUMBER ?? $this->ROOMNUMBER;

        if (!empty($this->flatLabel)) {
            $address .= ', ' . $this->flatLabel;
        }
        if (!empty($this->roomLabel)) {
            $address .= ', ' . $this->roomLabel;
        }

        return $address;
    }

    /**
     * @return string
     */
    public function getFullNumber(): string
    {
        return $this->flatLabel ?? $this->roomLabel ?? '';
    }
}

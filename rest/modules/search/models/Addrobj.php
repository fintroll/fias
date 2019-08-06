<?php

namespace rest\modules\search\models;

use common\models\fias\Socrbase;
use yii\db\ActiveQuery;
use yii\sphinx\ActiveRecord;

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
 *
 * @property \common\models\fias\Addrobj $parent
 * @property Addrobj[] $parentsTree
 * @property string[] $treeRecursive
 * @property array $parents
 * @property string $fullAddress
 * @property string $fullName
 * @property Socrbase $socrBase
 */
class Addrobj extends ActiveRecord
{
    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function indexName()
    {
        return 'ao_index_test1';
    }

    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'value' => 'fullAddress',
            'id' => 'AOGUID',
            'name' => 'fullName',
            'treeRecursive'
        ];
    }

    /**
     * @return AddrobjQuery
     */
    public static function find()
    {
        return new AddrobjQuery(self::class);
    }

    public function extraFields(): array
    {
        return [
            'regioncode' => 'REGIONCODE',
            'autocode' => 'AUTOCODE',
            'areacode' => 'AREACODE',
            'citycode' => 'CITYCODE',
            'ctarcode' => 'CTARCODE',
            'placecode' => 'PLACECODE',
            'plancode' => 'PLANCODE',
            'streetcode' => 'STREETCODE',
            'extrcode' => 'EXTRCODE',
            'sextcode' => 'SEXTCODE',
            'offname' => 'OFFNAME',
            'shortname' => 'SHORTNAME',
            'parentguid' => 'PARENTGUID',
            'plaincode' => 'PLAINCODE',
            'actstatus' => 'ACTSTATUS',
            'centstatus' => 'CENTSTATUS',
            'operstatus' => 'OPERSTATUS',
            'currstatus' => 'CURRSTATUS',
            'livestatus' => 'LIVESTATUS',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
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


    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getParent()
    {
        return $this->hasOne(static::class, ['AOGUID' => 'PARENTGUID']);
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getSocrBase()
    {
        return $this->hasOne(Socrbase::class, ['SCNAME' => 'SHORTNAME']);
    }


    /**
     * Полный адрес
     *
     * @return string
     */
    public function getFullAddress(): string
    {
        $address = $this->getAddressRecursive();
        $addresses = explode(';', $address);
        $addresses = array_reverse($addresses);
        return implode(', ', $addresses);
    }

    /**
     * Полный название
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->replaceTitle();
    }

    /**
     * @return string
     */
    protected function getAddressRecursive(): string
    {
        $address = $this->replaceTitle();
        if ($this->parent !== null) {
            $address .= ';' . $this->parent->getAddressRecursive();
        }
        return $address;
    }

    public function getTreeRecursive()
    {
        $result = [
            $this->replaceObjectLevelFiasID() => $this->AOGUID,
            $this->replaceObjectLevelFiasValue() => $this->replaceTitle()
        ];
        if ($this->parent !== null){
            $result = array_merge($result, $this->parent->getTreeRecursive());
        }
        return $result;
    }

    /**
     * @return array
     */
    protected function getParentsTree(): array
    {
        $result = [];
        if ($this->PARENTGUID !== null) {
            $result[] = $this->parent;
        }
        return $result;
    }

    /**
     * Добавить отформатированный префикс к тайтлу
     *
     * @return string
     */
    protected function replaceTitle(): string
    {
        switch ($this->SHORTNAME) {
            case 'обл':
                return $this->FORMALNAME . ' ' . $this->SHORTNAME;
            case 'край':
                return $this->FORMALNAME . ' ' . $this->SHORTNAME;
            case 'р-н':
                return $this->FORMALNAME . ' ' . $this->SHORTNAME;
            case 'проезд':
                return $this->FORMALNAME . ' ' . $this->SHORTNAME;
            case 'б-р':
                return $this->FORMALNAME . ' ' . $this->SHORTNAME;
            case 'пер':
                return $this->FORMALNAME . ' ' . $this->SHORTNAME;
            case 'ал':
                return $this->FORMALNAME . ' ' . $this->SHORTNAME;
            case 'ш':
                return $this->FORMALNAME . ' ' . $this->SHORTNAME;
            case 'г':
                return $this->FORMALNAME . ' ' . $this->SHORTNAME;
            case 'линия':
                return $this->SHORTNAME . ' ' . $this->FORMALNAME;
            case 'ул':
                return $this->SHORTNAME . ' ' . $this->FORMALNAME;
            case 'пр-кт':
                return $this->FORMALNAME . ' ' . $this->SHORTNAME;
            default:
                return trim($this->SHORTNAME . '. ' . $this->FORMALNAME);
        }
    }


    protected function replaceObjectLevelFiasID(): string
    {
        switch ($this->AOLEVEL) {
            case '1':
            case '2':
            case '3':
                return 'region_level_fias_id';
            case '4':
            case '5':
            case '6':
            case '35':
            case '65':
                return 'city_level_fias_id';
            case '7':
            case '91':
                return 'street_level_fias_id';
            default:
                return 'unrestricted_level_fias_id';
        }
    }

    /**
     * @return string
     */
    protected function replaceObjectLevelFiasValue(): string
    {
        switch ($this->AOLEVEL) {
            case '1':
            case '2':
            case '3':
                return 'region_level_fias_value';
            case '4':
            case '5':
            case '6':
            case '35':
            case '65':
                return 'city_level_fias_value';
            case '7':
            case '91':
                return 'street_level_fias_value';
            default:
                return 'unrestricted_level_fias_value';
        }
    }
}

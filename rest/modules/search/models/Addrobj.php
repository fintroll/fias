<?php

namespace rest\modules\search\models;

use common\models\fias\Socrbase;
use yii\sphinx\ActiveRecord;
use yii\sphinx\Query;

/**
 *
 * @property string $id
 * @property string $aoguid
 * @property string $formalname
 * @property string $shortname
 * @property string $aolevel
 * @property string $parentguid
 * @property string $actstatus
 * @property string $livestatus
 * @property string $fullname

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
     * @return \yii\sphinx\ActiveQuery|Query
     */
    public static function find()
    {
        return (new Query())->from('ao_index_test1');
    }

    public function extraFields(): array
    {
        return [
            'id',
            'aoguid',
            'formalname',
            'shortname',
            'aolevel',
            'parentguid',
            'actstatus',
            'livestatus',
            'fullname',
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
        return $this->hasOne(static::class, ['aoguid' => 'parentguid']);
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
    public function getAddressRecursive(): string
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
        if ($this->parentguid !== null) {
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
        switch ($this->shortname) {
            case 'обл':
                return $this->formalname . ' ' . $this->shortname;
            case 'край':
                return $this->formalname . ' ' . $this->shortname;
            case 'р-н':
                return $this->formalname . ' ' . $this->shortname;
            case 'проезд':
                return $this->formalname . ' ' . $this->shortname;
            case 'б-р':
                return $this->formalname . ' ' . $this->shortname;
            case 'пер':
                return $this->formalname . ' ' . $this->shortname;
            case 'ал':
                return $this->formalname . ' ' . $this->shortname;
            case 'ш':
                return $this->formalname . ' ' . $this->shortname;
            case 'г':
                return $this->formalname . ' ' . $this->shortname;
            case 'линия':
                return $this->shortname . ' ' . $this->formalname;
            case 'ул':
                return $this->shortname . ' ' . $this->formalname;
            case 'пр-кт':
                return $this->formalname . ' ' . $this->shortname;
            default:
                return trim($this->shortname . '. ' . $this->formalname);
        }
    }


    protected function replaceObjectLevelFiasID(): string
    {
        switch ($this->aolevel) {
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
        switch ($this->aolevel) {
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

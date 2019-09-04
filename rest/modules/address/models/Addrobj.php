<?php

namespace rest\modules\address\models;

use common\models\fias\Addrobj as CommonAddrobj;
use common\models\fias\Socrbase;

/**
 *
 * @property string $AOGUID
 * @property string $FORMALNAME
 * @property string $SHORTNAME
 * @property string $AOLEVEL
 * @property string $PARENTGUID
 * @property string $ACTSTATUS
 * @property string $LIVESTATUS
 * @property string $FULLNAME
 *
 * @property Addrobj $parent
 * @property Addrobj[] $parentsTree
 * @property string[] $treeRecursive
 * @property string[] $inversionRecursive
 * @property array $parents
 * @property string $fullAddress
 * @property string $fullObjectName
 * @property Socrbase $socrBase
 */
class Addrobj extends CommonAddrobj
{

    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'fullAddress',
            'aoid' => 'AOID',
            'aoguid' => 'AOGUID',
            'postalcode' => 'POSTALCODE',
            'formalname' => 'FORMALNAME',
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
    public function getFullObjectName(): string
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
        if ($this->parent !== null) {
            $result = array_merge($result, $this->parent->getTreeRecursive());
        }
        return $result;
    }

    public function getInversionRecursive()
    {
        $result = [
            $this->replaceObjectLevelFiasID() => $this->AOGUID,
            $this->replaceObjectLevelFiasValue() => $this->replaceTitle()
        ];
        if ($this->parent !== null) {
            $result = array_merge($result, $this->parent->getInversionRecursive());
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

    /**
     * @return string
     */
    protected function replaceObjectLevelInversionType(): string
    {
        switch ($this->AOLEVEL) {
            case '1':
            case '2':
                return 'inversion_region_id';
            case '3':
                return 'inversion_district_type';
            case '4':
            case '5':
            case '6':
            case '35':
            case '65':
                return 'inversion_city_type';
            case '7':
            case '91':
                return 'inversion_street_type';
            default:
                return 'inversion_unrestricted_type';
        }
    }

    /**
     * @return string
     */
    protected function replaceObjectLevelInversionValue(): string
    {
        switch ($this->AOLEVEL) {
            case '1':
            case '2':
                return 'inversion_region_id';
            case '3':
                return 'inversion_district_type';
            case '4':
            case '5':
            case '6':
            case '35':
            case '65':
                return 'inversion_city_type';
            case '7':
            case '91':
                return 'inversion_street_type';
            default:
                return 'inversion_unrestricted_type';
        }
    }
}

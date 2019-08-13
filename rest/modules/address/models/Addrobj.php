<?php

namespace rest\modules\address\models;

use common\models\fias\Addrobj as CommonAddrobj;
use common\models\fias\Socrbase;

/**
 *
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
            $this->replaceObjectLevelFiasID() => $this->aoguid,
            $this->replaceObjectLevelFiasValue() => $this->replaceTitle()
        ];
        if ($this->parent !== null) {
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

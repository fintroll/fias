<?php

namespace rest\modules\address\models;

use common\models\fias\Addrobj as CommonAddrobj;

/**
 * Class Addrobj
 * @package rest\modules\address\models
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
}

<?php

namespace rest\modules\search\models;

use common\models\fias\Addrobj as CommonAddrobj;

/**
 * Class Addrobj
 * @package rest\modules\search\models
 */
class Addrobj extends CommonAddrobj
{

    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'value' => 'fullAddress',
            'id' => 'AOGUID',
        ];
    }

    public function extraFields(): array
    {
        return [
            'postalcode' => 'POSTALCODE',
            'formalname' => 'FORMALNAME',
            'parentsTree',
            'aoid' => 'AOID',
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

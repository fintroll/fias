<?php

namespace rest\modules\address\models;

use common\models\fias\Stead as CommonStead;

/**
 * Class Stead
 * @package rest\modules\address\models
 */
class Stead extends CommonStead
{
    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'steadguid' => 'STEADGUID',
            'number' => 'NUMBER',
            'regioncode' => 'REGIONCODE',
            'postalcode' => 'POSTALCODE',
            'ifnsfl' => 'IFNSFL',
            'terrifnsfl' => 'TERRIFNSFL',
            'ifnsul' => 'IFNSUL',
            'terrifnsul' => 'TERRIFNSUL',
            'okato' => 'OKATO',
            'oktmo' => 'OKTMO',
            'updatedate' => 'UPDATEDATE',
            'parentguid' => 'PARENTGUID',
            'steadid' => 'STEADID',
            'previd' => 'PREVID',
            'nextid' => 'NEXTID',
            'operstatus' => 'OPERSTATUS',
            'startdate' => 'STARTDATE',
            'enddate' => 'ENDDATE',
            'normdoc' => 'NORMDOC',
            'livestatus' => 'LIVESTATUS',
            'cadnum' => 'CADNUM',
            'divtype' => 'DIVTYPE',
        ];
    }
}

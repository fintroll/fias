<?php

namespace rest\modules\address\models;

use Yii;


class Addrobj extends \common\models\fias\Addrobj
{

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'aoguid' => 'AOGUID',
            'formalname' => 'FORMALNAME',
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
            'postalcode' => 'POSTALCODE',
            'ifnsfl' => 'IFNSFL',
            'terrifnsfl' => 'TERRIFNSFL',
            'ifnsul' => 'IFNSUL',
            'terrifnsul' => 'TERRIFNSUL',
            'okato' => 'OKATO',
            'oktmo' => 'OKTMO',
            'updatedate' => 'UPDATEDATE',
            'shortname' => 'SHORTNAME',
            'aolevel' => 'AOLEVEL',
            'parentguid' => 'PARENTGUID',
            'aoid' => 'AOID',
            'previd' => 'PREVID',
            'nextid' => 'NEXTID',
            'code' => 'CODE',
            'plaincode' => 'PLAINCODE',
            'actstatus' => 'ACTSTATUS',
            'centstatus' => 'CENTSTATUS',
            'operstatus' => 'OPERSTATUS',
            'currstatus' => 'CURRSTATUS',
            'startdate' => 'STARTDATE',
            'enddate' => 'ENDDATE',
            'normdoc' => 'NORMDOC',
            'livestatus' => 'LIVESTATUS',
            'divtype' => 'DIVTYPE',
        ];
    }
}

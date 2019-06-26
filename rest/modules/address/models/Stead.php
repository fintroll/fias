<?php

namespace rest\modules\address\models;

use Yii;


class Stead extends \common\models\fias\Stead
{




    /**
     * {@inheritdoc}
     */
    public function fields()
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

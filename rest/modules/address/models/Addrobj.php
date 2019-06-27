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
            'fullAddress',
            'aoid' => 'AOID',
            'aoguid' => 'AOGUID',
            'postalcode' => 'POSTALCODE',
            'formalname' => 'FORMALNAME',
            'parentsTree'
        ];
    }

    public function extraFields()
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

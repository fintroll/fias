<?php

namespace rest\modules\address\models;

use Yii;


class House extends \common\models\fias\House
{
 /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'fullAddress',
            'houseid' => 'HOUSEID',
            'houseguid' => 'HOUSEGUID',
            'housenum' => 'HOUSENUM',
            'eststatus' => 'ESTSTATUS',
            'buildnum' => 'BUILDNUM',
            'strucnum' => 'STRUCNUM',
            'address'
        ];
    }

    public function extraFields()
    {
        return [
            'aoguid' => 'AOGUID',
            'cadnum' => 'CADNUM',
            'normdoc' => 'NORMDOC',
            'counter' => 'COUNTER',
            'strstatus' => 'STRSTATUS',
            'statstatus' => 'STATSTATUS',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Addrobj::class, ['AOGUID' => 'AOGUID']);
    }
}

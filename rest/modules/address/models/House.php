<?php

namespace rest\modules\address\models;

use common\models\fias\House as CommonHouse;

/**
 * Class House
 * @package rest\modules\address\models
 */
class House extends CommonHouse
{
    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'fullAddress',
            'houseguid' => 'HOUSEGUID',
            'value' => 'streetNumber',
            'id' => 'HOUSEID',
            'type' => 'house',
            'postalcode' => 'POSTALCODE',
            'number' => 'fullNumber',
        ];
    }

    public function extraFields(): array
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

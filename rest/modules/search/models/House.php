<?php

namespace rest\modules\search\models;
use rest\modules\address\models\Addrobj as FindAddresAddrobj;
use common\models\fias\House as CommonHouse;

/**
 * Class House
 * @package rest\modules\search\models
 */
class House extends CommonHouse
{
    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'value' => 'streetNumber',
            'id' => 'HOUSEGUID',
            'postalcode' => 'POSTALCODE',
            'number' => 'fullNumber',
            'fullAddress',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(FindAddresAddrobj::class, ['AOGUID' => 'AOGUID']);
    }
}

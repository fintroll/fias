<?php

namespace rest\modules\search\models;

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

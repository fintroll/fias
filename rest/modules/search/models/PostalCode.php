<?php

namespace rest\modules\search\models;



/**
 * Class PostalCode
 * @package rest\modules\search\models
 */
class PostalCode extends House
{
    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'value' => 'fullAddress',
            'id' => 'HOUSEGUID',
            'postalcode' => 'POSTALCODE',
            'number' => 'fullNumber',
            'parentsTree' => function (PostalCode $model) {
                return $model->address->parentsTree;
            },
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

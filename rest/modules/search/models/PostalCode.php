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
            'houseguid' => 'HOUSEGUID',
            'house_number' => 'fullNumber',
            'fields' => function (PostalCode $model) {
                return $model->address->treeRecursive;
            },
            'treeRecursive' =>  function(PostalCode $model) {
                return $model->address->treeRecursive;
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

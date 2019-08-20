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
            'value' => 'streetNumber',
            'id' => 'HOUSEGUID',
            'type' => function () {
                return 'house';
            },
            'postalcode' => 'POSTALCODE',
            'number' => 'fullNumber',
            'treeRecursive' => function (House $model) {
                return $model->address->treeRecursive;
            },
        ];
    }

    /**
     * @return HouseQuery
     */
    public static function find()
    {
        return new HouseQuery(self::class);
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

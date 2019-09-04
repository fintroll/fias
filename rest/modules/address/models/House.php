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
            'id' => 'HOUSEID',
            'fullAddress',
            'value' => 'streetNumber',
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


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Addrobj::class, ['AOGUID' => 'AOGUID']);
    }
}

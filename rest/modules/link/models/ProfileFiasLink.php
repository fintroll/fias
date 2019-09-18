<?php

namespace rest\modules\link\models;

use common\models\fias\ProfileFiasLink as CommonLink;
use rest\modules\address\models\Addrobj;
use rest\modules\address\models\House;
use yii\helpers\ArrayHelper;

/**
 * Class ProfileFiasLink
 * @package rest\modules\link\models
 */
class ProfileFiasLink extends CommonLink
{
    public function fields()
    {
        return [
            'project_profile_id',
            'id' => function (CommonLink $model) {
                $result = '';
                if ($model->fiasData !== null) {
                    $result = $model->fiasData instanceof House ? $model->fiasData->HOUSEGUID : $model->fiasData->AOGUID;
                }
                return $result;
            },
            'full_address' => function (CommonLink $model) {
                $result = '';
                $fiasObject = $model->fiasData;

                if ($fiasObject !== null) {
                    if ($model->fiasData instanceof Addrobj) {
                        $result = $model->postal . ', ' . $fiasObject->fullAddress . ', ' . $model->house . ', ' . $model->apartment;
                    } else {
                        $result = $fiasObject->fullAddress . ', ' . $model->apartment;
                    }
                }
                return $result;
            },
            'fias_leval_type' => function (CommonLink $model) {
                $result = '';
                if ($model->fiasData !== null) {
                    $result = $model->fiasData instanceof House ? 'house' : 'address';
                }
                return $result;
            },
            'house' => function (CommonLink $model) {
                return $model->house ?? '';
            },
            'postal' => function (CommonLink $model) {
                return $model->postal ?? '';
            },
            'apartment' => function (CommonLink $model) {
                return $model->apartment ?? '';
            },
            'fias_data' => 'fiasData',
            'inversion' => function (CommonLink $model) {
                $inversion = $model->fiasData instanceof House ? ArrayHelper::getValue($model, 'fiasData.address.inversionRecursive') : ArrayHelper::getValue($model, 'fiasData.inversionRecursive');
                $fiasDataAddress = $model->fiasData instanceof House ? ArrayHelper::getValue($model, 'fiasData.address') : ArrayHelper::getValue($model, 'fiasData');
                $fiasHouse = $model->fiasData instanceof House ? ArrayHelper::getValue($model, 'fiasData', []) : [];
                return [
                    'inversion_oksm' => 643,
                    'inversion_postalcode' => ArrayHelper::getValue($model, 'fiasData.POSTALCODE') ?? $model->postal ?? "",
                    'inversion_region_code' => ArrayHelper::getValue($fiasDataAddress, 'REGIONCODE'),
                    'inversion_region_name' => ArrayHelper::getValue($inversion, 'inversion_region_name') ?? "",
                    'inversion_region_type' => ArrayHelper::getValue($inversion, 'inversion_region_type') ?? "",
                    'inversion_district_name' => ArrayHelper::getValue($inversion, 'inversion_district_name') ?? "",
                    'inversion_district_type' => ArrayHelper::getValue($inversion, 'inversion_district_type') ?? "",
                    'inversion_city_name' => ArrayHelper::getValue($inversion, 'inversion_city_name') ?? "",
                    'inversion_city_type' => ArrayHelper::getValue($inversion, 'inversion_city_type') ?? "",
                    'inversion_street_name' => ArrayHelper::getValue($inversion, 'inversion_street_name') ?? "",
                    'inversion_street_type' => ArrayHelper::getValue($inversion, 'inversion_street_type') ?? "",
                    'inversion_house' => ArrayHelper::getValue($fiasHouse, 'HOUSENUM') ?? ArrayHelper::getValue($model, 'house') ?? "",
                    'inversion_house_building' => ArrayHelper::getValue($fiasHouse, 'BUILDNUM') ?? "",
                    'inversion_house_structure' => ArrayHelper::getValue($fiasHouse, 'STRUCNUM') ?? "",
                    'inversion_apartment' => ArrayHelper::getValue($model, 'apartment') ?? "",
                ];
            },
            'nbch' => function (CommonLink $model) {
                $treeRecursive = $model->fiasData instanceof House ? ArrayHelper::getValue($model, 'fiasData.address.treeRecursive') : ArrayHelper::getValue($model, 'fiasData.treeRecursive');
                $fiasDataAddress = $model->fiasData instanceof House ? ArrayHelper::getValue($model, 'fiasData.address') : ArrayHelper::getValue($model, 'fiasData');
                $fiasHouse = $model->fiasData instanceof House ? ArrayHelper::getValue($model, 'fiasData', []) : [];
                return [
                    'registrationAddressRegionCode' => ArrayHelper::getValue($fiasDataAddress, 'REGIONCODE'),
                    'registrationAddressPostal' => ArrayHelper::getValue($fiasHouse, 'POSTALCODE') ?? $model->postal ?? "",
                    'registrationAddressRegion' => ArrayHelper::getValue($treeRecursive, 'region_level_fias_value') ?? "",
                    'registrationAddressCity' => ArrayHelper::getValue($treeRecursive, 'city_level_fias_value') ?? "",
                    'registrationAddressStreet' => ArrayHelper::getValue($treeRecursive, 'street_level_fias_value') ?? "",
                    'registrationAddressHouseNumber' => ArrayHelper::getValue($fiasHouse, 'fullNumber') ?? ArrayHelper::getValue($model, 'house') ?? "",
                    'registrationAddressApartment' => ArrayHelper::getValue($model, 'apartment') ?? "",
                ];
            },
        ];
    }
}
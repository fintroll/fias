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
            'fullAddress' => function (CommonLink $model) {
                $result = '';
                $fiasObject = $model->fiasData;

                if ($fiasObject !== null) {
                    if ($model->fiasData instanceof Addrobj) {
                        $result = $model->postal.', '.$fiasObject->fullAddress.', '.$model->house.', '.$model->apartment;
                    } else {
                        $result = $fiasObject->fullAddress.', '.$model->apartment;
                    }
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
            'inversion' => function (CommonLink $model) {
                $inversion = $model->fiasData instanceof House ? ArrayHelper::getValue($model, 'house.address.inversionRecursive') : ArrayHelper::getValue($model, 'inversionRecursive');
                return [
                    'inversion_oksm' => 643,
                    'inversion_postalcode' => ArrayHelper::getValue($model, 'fiasData.POSTALCODE') ?? $model->postal ?? "",
                    'inversion_region_code' =>  ArrayHelper::getValue($model, 'fiasData.address.REGIONCODE') ?? ArrayHelper::getValue($model, 'fiasData.REGIONCODE') ?? "",
                    'inversion_region_name' => ArrayHelper::getValue($inversion,'inversion_region_name') ?? "",
                    'inversion_region_type' => ArrayHelper::getValue($inversion,'inversion_region_type') ?? "",
                    'inversion_district_name' => ArrayHelper::getValue($inversion,'inversion_district_name') ?? "",
                    'inversion_district_type' => ArrayHelper::getValue($inversion,'inversion_district_type') ?? "",
                    'inversion_city_name' => ArrayHelper::getValue($inversion,'inversion_city_name') ?? "",
                    'inversion_city_type' => ArrayHelper::getValue($inversion,'inversion_city_type') ?? "",
                    'inversion_street_name' => ArrayHelper::getValue($inversion,'inversion_street_name') ?? "",
                    'inversion_street_type' => ArrayHelper::getValue($inversion,'inversion_street_type') ?? "",
                    'inversion_house' => ArrayHelper::getValue($model,'fiasData.HOUSENUM') ?? ArrayHelper::getValue($model,'house') ?? "",
                    'inversion_house_building' => ArrayHelper::getValue($model,'fiasData.BUILDNUM') ?? "",
                    'inversion_house_structure' => ArrayHelper::getValue($model,'fiasData.STRUCNUM') ?? "",
                    'inversion_apartment' => ArrayHelper::getValue($model,'apartment') ?? "",
                ];
            },
        ];
    }
}

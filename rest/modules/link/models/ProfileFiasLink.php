<?php

namespace rest\modules\link\models;

use common\models\fias\ProfileFiasLink as CommonLink;
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
                return $model->house !== null ? $model->house->HOUSEID : null;
            },
            'fullAddress' => function (CommonLink $model) {
                $fullAddress = $model->house !== null ? $model->house->fullAddress : null;
                if ($fullAddress !== null && !empty($model->apartment)) {
                    $fullAddress .= ', ' . $model->apartment;
                }
                return $fullAddress;
            },
            'house',
            'apartment' => function (CommonLink $model) {
                return $model->apartment ?? '';
            },
            'inversion' => function (CommonLink $model) {
                $inversion = ArrayHelper::getValue($model, 'house.address.inversionRecursive');
                return [
                    'inversion_oksm' => 643,
                    'inversion_apartment' => $model->apartment ?? '',
                    'inversion_postalcode' => ArrayHelper::getValue($model, 'house.address.POSTALCODE') ?? '',
                    'inversion_region_code' => ArrayHelper::getValue($model, 'house.address.REGIONCODE') ?? '',
                    'inversion_region_name' => ArrayHelper::getValue($inversion,'inversion_region_name') ?? '',
                    'inversion_district_name' => ArrayHelper::getValue($inversion,'inversion_district_name') ?? '',
                    'inversion_city_name' => ArrayHelper::getValue($inversion,'inversion_city_name') ?? '',
                    'inversion_street_name' => ArrayHelper::getValue($inversion,'inversion_street_name') ?? '',
                    'inversion_region_type' => ArrayHelper::getValue($inversion,'inversion_region_id') ?? '',
                    'inversion_district_type' => ArrayHelper::getValue($inversion,'inversion_district_type') ?? '',
                    'inversion_city_type' => ArrayHelper::getValue($inversion,'inversion_city_type') ?? '',
                    'inversion_street_type' => ArrayHelper::getValue($inversion,'inversion_street_type') ?? '',
                ];
            },
        ];
    }
}

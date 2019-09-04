<?php

namespace rest\modules\link\models;

use common\models\fias\ProfileFiasLink as CommonLink;

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
        ];
    }
}

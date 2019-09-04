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
            'house',
            'apartment'
        ];
    }
}

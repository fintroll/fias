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
            'fias_link_id',
            'house',
            'apartment'
        ];
    }
}

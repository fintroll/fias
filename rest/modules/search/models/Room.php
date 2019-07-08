<?php

namespace rest\modules\search\models;

use common\models\fias\Room as CommonRoom;

/**
 * Class Room
 * @package rest\modules\search\models
 */
class Room extends CommonRoom
{
    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'id' => 'ROOMID',
            'value' => 'fullNumber',
        ];
    }

    public function extraFields(): array
    {
        return [
            'flatnumber' => 'FLATNUMBER',
            'flattype' => 'FLATTYPE',
            'roomnumber' => 'ROOMNUMBER',
            'roomtype' => 'ROOMTYPE',
            'houseguid' => 'HOUSEGUID',
            'house',
            'livestatus' => 'LIVESTATUS',
            'normdoc' => 'NORMDOC',
            'operstatus' => 'OPERSTATUS',
            'cadnum' => 'CADNUM',
            'roomcadnum' => 'ROOMCADNUM',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHouse()
    {
        return $this->hasOne(House::class, ['HOUSEGUID' => 'HOUSEGUID']);
    }
}

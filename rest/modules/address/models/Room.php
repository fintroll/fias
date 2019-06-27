<?php

namespace rest\modules\address\models;

use common\models\fias\Room as CommonRoom;

class Room extends CommonRoom
{
    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'fullAddress',
            'roomguid' => 'ROOMGUID',
            'roomid' => 'ROOMID',
            'flatnumber' => 'FLATNUMBER',
            'flattype' => 'FLATTYPE',
            'roomnumber' => 'ROOMNUMBER',
            'roomtype' => 'ROOMTYPE',
            'houseguid' => 'HOUSEGUID',
            'house'

        ];
    }

    public function extraFields(): array
    {
        return [

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

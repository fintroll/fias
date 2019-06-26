<?php

namespace rest\modules\address\models;

class Room extends \common\models\fias\Room
{
    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'roomguid' => 'ROOMGUID',
            'roomid' => 'ROOMID',
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
        return $this->hasOne(House::class, ['HOUSEID' => 'HOUSEGUID']);
    }
}

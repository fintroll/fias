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
            'fullNumber',
            'type' => function() {
                return 'room';
            },
            'house',
            'treeRecursive' =>  function(Room $model) {
                return $model->house->address->treeRecursive;
            },

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

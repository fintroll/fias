<?php

namespace common\models\fias;


use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Room]].
 *
 * @see Room
 */
class RoomQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Room[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Room|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

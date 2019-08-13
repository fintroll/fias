<?php

namespace common\models\fias;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[House]].
 *
 * @see House
 */
class HouseQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return House[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return House|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

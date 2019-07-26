<?php

namespace common\models\fias;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[AddrobjQuery]].
 *
 * @see AddrobjQuery
 */
class AddrobjQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Addrobj[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Addrobj|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

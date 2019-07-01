<?php

namespace common\models\fias;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ProfileFiasLink]].
 *
 * @see ProfileFiasLink
 */
class ProfileFiasLinkQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProfileFiasLink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProfileFiasLink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

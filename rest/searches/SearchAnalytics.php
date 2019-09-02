<?php

namespace rest\searches;

use rest\modules\address\models\Room;
use rest\modules\address\models\House;
use rest\modules\address\models\Addrobj;
use yii\base\Model;

class SearchAnalytics extends Model
{

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param $code
     * @return array|Addrobj|null
     */
    public static function findKladr($code)
    {
        return Addrobj::find()->where(['PLAINCODE' => $code, 'actstatus' => 1])->one();
    }

    /**
     * @param $parent_fias_id
     * @param $term
     * @return array
     */
    public static function findHouses($parent_fias_id, $term): array
    {
        $query = House::find();
        $query->andWhere(['AOGUID' => $parent_fias_id, 'HOUSENUM'=>$term]);
        $query->andWhere(['>=', 'ENDDATE', date('Y-m-d')]);
        $query->orderBy(['HOUSENUM' => SORT_ASC, 'BUILDNUM' => SORT_ASC, 'STRUCNUM' => SORT_ASC]);
        return $query->all();
    }


    /**
     * @param string $parent_fias_id
     * @param string $condition
     * @return null|Room
     */
    public static function findRoom($parent_fias_id, array $condition): ?Room
    {
        $query = Room::find();
        $query->andWhere(['HOUSEGUID' => $parent_fias_id]);
        $query->andFilterWhere($condition);
        $query->andFilterWhere(['>=', 'ENDDATE', date('Y-m-d')]);
        return $query->one();
    }
}
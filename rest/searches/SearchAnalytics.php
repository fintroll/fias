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
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['parent_fias_id'], 'required', 'when' => function ($model) {
                return in_array($model->type, ['house', 'room'], true);
            }],
            [['term', 'parent_fias_id', 'type'], 'string'],
            [['type'], 'in', 'range' => $this->types],
        ];
    }

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
     * @param $house
     * @param $building
     * @param $parent_fias_id
     * @return array|House|null
     */
    public static function findHouse($house, $building, $parent_fias_id)
    {
        return House::find()->where(['AOGUID' => $parent_fias_id])->andFilterwhere([
            'OR',
            ['HOUSENUM' => $house],
            ['BUILDNUM' => $building],
            ['STRUCNUM' => $building]
        ])->andFilterWhere(['>=', 'ENDDATE', date('Y-m-d')])->one();
    }

    /**
     * @param $room
     * @param $parent_fias_id
     * @return mixed
     */
    public static function findRoom($room, $parent_fias_id)
    {
        return Room::class::find()->where(['HOUSEGUID' => $parent_fias_id])->andFilterwhere([
            'OR',
            ['FLATNUMBER', $room],
            ['ROOMNUMBER', $room],
        ])->andFilterWhere(['>=', 'ENDDATE', date('Y-m-d')])->one();
    }
}
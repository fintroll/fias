<?php

namespace rest\searches;

use rest\modules\address\models\Addrobj;
use rest\modules\address\models\House;
use rest\modules\address\models\Room;
use yii\base\Model;
use Yii;
use yii\data\ActiveDataProvider;
use yii\log\Logger;
use Throwable;

class SearchAddress extends Model
{
    /**
     * @var int
     */
    public $region;

    /**
     * @var string
     */
    public $street;

    /**
     * @var string
     */
    public $address_id;

    /**
     * @var string
     */
    public $house;

    /**
     * Поиск по улицам и улицам на дополнительных территориях
     *
     * @var array
     */
    protected $levels = [7, 91];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address_id', 'house', 'street'], 'string'],
            [['region'], 'integer'],
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
     * @param $params
     * @return array
     */
    public function searchAddress($params)
    {
        if (!empty($params['house'])) {
            $dataProvider = $this->searchHouse($params);
            $models = $dataProvider->getModels();
            if (empty($models)) {
                return ['result' => true, 'data' => null];
            }

            foreach ($models as $model) {
                $data[] = $model->getFullNumber();
            }
            return ['result' => true, 'data' => $data];
        }

        if (!empty($params['street'])) {
            $dataProvider = $this->searchAddressObject($params);
            $models = $dataProvider->getModels();
            if (empty($models)) {
                return ['result' => true, 'data' => null];
            }

            foreach ($models as $model) {
                $data[] = [
                    'value' => $model->getFullAddress(),
                    'address_id' => $model->address_id
                ];
            }
            return ['result' => true, 'data' => $data];
        }

        return ['result' => true, 'data' => null];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    protected function searchAddressObject($params)
    {
        $query = Addrobj::find()->where(['IN', 'address_level', $this->levels]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'region_code' => $this->region,
        ]);

        $query->andFilterWhere([
            'LIKE',
            'title',
            $this->street
        ]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    protected function searchHouse($params)
    {
        $query = House::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->where(['address_id' => $this->address_id]);

        $query->andFilterWhere([
            'LIKE',
            House::tableName() . '.number',
            $this->house
        ]);

        return $dataProvider;
    }

    /**
     * @param $id
     * @return Room|House|Addrobj
     */
    public static function findModel($id)
    {
        $modelsClasses = [
            'ROOMID' => Room::class,
            'HOUSEID' => House::class,
            'AOID' => Addrobj::class
        ];
        $model = null;
        try {
            foreach ($modelsClasses as $key => $modelsClass) {
                $model = $modelsClass::findOne([$key => $id]);
                if ($model !== null) {
                    break;
                }
            }
        } catch (Throwable $ignore) {
            Yii::getLogger()->log($ignore->getMessage(), Logger::LEVEL_ERROR);
        }
        return $model;
    }
}
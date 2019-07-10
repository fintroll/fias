<?php

namespace rest\searches;

use rest\modules\search\models\Addrobj;
use rest\modules\search\models\House;
use rest\modules\search\models\PostalCode;
use rest\modules\search\models\Room;
use yii\base\Model;
use Yii;
use yii\data\ActiveDataProvider;
use yii\log\Logger;
use Throwable;

class SearchAddress extends Model
{
    /**
     * @var string $term
     */
    public $term = '';

    /**
     * @var string $parent_fias_id
     */
    public $parent_fias_id;

    /**
     * @var string $type
     */
    public $type;

    /**
     * @var array $types
     */
    private $types = [
        'region',
        'district',
        'city',
        'street',
        'house',
        'room',
        'postal'
    ];


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
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = Addrobj::find()->where(['actstatus' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params, '');
        if (!$this->validate()) {
            $query->andWhere('0=1');
            return $dataProvider;
        }
        switch ($this->type) {
            case 'region':
                $query->andFilterWhere(['LIKE', 'FORMALNAME', $this->term]);
                $query->andFilterWhere(['AOLEVEL' => [1, 2, 3]]);
                $query->andFilterWhere(['PARENTGUID' => $this->parent_fias_id]);
                break;
            case 'city':
                $query->andFilterWhere(['LIKE', 'FORMALNAME', $this->term]);
                $query->andFilterWhere(['AOLEVEL' => [4, 5, 6]]);
                $query->andFilterWhere(['PARENTGUID' => $this->parent_fias_id]);
                break;
            case 'street':
                $query->andFilterWhere(['LIKE', 'FORMALNAME', $this->term]);
                $query->andFilterWhere(['IN', 'AOLEVEL', [7, 91]]);
                $query->andFilterWhere(['PARENTGUID' => $this->parent_fias_id]);
                break;
            default:
                $query->andWhere('0=1');
                return $dataProvider;
        }
        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchHouses($params): ActiveDataProvider
    {
        $query = House::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params, '');
        if (!$this->validate()) {
            $query->andWhere('0=1');
            return $dataProvider;
        }
        $query->andWhere(['AOGUID' => $this->parent_fias_id]);
        $query->andFilterWhere(
            [
                'OR',
                ['LIKE', 'HOUSENUM', $this->term],
                ['LIKE', 'BUILDNUM', $this->term],
                ['LIKE', 'STRUCNUM', $this->term]
            ]
        );
        $query->andWhere(['>=', 'ENDDATE', date('Y-m-d')]);
        $query->orderBy(['HOUSENUM' => SORT_ASC, 'BUILDNUM' => SORT_ASC, 'STRUCNUM' => SORT_ASC]);
        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchPostal($params): ActiveDataProvider
    {
        $query = PostalCode::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params, '');
        if (!$this->validate()) {
            $query->andWhere('0=1');
            return $dataProvider;
        }
        $query->andWhere(['POSTALCODE' => $this->term]);
        $query->andWhere(['>=', 'ENDDATE', date('Y-m-d')]);
        $query->orderBy(['HOUSENUM' => SORT_ASC, 'BUILDNUM' => SORT_ASC, 'STRUCNUM' => SORT_ASC]);
        return $dataProvider;
    }


    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchRooms($params): ActiveDataProvider
    {
        $query = Room::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params, '');
        if (!$this->validate()) {
            $query->andWhere('0=1');
            return $dataProvider;
        }
        $query->andWhere(['HOUSEGUID' => $this->parent_fias_id]);
        $query->andFilterWhere(
            [
                'OR',
                ['LIKE', 'FLATNUMBER', $this->term],
                ['LIKE', 'ROOMNUMBER', $this->term]
            ]
        );
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
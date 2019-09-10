<?php

namespace rest\searches;

use rest\modules\search\models\Addrobj;
use rest\modules\search\models\House;
use yii\base\Model;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\sphinx\MatchExpression;
use common\models\fias\Addrobj as DataBaseAddrObj;

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
    ];


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['parent_fias_id'], 'required', 'when' => function ($model) {
                return $model->type === 'house';
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
        $sphinx = Yii::$app->sphinx;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params, '');
        if (!$this->validate()) {
            $query->andWhere(['id' => -1]);
            return $dataProvider;
        }
        switch ($this->type) {
            case 'region':
                $query->match(new MatchExpression('@(fullname) *' . $sphinx->escapeMatchValue($this->term) . '*'));
                $query->andWhere(['aolevel' => [1, 2, 3]]);
                $query->andFilterWhere(['parentguid' => $this->parent_fias_id]);
                break;
            case 'city':
                $subquery = DataBaseAddrObj::find()->where(['actstatus' => 1,'parentguid' => $this->parent_fias_id])->all();
                $children = ArrayHelper::getColumn($subquery,'AOGUID');
                $searchData = !empty($this->parent_fias_id) ? array_merge([$this->parent_fias_id], $children) : null;
                $query->match(new MatchExpression('@(fullname) *' . $sphinx->escapeMatchValue($this->term) . '*'));
                $query->andWhere(['aolevel' => [1, 3, 4, 5, 6, 35, 65]]);
                $query->andWhere(['not in', 'shortname', ['Респ', 'Чувашия', 'край', 'обл', 'Аобл', 'округ', 'АО']]);
                $query->andFilterWhere(['parentguid' => $searchData]);
                break;
            case 'street':
                $subquery = DataBaseAddrObj::find()->select([])->where(['actstatus' => 1,'parentguid' => $this->parent_fias_id])->all();
                $children = ArrayHelper::getColumn($subquery,'AOGUID');
                $searchData = !empty($this->parent_fias_id) ? array_merge([$this->parent_fias_id], $children) : null;
                $query->match(new MatchExpression('@(fullname) *' . $sphinx->escapeMatchValue($this->term) . '*'));
                $query->andWhere(['aolevel' => [7, 91]]);
                $query->andFilterWhere(['parentguid' => $searchData]);
                break;
            default:
                $query->andWhere('0=1');
                return $dataProvider;
        }
        $query->orderBy(['aolevel' => SORT_ASC]);
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
        $query->limit(20);
        return $dataProvider;
    }
}
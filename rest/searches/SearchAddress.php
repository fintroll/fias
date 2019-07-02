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
     * @var string $query
     */
    public $query;

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
        'region' => [
            'class' => Addrobj::class,
            'parent_field' => 'PARENTGUID',
            'search_field' => 'FORMALNAME',
            'levels' => [1, 2]
        ],
        'district' => [
            'class' => Addrobj::class,
            'parent_field' => 'PARENTGUID',
            'search_field' => 'FORMALNAME'
        ],
        'city' => [
            'class' => Addrobj::class,
            'parent_field' => 'PARENTGUID',
            'search_field' => 'FORMALNAME'
        ],
        'street' => [
            'class' => Addrobj::class,
            'parent_field' => 'PARENTGUID',
            'search_field' => 'FORMALNAME'
        ],
        'house' => [
            'class' => House::class,
            'parent_field' => 'AOGUID',
            'search_fields' => 'HOUSENUM'
        ],
    ];


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'query'], 'required'],
            [['query', 'parent_fias_id', 'type'], 'string'],
            [['type'], 'in', 'range' => array_keys($this->types)],
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

        $query = Addrobj::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            $query->andWhere('0=1');
            return $dataProvider;
        }

        $type =  $this->types[$this->type];
        /** @var $query Room|House|Addrobj */
        $query = $type['class']::find();
        $query->andFilterWhere(['like', $type['search_field'], $this->query]);
        $query->andFilterWhere([$type['parent_field'] => $this->parent_fias_id]);
        $query->andFilterWhere([$type['parent_field'], $this->parent_fias_id]);


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
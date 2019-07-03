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
    public $query = '';

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
        'room'
    ];


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['parent_fias_id'], 'required', 'when' => in_array($this->type, ['house', 'room'], true)],
            [['query', 'parent_fias_id', 'type'], 'string'],
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
                $query->andFilterWhere(['LIKE', 'FORMALNAME', $this->query]);
                $query->andFilterWhere(['AOLEVEL' => [1, 2, 3]]);
                $query->andFilterWhere(['PARENTGUID' => $this->parent_fias_id]);
                break;
            case 'city':
                $query->andFilterWhere(['LIKE', 'FORMALNAME', $this->query]);
                $query->andFilterWhere(['AOLEVEL' => [4, 5, 6]]);
                $query->andFilterWhere(['PARENTGUID' => $this->parent_fias_id]);
                break;
            case 'street':
                $query->andFilterWhere(['LIKE', 'FORMALNAME', $this->query]);
                $query->andFilterWhere(['IN', 'AOLEVEL', [7, 91]]);
                $query->andFilterWhere(['PARENTGUID' => $this->parent_fias_id]);
                break;
            case 'house':
                $query = House::find();
                $query->andFilterWhere(
                    [
                        'OR',
                        ['LIKE', 'HOUSENUM', $this->query],
                        ['LIKE', 'BUILDNUM', $this->query]
                    ]
                );
                $query->andFilterWhere(['AOGUID' => $this->parent_fias_id]);
                break;
            case 'room':
                $query = Room::find();
                $query->andFilterWhere(
                    [
                        'OR',
                        ['LIKE', 'FLATNUMMBER', $this->query],
                        ['LIKE', 'ROOMNUMBER', $this->query]
                    ]
                );
                $query->andFilterWhere(['HOUSEGUID' => $this->parent_fias_id]);
                break;
            default:
                $query->andWhere('0=1');
                return $dataProvider;
        }

        $dumpSql = $query->createCommand()->getRawSql();
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
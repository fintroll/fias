<?php

namespace rest\modules\analytics\actions;


use rest\modules\address\models\House;
use rest\searches\SearchAnalytics;
use yii\helpers\ArrayHelper;
use yii\rest\Action;
use yii\web\NotFoundHttpException;


/**
 * Class FindHouseAction
 *
 * @package rest\modules\analytics\controllers\actions
 */
class FindHouseAction extends Action
{

    /**
     * @var string Обязательное поле. Класс модели по умолчанию
     */
    public $modelClass;

    private const TYPE_HOUSE = 1;
    private const TYPE_BUILDING = 2;
    private const TYPE_STRUCTURE = 3;

    private $houseMarkers = [
        'ДОМ' => self::TYPE_HOUSE,
        'ДОМОВЛ' => self::TYPE_HOUSE,
        'КОРПУС' => self::TYPE_BUILDING,
        'СТРОЕНИЕ' => self::TYPE_STRUCTURE,
        'СТРОЕН' => self::TYPE_STRUCTURE,
    ];


    /**
     * @param string $code
     * @param string $term
     *
     * @return \yii\db\ActiveRecordInterface
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($parent_fias_id, $term)
    {
        $model = $this->findHouse($parent_fias_id, $term);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        if ($model === null) {
            throw new NotFoundHttpException('Дома с id улицы ' . $parent_fias_id . ' по запросу  ' . $term . ' не найден');
        }
        return $model;
    }

    /**
     * @param $id
     * @return House
     * @throws NotFoundHttpException
     */
    public function findHouse($parent_fias_id, $term)
    {
        $params = $this->prepareHouseParams($term);
        if (empty($params)) {
            throw new NotFoundHttpException('Дома с id улицы ' . $parent_fias_id . ' по запросу  ' . $term . ' не найден');
        }
        $houseNumber = $params[self::TYPE_HOUSE];
        if (empty($houseNumber)) {

            throw new NotFoundHttpException('Дома с id улицы ' . $parent_fias_id . ' по запросу  ' . $term . ' не найден');
        }
        $models = SearchAnalytics::findHouses($parent_fias_id, $houseNumber);
        if (empty($models)) {
            throw new NotFoundHttpException('Дома с id улицы ' . $parent_fias_id . ' по запросу  ' . $term . ' не найден');
        }
        return $this->filterHouseNumber($models,$params);
    }

    /**
     * @param array $data
     * @param array $term
     * @return House|null
     */
    private function filterHouseNumber(array $data, array $params): ?House
    {
        $result = null;
        $targetBuildnum = $params[self::TYPE_BUILDING] ?? null;
        if ($targetBuildnum !== null) {
            $result = array_filter($data, function (House $item) use ($targetBuildnum) {
                $buildnum = ArrayHelper::getValue($item, 'BUILDNUM');
                return trim($buildnum) === trim($targetBuildnum);
            });
        }

        $targetStrucnum = $params[self::TYPE_STRUCTURE] ?? null;
        if ($targetStrucnum !== null) {
            $result = array_filter($data, function (House $item) use ($targetStrucnum) {
                $strucnum = ArrayHelper::getValue($item, 'STRUCNUM');
                return trim($strucnum) === trim($targetStrucnum);
            });
        }

        return !empty($result) ? reset($result) : null;
    }

    private function prepareHouseParams(string $term): array
    {
        $result = [];
        preg_match_all('/([^ ,]*) (\d*)/', $term, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            if (isset($this->houseMarkers[$match[1]]) && !empty($match[2])) {
                $result[$this->houseMarkers[$match[1]]] = $match[2];
            }
        }
        return $result;
    }
}
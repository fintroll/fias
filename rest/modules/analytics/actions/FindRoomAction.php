<?php

namespace rest\modules\analytics\actions;


use rest\modules\address\models\House;
use rest\searches\SearchAnalytics;
use yii\helpers\ArrayHelper;
use yii\rest\Action;
use yii\web\NotFoundHttpException;


/**
 * Class FindRoomAction
 *
 * @package rest\modules\analytics\controllers\actions
 */
class FindRoomAction extends Action
{

    /**
     * @var string Обязательное поле. Класс модели по умолчанию
     */
    public $modelClass;

    private const TYPE_FLAT = 'FLATNUMBER';
    private const TYPE_OFFICE = 'ROOMNUMBER';

    private $houseMarkers = [
        'КВАРТИРА' => self::TYPE_FLAT,
        'ПОМ.' => self::TYPE_OFFICE,
        'ОФ' => self::TYPE_OFFICE
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
        $model = $this->findRoom($parent_fias_id, $term);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        if ($model === null) {
            throw new NotFoundHttpException('Помещения с id дома ' . $parent_fias_id . ' по запросу  ' . $term . ' не найден');
        }
        return $model;
    }

    /**
     * @param $id
     * @return Room|null
     * @throws NotFoundHttpException
     */
    public function findRoom($parent_fias_id, $term)
    {
        $condition = $this->prepareRoomParams($term);
        if (empty($condition)) {
            throw new NotFoundHttpException('Помещения с id дома' . $parent_fias_id . ' по запросу  ' . $term . ' не найден');
        }
        return SearchAnalytics::findRoom($parent_fias_id, $condition);
    }


    private function prepareRoomParams(string $term): array
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
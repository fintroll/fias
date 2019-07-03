<?php

namespace rest\modules\search\controllers;

use rest\components\ActiveController;
use rest\modules\address\models\Addrobj;
use rest\searches\SearchAddress;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\IndexAction;
use yii\rest\Serializer;

/**
 * Class SearchController
 * @package rest\modules\address\controllers
 */
class AddressController extends ActiveController
{
    /**
     * @var string Обязательное поле. Класс модели по умолчанию
     */
    public $modelClass = SearchAddress::class;

    /**
     * @var array Паджинация
     */
    public $serializer = [
        'class' => Serializer::class,
        'collectionEnvelope' => 'items',
    ];

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['view']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider():ActiveDataProvider
    {
        $search = new SearchAddress();
        return $search->search(Yii::$app->request->queryParams);
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareHouseDataProvider():ActiveDataProvider
    {
        $search = new SearchAddress();
        return $search->search(Yii::$app->request->queryParams);
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareRoomDataProvider():ActiveDataProvider
    {
        $search = new SearchAddress();
        return $search->search(Yii::$app->request->queryParams);
    }
}

<?php

namespace rest\modules\search\controllers;

use rest\components\ActiveController;
use rest\modules\address\models\Addrobj;
use rest\searches\SearchAddress;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\Cors;
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
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['view']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        $actions['house'] = [
            'class' => IndexAction::class,
            'modelClass' => SearchAddress::class,
            'prepareDataProvider' => [$this, 'prepareHousesDataProvider'],
        ];
        $actions['room'] = [
            'class' => IndexAction::class,
            'modelClass' => SearchAddress::class,
            'prepareDataProvider' => [$this, 'prepareRoomsDataProvider'],
        ];
        $actions['options'] = [
            'class' => 'yii\rest\OptionsAction',
        ];
        return $actions;
    }


    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider(): ActiveDataProvider
    {
        $search = new SearchAddress();
        return $search->search(Yii::$app->request->queryParams);
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareHousesDataProvider(): ActiveDataProvider
    {
        $search = new SearchAddress();
        return $search->searchHouses(Yii::$app->request->queryParams);
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareRoomsDataProvider(): ActiveDataProvider
    {
        $search = new SearchAddress();
        return $search->searchRooms(Yii::$app->request->queryParams);
    }
}

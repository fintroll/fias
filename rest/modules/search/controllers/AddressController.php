<?php

namespace rest\modules\search\controllers;

use rest\components\ActiveController;
use rest\searches\SearchAddress;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\rest\IndexAction;
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
        $actions['postal'] = [
            'class' => IndexAction::class,
            'modelClass' => SearchAddress::class,
            'prepareDataProvider' => [$this, 'preparePostalDataProvider'],
        ];
        $actions['options'] = [
            'class' => yii\rest\OptionsAction::class,
        ];
        return $actions;
    }


    /**
     * @return ArrayDataProvider
     */
    public function prepareDataProvider(): ArrayDataProvider
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

    /**
     * @return ActiveDataProvider
     */
    public function preparePostalDataProvider(): ActiveDataProvider
    {
        $search = new SearchAddress();
        return $search->searchPostal(Yii::$app->request->queryParams);
    }
}

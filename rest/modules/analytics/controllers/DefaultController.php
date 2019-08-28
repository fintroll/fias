<?php

namespace rest\modules\analytics\controllers;

use rest\components\ActiveController;
use rest\modules\address\models\Addrobj;
use rest\searches\Searchanalytics;
use yii\rest\IndexAction;
use yii\rest\OptionsAction;
use yii\rest\ViewAction;
use yii\web\NotFoundHttpException;

/**
 * Class DefaultController
 * @package rest\modules\analytics\controllers
 */
class DefaultController extends ActiveController
{
    /**
     * @var string Обязательное поле. Класс модели по умолчанию
     */
    public $modelClass = Addrobj::class;

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['index'], $actions['view']);
        $actions['klard'] = [
            'class' => ViewAction::class,
            'modelClass' => SearchAnalytics::class,
            'findModel' => [$this, 'prepareHousesDataProvider'],
        ];
        $actions['house'] = [
            'class' => ViewAction::class,
            'modelClass' => SearchAnalytics::class,
            'findModel' => [$this, 'prepareHousesDataProvider'],
        ];
        $actions['room'] = [
            'class' => ViewAction::class,
            'modelClass' => SearchAnalytics::class,
            'findModel' => [$this, 'prepareRoomsDataProvider'],
        ];
        $actions['options'] = [
            'class' => OptionsAction::class,
        ];
        return $actions;
    }

    /**
     * @param $id
     * @return Addrobj|\rest\modules\address\models\House|\rest\modules\address\models\Room|null
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = SearchAnalytics::findModel($id);
        if ($model === null) {
            throw new NotFoundHttpException('Объект по запросу ' . $id . ' не найден');
        }
        return $model;
    }

    public function verbs(): array
    {
        $parentVerbs = parent::verbs();
        $parentVerbs['view'] = ['GET'];
        return $parentVerbs;
    }
}

<?php

namespace rest\modules\analytics\controllers;

use rest\components\ActiveController;
use rest\modules\address\models\Addrobj;
use rest\modules\analytics\actions\FindByKladrAction;
use rest\modules\analytics\actions\FindHouseAction;
use rest\modules\analytics\actions\FindRoomAction;
use rest\searches\SearchAnalytics;
use yii\helpers\ArrayHelper;
use yii\rest\OptionsAction;
use yii\web\NotFoundHttpException;

/**
 * Class SearchController
 * @package rest\modules\analytics\controllers
 */
class SearchController extends ActiveController
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
        $actions['kladr'] = [
            'class' => FindByKladrAction::class,
            'modelClass' => SearchAnalytics::class,
            'findModel' => [$this, 'findKladr'],
        ];
        $actions['house'] = [
            'class' => FindHouseAction::class,
            'modelClass' => SearchAnalytics::class,
            'findModel' => [$this, 'findHouse'],
        ];
        $actions['room'] = [
            'class' => FindRoomAction::class,
            'modelClass' => SearchAnalytics::class,
            'findModel' => [$this, 'findRoom'],
        ];
        $actions['options'] = [
            'class' => OptionsAction::class,
        ];
        return $actions;
    }


    public function verbs(): array
    {
        $parentVerbs = parent::verbs();
        $parentVerbs['kladr'] = ['GET'];
        $parentVerbs['house'] = ['GET'];
        $parentVerbs['room'] = ['GET'];
        return $parentVerbs;
    }

    /**
     * @param $id
     * @return Addrobj
     * @throws NotFoundHttpException
     */
    public function findKladr($code)
    {
        $model = SearchAnalytics::findKladr($code);
        if ($model === null) {
            throw new NotFoundHttpException('Объект с кодом Кладр ' . $code . ' не найден');
        }
        return $model;
    }

}

<?php

namespace rest\modules\address\controllers;

use rest\components\ActiveController;
use rest\modules\address\models\House;
use rest\searches\SearchAddress;
use yii\web\NotFoundHttpException;

/**
 * Class DefaultController
 * @package rest\modules\address\controllers
 */
class DefaultController extends ActiveController
{
    /**
     * @var string Обязательное поле. Класс модели по умолчанию
     */
    public $modelClass = House::class;

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['index']);
        $actions['view']['findModel'] = [$this, 'findModel'];
        return $actions;
    }


    public function verbs(): array
    {
        $parentVerbs = parent::verbs();
        $parentVerbs['view'] = ['GET'];
        return $parentVerbs;
    }
}

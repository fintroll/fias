<?php

namespace rest\modules\address\controllers;

use rest\components\ActiveController;
use rest\modules\address\models\Addrobj;
use rest\modules\address\models\House;
use rest\modules\address\models\Room;
use rest\modules\links\models\ProfileFiasLink;
use rest\modules\links\models\ProfileLinkForm;
use Yii;
use Throwable;
use yii\log\Logger;
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
    public $modelClass = ProfileFiasLink::class;

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['index']);
        $actions['view']['findModel'] = [$this, 'findModel'];
        $actions['create']['modelClass'] = ProfileLinkForm::class;
        return $actions;
    }


    public function verbs(): array
    {
        $parentVerbs = parent::verbs();
        $parentVerbs['view'] = ['GET'];
        $parentVerbs['create'] = ['POST'];
        return $parentVerbs;
    }
}

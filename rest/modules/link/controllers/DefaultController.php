<?php

namespace rest\modules\link\controllers;

use rest\components\ActiveController;
use rest\modules\address\models\Addrobj;
use rest\modules\address\models\House;
use rest\modules\address\models\Room;
use rest\modules\link\models\ProfileFiasLink;
use rest\modules\link\models\ProfileLinkForm;
use rest\searches\SearchAddress;
use yii\filters\Cors;
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
        unset($actions['delete'], $actions['index'], $actions['update']);
        $actions['view']['findModel'] = [$this, 'findModel'];
        $actions['create']['modelClass'] = ProfileLinkForm::class;
        return $actions;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => '*',
                    'Access-Control-Request-Method' => ['GET', 'POST'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,
                ],
            ],
        ]);
    }


    public function verbs(): array
    {
        $parentVerbs = parent::verbs();
        $parentVerbs['view'] = ['GET'];
        $parentVerbs['create'] = ['POST'];
        return $parentVerbs;
    }

    /**
     * @param $id
     * @return Addrobj|House|Room
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $fiasLinkModel = ProfileFiasLink::find()->where(['project_profile_id' => $id])->one();
        if ($fiasLinkModel === null){
            throw new NotFoundHttpException('Объект id=' . $id . ' не найден');
        }
        $model = SearchAddress::findModel($fiasLinkModel->fias_id);
        if ($model === null) {
            throw new NotFoundHttpException('Объект fias_id=' . $fiasLinkModel->fias_id . ' не найден');
        }
        return $model;
    }
}

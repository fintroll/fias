<?php

namespace rest\modules\link\controllers;

use rest\components\ActiveController;
use rest\modules\address\models\Addrobj;
use rest\modules\address\models\House;
use rest\modules\address\models\Room;
use rest\modules\links\models\ProfileFiasLink;
use rest\modules\links\models\ProfileLinkForm;
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


    public function verbs(): array
    {
        $parentVerbs = parent::verbs();
        $parentVerbs['view'] = ['GET'];
        $parentVerbs['create'] = ['POST'];
        return $parentVerbs;
    }
    /**
     * @param $id
     * @return Room|House|Addrobj
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
            throw new NotFoundHttpException('Объект fias_id=' . $id . ' не найден');
        }
        return $model;
    }
}

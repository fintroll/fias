<?php

namespace rest\modules\address\controllers;

use rest\components\ActiveController;
use rest\modules\address\models\Addrobj;
use rest\modules\address\models\House;
use rest\modules\address\models\Room;
use Yii;
use Throwable;
use yii\base\InvalidConfigException;
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
    public $modelClass = Addrobj::class;

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['index']);
        $actions['view']['findModel'] = [$this, 'findModel'];
        return $actions;
    }

    /**
     * @param $id
     * @return Room|House|Addrobj
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
     public function findModel($id)
    {
        $modelsClasses = [
            'ROOMID' => Room::class,
            'HOUSEID' => House::class,
            'AOID' => Addrobj::class
        ];
        $model = null;
        try {
            foreach ($modelsClasses as $key => $modelsClass) {
                $model = $modelsClass::findOne([$key => $id]);
                if ($model !== null) {
                    break;
                }
            }
        } catch (Throwable $ignore) {
            throw new InvalidConfigException($ignore->getMessage());
        }
        if ($model === null) {
            throw new NotFoundHttpException('Объект fias_id='.$id.' не найден');
        }
        return $model;
    }

    public function verbs()
    {
        $parentVerbs = parent::verbs();
        $parentVerbs['view'] = ['GET'];
        return $parentVerbs;
    }
}

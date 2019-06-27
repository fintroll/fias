<?php

namespace rest\modules\address\controllers;

use rest\components\ActiveController;
use rest\modules\address\models\Addrobj;
use rest\modules\address\models\House;
use rest\modules\address\models\Room;
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
    public $modelClass = Addrobj::class;

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

    /**
     * @param $id
     * @return Room|House|Addrobj
     * @throws NotFoundHttpException
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
            Yii::getLogger()->log($ignore->getMessage(), Logger::LEVEL_ERROR);
        }
        if ($model === null) {
            throw new NotFoundHttpException('Объект fias_id=' . $id . ' не найден');
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

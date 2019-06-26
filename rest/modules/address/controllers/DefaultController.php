<?php

namespace rest\modules\address\controllers;

use rest\components\Controller;
use rest\modules\address\models\Addrobj;
use rest\modules\address\models\House;
use rest\modules\address\models\Room;
use Throwable;

/**
 * Class DefaultController
 * @package rest\modules\address\controllers
 */
class DefaultController extends Controller
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
        return $actions;
    }

    /**
     * @param string $id
     *
     * @return Addrobj|House|Room|null
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
        } catch (Throwable $exception) {
            return null;
        }
        return $model;
    }
}

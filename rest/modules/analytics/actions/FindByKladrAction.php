<?php

namespace rest\modules\analytics\actions;

use yii\rest\ViewAction;


/**
 * Class ShowFileActionAction
 *
 * @package rest\modules\analytics\controllers\actions
 */
class FindByKladrAction extends ViewAction
{

	/**
	 * @var string Обязательное поле. Класс модели по умолчанию
	 */
	public $modelClass;

	/**
	 * @param string $code
	 *
	 * @throws \yii\base\ExitException
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function run($code)
	{
		$model = $this->findModel($code);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        return $model;
	}
}
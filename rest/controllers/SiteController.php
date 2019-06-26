<?php
/**
 * Created by Zero.
 * @author HunterKaan <mr.igor.prokofev@gmail.com>
 * Date: 016 16.11.17
 * Time: 13:04
 */

namespace rest\controllers;

use rest\components\Controller as RestController;
use rest\models\LoginForm;
use Yii;
use yii\rest\OptionsAction;
use yii\web\ErrorAction;
use yii\web\ServerErrorHttpException;


class SiteController extends RestController
{
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'options' => [
				'class' => OptionsAction::class,
			],
			'error' => [
				'class' => ErrorAction::class,
			],
		];
	}


	/**
	 * @inheritDoc
	 */
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator']['except'] = ['login'];

		$behaviors['access']['rules'][] = [
			'actions' => ['login'],
			'allow' => true,
			'roles' => ['?'],
		];
		return $behaviors;
	}

    /**
     * @return LoginForm|null
     * @throws ServerErrorHttpException
     */
	public function actionLogin()
	{
		if (Yii::$app->request->isPost) {
			$model = new LoginForm();
			if ($model->load(Yii::$app->request->bodyParams, '') && $model->login()) {
				return $model;
			}

			if (!$model->hasErrors()) {
				throw new ServerErrorHttpException('Failed to login for unknown reason.');
			}
			Yii::$app->getResponse()->setStatusCode(422);
			return $model;
		}

		if (Yii::$app->request->isOptions) {
			Yii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', ['POST']));
		} else {
			Yii::$app->getResponse()->setStatusCode(405);
		}
		return null;
	}

    public function verbs()
    {
        $parentVerbs = parent::verbs();
        $parentVerbs['login'] = ['POST'];
        return $parentVerbs;
    }

}
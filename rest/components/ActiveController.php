<?php
namespace rest\components;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController as BaseActiveController;

class ActiveController extends BaseActiveController
{
	/**
	 * @inheritDoc
	 */
	public function behaviors()
	{
		$behaviors = parent::behaviors();

		// remove authentication filter
		unset($behaviors['authenticator']);

		// re-add authentication filter
		$behaviors['authenticator'] = [
			'class' => YII_ENV_DEV ? QueryParamAuth::class : HttpBearerAuth::class,
		];
		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		$behaviors['authenticator']['except'] = ['options'];

		// Ограничение прав
		$behaviors['access'] = [
			'class' => AccessControl::class,
			'rules' => [
				[
					'allow' => true,
					'actions' => ['options'],
				],
				[
					'allow' => true,
					'roles' => ['@'],
				],
			],
		];

		$rateLimiter = $behaviors['rateLimiter'];
		unset($behaviors['rateLimiter']);
		$behaviors['rateLimiter'] = $rateLimiter;

		return $behaviors;
	}

}
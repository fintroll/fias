<?php

namespace rest\components;


use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;


class Controller extends \yii\rest\Controller
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
			'class' => QueryParamAuth::class
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
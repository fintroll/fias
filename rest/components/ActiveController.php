<?php
/**
 * Created by Zero.
 * @author HunterKaan <mr.igor.prokofev@gmail.com>
 * Date: 020 20.11.17
 * Time: 14:54
 */

namespace rest\components;


use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\rest\ActiveController as BaseActiveController;

/**
 * Class ActiveController
 * @author HunterKaan <mr.igor.prokofev@gmail.com>
 * @package rest\components
 */
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
			'class' => QueryParamAuth::class,
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
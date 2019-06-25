<?php
/**
 * Created by PhpStorm.
 * User: zero
 * Date: 05.12.2017
 * Time: 14:27
 */

namespace rest\modules\user\models;

use common\components\organization\OrganizationService;
use common\components\organization\OrganizationServiceInterface;
use common\components\organization\StaffService;
use common\models\hr\HrStaff;
use common\models\user\UserWorkHistoryQuery;
use Yii;
use yii\base\Action;
use yii\db\ActiveQuery;
use yii\filters\RateLimitInterface;
use yii\helpers\StringHelper;
use yii\web\Request;


/**
 * Class User
 * @package rest\modules\user\models
 */
class User extends \common\models\user\User implements RateLimitInterface
{
	public const DEFAULT_HISTORY_LIMIT = 10;
	public const MAX_HISTORY_LIMIT = 50;

	/**
	 * @return array
	 */
	public function fields()
	{
		$fields = [
			'id',
			'userName',
			'userImageUrlPattern',
			'organization_id' => static function (User $user) {
				$organization_id = null;

				$organizationService = Yii::createObject(OrganizationServiceInterface::class);

				// TODO: проверить логику, для кого и каких юзеров мы можем получать
				if ($organizationService->hasOrganization()) {
					$organization_id = $organizationService->organization->getStaffs()->andWhere(['id' => $user->id])->exists() ?
						$organizationService->organization->id : null;
				}

				return $organization_id;
			},
		];


		if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id === $this->id) {
			$fields[] = 'email';
			$fields['phone'] = 'username';
		}

		if(isset(Yii::$app->params['GiveMeAPanzer']) || Yii::$app->user->can('backend')) {
			$fields['GiveMeAPanzer'] = static function() {
				return Yii::$app->params['GiveMeAPanzer'] ?? true;
			};
		}

		return $fields;
	}

	/**
	 * @return array
	 */
	public function extraFields()
	{
		$extraFields = [
			'hrStaff' => static function () {
				return Yii::createObject(StaffService::class)->staff;
			},
			'organization',
			'staffInvites'
		];

		if (Yii::$app->user->identity->id === $this->id) {
			$extraFields[] = 'citizen';
			$extraFields[] = 'settings';
			$extraFields['workHistories'] = static function (User $model) {
				$limit = (int)Yii::$app->request->get('history-limit', static::DEFAULT_HISTORY_LIMIT);
				return $model->getWorkHistories()->limit($limit > 0 && $limit <= static::MAX_HISTORY_LIMIT ? $limit : static::DEFAULT_HISTORY_LIMIT)->all();
			};
		}
		return $extraFields;
	}

	/**
	 * @return UserWorkHistoryQuery|ActiveQuery
	 */
	public function getWorkHistories()
	{
		return $this->hasMany(UserWorkHistory::class, ['created_by' => 'id'])->orderBy(['start_at' => SORT_DESC]);
	}

	/**
	 * @return string
	 */
	public function getUserImageUrlPattern()
	{
		$url = $this->getUserImageUrl();

		if (StringHelper::startsWith($url, '/uploads/')) {
			$url = preg_replace('/^(\/uploads\/)/i', '', $url);
		}

		return Yii::getAlias('@imageHost') . '/{{w}}x{{h}}/' . $url;
	}

	/**
	 * @param int|null $organizationId
	 * @return null|HrStaff|Staff
	 */
	public function getStaff(?int $organizationId): ?HrStaff
	{
		return $organizationId ? Staff::findOne(['user_id' => $this->id, 'organizations_id' => $organizationId]) : null;
	}

	/**
	 * @inheritDoc
	 * @deprecated
	 */
	public function getOrganization()
	{
		//		// TODO: снести после тестов
		//		throw new NotSupportedException('Organization relation no longer supported');

		/** @var OrganizationService $organizationService */
		$organizationService = Yii::$container->get(OrganizationServiceInterface::class);

		return $organizationService->getOrganization();
	}

	/**
	 * @return UserWorkHistoryQuery|ActiveQuery
	 */
	public function getLastWorkHistory()
	{
		/** @var UserWorkHistoryQuery $query */
		$query = $this->hasOne(UserWorkHistory::class, ['created_by' => 'id'])->orderBy(['start_at' => SORT_DESC]);
		return $query->lastOne();
	}

	/**
	 * Returns the maximum number of allowed requests and the window size.
	 * @param Request $request the current request
	 * @param Action $action the action to be executed
	 * @return array an array of two elements. The first element is the maximum number of allowed requests,
	 * and the second element is the size of the window in seconds.
	 */
	public function getRateLimit($request, $action)
	{
		// N запросов на M секунд
		return [Yii::$app->params['rateLimit'], Yii::$app->params['rateLimitTime']];
	}

	/**
	 * Loads the number of allowed requests and the corresponding timestamp from a persistent storage.
	 * @param Request $request the current request
	 * @param Action $action the action to be executed
	 * @return array an array of two elements. The first element is the number of allowed requests,
	 * and the second element is the corresponding UNIX timestamp.
	 */
	public function loadAllowance($request, $action)
	{
		$user_id = Yii::$app->user->id;
		$cache = Yii::$app->cache;
		return [
			$cache->get('allowance-' . $user_id),
			$cache->get('allowance_updated_at-' . $user_id),
		];
	}

	/**
	 * Saves the number of allowed requests and the corresponding timestamp to a persistent storage.
	 * @param Request $request the current request
	 * @param Action $action the action to be executed
	 * @param int $allowance the number of allowed requests remaining.
	 * @param int $timestamp the current timestamp.
	 */
	public function saveAllowance($request, $action, $allowance, $timestamp)
	{
		$user_id = Yii::$app->user->id;
		$cache = Yii::$app->cache;
		$cache->set('allowance-' . $user_id, $allowance, 86400);
		$cache->set('allowance_updated_at-' . $user_id, $timestamp, 86400);
	}

}
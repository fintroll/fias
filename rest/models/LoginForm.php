<?php

namespace rest\models;

class LoginForm extends \common\models\LoginForm
{

	/**
	 * @inheritDoc
	 */
	public function fields()
	{
		return [
			'access_token' => function (LoginForm $model) {
				return $model->getUser()->auth_key;
			},
		];
	}

	public function formName()
    {
        return '';
    }

}
<?php

namespace rest\models;

use common\models\LoginForm as CommonLoginForm;

/**
 * Class LoginForm
 * @package rest\models
 */
class LoginForm extends CommonLoginForm
{

    /**
     * @inheritDoc
     */
    public function fields(): array
    {
        return [
            'access_token' => static function (LoginForm $model) {
                return $model->getUser()->auth_key;
            },
        ];
    }

    public function formName(): string
    {
        return '';
    }

}
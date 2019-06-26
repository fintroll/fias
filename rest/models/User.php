<?php
namespace rest\models;

use common\models\User as CommonUser;


/**
 * Class User
 * @package rest\models
 */
class User extends CommonUser
{
    public const DEFAULT_HISTORY_LIMIT = 10;
    public const MAX_HISTORY_LIMIT = 50;

}
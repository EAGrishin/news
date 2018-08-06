<?php

namespace common\rbac\rules;

use common\models\User;
use Yii;
use yii\rbac\Rule;

class UserRoleRule extends Rule
{
    public $name = 'userRole';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            return $item->name === Yii::$app->user->identity->role;
        }
        return false;
    }
}
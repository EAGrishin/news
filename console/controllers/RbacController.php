<?php

namespace console\controllers;

use common\rbac\rules\UserRoleRule;
use Yii;

class RbacController extends \yii\console\Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // Правило, проверящее роль пользователя
        $rule = new UserRoleRule();
        $auth->add($rule);

        // Роль Администратор
        $admin = $auth->createRole('administrator');
        $admin->ruleName = $rule->name;
        $auth->add($admin);
    }
} 
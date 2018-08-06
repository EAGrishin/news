<?php
use common\models\User;

$webUser = Yii::$app->user;
\backend\assets\menu\MenuAsset::register($this);
?>

<?= \backend\widgets\NavAdminMenu::widget([
    'options' => ['class' => 'nav navbar-nav side-nav'],
    'encodeLabels' => false,
    'items' => [
        [
            'label' => '<i class="fa fa-fw fa-star-o"></i> Новости',
            'url' => ['news/index'],
            'visible' => $webUser->can(User::ROLE_ADMINISTRATOR),
        ],
        [
            'label' => '<i class="fa fa-fw fa-wrench"></i> Категории',
            'url' => ['category/index'],
            'visible' => $webUser->can(User::ROLE_ADMINISTRATOR),
        ],
    ]
]); ?>
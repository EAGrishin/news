<?php

namespace backend\assets\menu;

use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/menu';

    public $css = [
        'css/menu.css',
    ];

    public $js = [
        'js/menu.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
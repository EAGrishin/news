<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $themeModel \common\models\Category */

$this->title = 'Новости';

?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-4">

            <?= $this->render('_nav_themes', ['themeModel' => $themeModel]); ?>
        </div>
        <div class="col-lg-8">
            <?php \yii\widgets\Pjax::begin(); ?>

            <?php $sort = ((int)Yii::$app->request->get('sort') == SORT_ASC) ? SORT_DESC : SORT_ASC; ?>
            <?= Html::a("Сортировать по дате", [Url::to(['site/cat', 'id' => $themeModel->id]), 'sort' => $sort], ['class' => 'sort-news', 'style' => 'float:right']); ?>

            <?= $this->render('_news_list', ['dataProvider' => $dataProvider]); ?>

            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>
</div>

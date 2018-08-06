<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $themeModel \common\models\Category */

$this->title = 'Все Новости';

?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-10">
            <h1>Список всех новостей</h1>
            <?php \yii\widgets\Pjax::begin(); ?>

            <?php $sort = ((int)Yii::$app->request->get('sort') == SORT_ASC) ? SORT_DESC : SORT_ASC; ?>
            <?= Html::a("Сортировать по дате", [Url::to('site/index'), 'sort' => $sort], ['class' => 'sort-news']); ?>

            <?= $this->render('_news_list', ['dataProvider' => $dataProvider]); ?>


            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>
</div>

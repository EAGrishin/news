<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

/** @var \common\models\News $model */
?>
<div class="news-item">
    <div class="newList-title">
        <div class="title"><?= Html::a(Html::encode($model->title),
                Url::to(['/news/title', 'sef_url' => $model->sef_url])); ?>
        </div>
    </div>
    <p>Дата: <?= Html::encode($model->created_at) ?></p>
    <?= HtmlPurifier::process($model->short_description) ?>
</div>

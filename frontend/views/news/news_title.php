<?php
/** @var $model \common\models\News */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="col-md-10">
    <h1><?= $model->title ?></h1>
    <p>Дата: <?= Html::encode($model->created_at) ?></p>
    <hr>
    <div class="margin-top-20">
        <?= HtmlPurifier::process($model->description) ?>
    </div>
</div>
<div class="col-md-8">
    <?php // Комментарии
    echo \frontend\widgets\comments\Comments::widget([
        'model' => $model
    ]);
    ?>
</div>

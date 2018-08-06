<?php

use yii\widgets\ListView;

/* @var $dataProvider \yii\data\ActiveDataProvider */
?>


<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list',
    'emptyText' => 'Нет активных новостей',
    'emptyTextOptions' => [
        'tag' => 'h3'
    ],
    'summary' => false,
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'news-item',
    ],
    'pager' => [
        'firstPageLabel' => 'Первая',
        'lastPageLabel' => 'Последняя',
        'nextPageLabel' => 'Следующая',
        'prevPageLabel' => 'Предыдущая',
        'maxButtonCount' => 5,
    ],
]);
?>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\News;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'select[name="per-page"]',
        'tableOptions' => ['class' => 'table table-bordered table-stripped', 'style' => 'margin-top:5px'],
        'columns' => [
            'id',
            'title',
            'sef_url',
            [
                'attribute' => 'category_id',
                'format' => 'raw',
                'value' => function (News $data) {
                    return ($data->category)
                        ? $data->category_id . ' - ' . $data->category->name
                        : $data->category_id;
                }
            ],
            [
                'attribute' => 'is_active',
                'filter' => [0 => 'No', 1 => 'Yes'],
                'format' => 'raw',
                'value' => function (News $data) {
                    return ($data->is_active)
                        ? '<span class="label label-success">Yes</span>'
                        : '<span class="label label-danger">No</span>';
                }
            ],
            'created_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

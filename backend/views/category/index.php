<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить Категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'select[name="per-page"]',
        'tableOptions' => ['class' => 'table table-bordered table-stripped', 'style' => 'margin-top:5px'],
        'columns' => [
            'id',
            'name',
            [
                'label' => 'Родительская категория',
                'format' => 'raw',
                'value' => function (Category $data) {
                    if ($data->getParent()) {
                        return $data->getParent()->name;
                    }
                    return null;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

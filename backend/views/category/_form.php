<?php

use common\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ]); ?>
    <div class="col-md-4">
        <div class="category-form">

            <div class="well well-sm">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>

            <?php
            /** @var Category[] $nodes */
            $nodes = Category::find()->orderBy(['lft' => SORT_ASC])->all();
            $arr_themes = [];
            $options = ['class' => 'form-control', 'size' => 10];
            $selected_id = 0;
            $parent = null;
            if (!$model->isNewRecord) {
                $parent = $model->parents(1)->one();
                $options['options'] = [$model->id => ['disabled' => true]];
            }
            foreach ($nodes as $n) {
                if ($n->depth == 0) {
                    $selected_id = $n->id;
                }
                if ($parent instanceof Category && $parent->id == $n->id) {
                    $selected_id = $n->id;
                }
                $arr_themes[$n->id] = str_repeat('....', $n->depth) . $n->name;
            }
            ?>
            <div class="form-group">
                <?= Html::label('Выберите родительскую категорию') ?>
                <?= Html::dropDownList('category_to_save', $selected_id, $arr_themes, $options) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

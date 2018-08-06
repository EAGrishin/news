<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="news-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="col-md-6">

            <?= $form->field($model, 'is_active')->dropDownList([1 => 'Да', 0 => 'Нет'], ['style' => 'width: 100px;']); ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sef_url')
                ->textInput(['maxlength' => true])
                ->label(Html::activeLabel($model,
                        'sef_url') . ' <a href="#" id="get_sef_url" title="Сделать ЧПУ из поля «Заголовок»"><i class="glyphicon glyphicon-refresh"></i></a>'); ?>
            <?php
            // Скрипт для получения ЧПУ
            $this->registerJs('
                    $("#get_sef_url").sef_url({
                        selector_in: "#' . Html::getInputId($model, 'title') . '",
                        selector_out: "#' . Html::getInputId($model, 'sef_url') . '",
                        sef_url: "' . \yii\helpers\Url::to(['news/ajax-slug']) . '",
                    });
                    ', \yii\web\View::POS_READY, 'get_sef_url'
            ); ?>

            <?= $form->field($model, 'category_id')
                ->dropDownList(ArrayHelper::map(Category::find()->where('depth > 0')->all(), 'id', 'name')); ?>

            <?= $form->field($model, 'short_description')->widget(yii\imperavi\Widget::className(), [
                'options' => [
                    'minHeight' => 100,
                    'maxHeight' => 100,
                ],
                'plugins' => [
                    'fullscreen',
                ],
            ]) ?>

            <?= $form->field($model, 'description')->widget(yii\imperavi\Widget::className(), [
                'options' => [
                    'minHeight' => 100,
                    'maxHeight' => 100,
                ],
                'plugins' => [
                    'fullscreen',
                ],
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


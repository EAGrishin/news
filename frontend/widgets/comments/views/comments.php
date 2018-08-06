<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;


/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $model */
/** @var $this \yii\web\View */

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'options' => [
        'class' => 'comment-form',
    ],
]) ?>

<div class="form-row">
    <label class="textarea-holder">
        <?php echo Html::activeTextarea($model, 'text',
            ['placeholder' => 'Оставьте ваш комментарий', 'cols' => 30, 'rows' => 8]); ?>
    </label>
</div>
<div class="comment-form-footer clearfix">
    <div class="pull-right">
        <button type="reset" class="gray-btn btn">Отмена</button>
        <?php echo Html::submitButton('Отправить', ['class' => 'green-btn btn']); ?>
    </div>
</div>

<?php ActiveForm::end() ?>


<h3>Комментарии </h3>

<?php echo ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['tag' => 'ul', 'class' => 'commetns-list'],
    'itemView' => '_comments_item',
    'layout' => "{items}\n{pager}",
    'emptyText' => '',
]); ?>


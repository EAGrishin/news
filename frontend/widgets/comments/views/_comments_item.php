<?php
use yii\helpers\Html;
?>

<li class="commetns-list-item">
    <div class="commetns-list-frame">
        <div class="commetns-list-text">
            <strong>
                <?php if ($model->user) : ?>
                    <span style="color: #1a4580"><?= $model->user->username ?></span><br>
                <?php else : ?>
                    <span style="color: #c9ccc7;"><?= "Гость" ?></span><br>
                <?php endif; ?>
            </strong>
            <div style="padding: 10px">
                <?php echo $model->text; ?>
            </div>
        </div>
        <div class="commetns-list-item-footer">
            <div class="commetns-list-item-footer-text">
                <span class="date">
                    <?php $createdAt = new DateTime($model->created_at); ?>
                    <?php echo Yii::$app->formatter->asDatetime($createdAt);?>
                </span>
            </div>
        </div>
    </div>
</li>
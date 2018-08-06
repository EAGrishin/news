<?php

use yii\helpers\Url;
?>
<?php
// Получаем дерево тематик
$themes = common\models\Category::getTreeArray();
$catUrl = isset($catUrl) ? $catUrl : 'site/cat';

/** @var $themeModel \common\models\Category */
?>


<div class="rubrikator-menu-title">Список категорий</div>
<ul class="rubrikator-menu">
    <?php for ($i = 0, $ci = count($themes); $i < $ci; $i++) : ?>
        <?php $t = $themes[$i]; ?>

        <?php if (!is_array($t) && $t->depth == 1) : ?>

            <?php // Если следующий пункт в виде массива, то он является подпунктами текущего.
            if (isset($themes[$i + 1]) && is_array($themes[$i + 1])) {
                $class_drop = 'hasdrop';
                $class_opener = 'opener';
                $i++;
            } else {
                $class_drop = '';
                $class_opener = '';
            }

            $drop_active = '';
            foreach ($themeModel->parents()->all() as $parent) {
                if ($t->name == $parent->name) {
                    $drop_active = 'drop-active';
                }
            }
            ?>
            <li class="<?= $drop_active ?>">
                <?php $active_title = ($t->name == $themeModel->name) ? 'active' : ''; ?>
                <div class="header">
                    <a href="<?= Url::to([$catUrl, 'id' => $t->id,]); ?>"
                       class="title <?= $active_title ? 'active' : '' ?>"><?= $t->name; ?></a>
                    <a class="<?= $class_opener ?>" href="#"></a>
                </div>
                <?php if ($class_drop == 'hasdrop') : ?>
                    <div class="drop">
                        <ul class="drop-list">
                            <?php for ($i2 = 0, $ci2 = count($themes[$i]); $i2 < $ci2; $i2++) : ?>
                                <?php $t2 = $themes[$i][$i2]; ?>
                                <?php if (!is_array($t2) && $t2->depth == 2) : ?>
                                    <?php $active_class = ($t2->name == $themeModel->name) ? 'active' : ''; ?>
                                    <li class="<?= $active_class ?>">
                                        <a href="<?= Url::to([$catUrl, 'id' => $t2->id]); ?>"><span><?= $t2->name ?></span></a>
                                    </li>
                                    <?php foreach ($t2->children()->all() as $t3): ?>
                                        <?php $active_class = ($t3->name == $themeModel->name) ? 'active' : ''; ?>
                                        <li class="<?= $active_class ?>">
                                            <a href="<?= Url::to([$catUrl, 'id' => $t3->id]); ?>">
                                                <span><?= str_repeat('&#8194;', $t3->depth) . $t3->name ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            <?php endfor ?>
                        </ul>
                    </div>
                <?php endif ?>
            </li>
        <?php endif ?>
    <?php endfor; ?>
</ul>

<?php $this->registerJs("
    $('.rubrikator-menu .opener').click(function (e) {
        var item = $(this).closest('li');
        item.find('.drop').slideToggle(function () {
            item.toggleClass('drop-active');
        });
        e.preventDefault();
    });
"); ?>

<?php


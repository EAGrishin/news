<?php

namespace backend\widgets;


use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;
use yii\widgets\Menu;

class NavAdminMenu extends Nav
{
    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if (empty($items)) {
            $items = '';
        } else {
            $linkOptions['data-toggle'] = 'collapse';
            $linkOptions['data-target'] = isset($item['target']) ? $item['target'] : '';
            Html::addCssClass($options, ['widget' => '']);
            Html::addCssClass($linkOptions, ['widget' => '']);
            if ($this->dropDownCaret !== '') {
                $label .= ' ' . $this->dropDownCaret;
            }
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderCollapse($items, $item);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }

    public function renderCollapse($items, $parentItem)
    {
        return Menu::widget([
            'options' => ArrayHelper::getValue($parentItem, 'dropDownOptions', []),
            'items' => $items,
            'encodeLabels' => $this->encodeLabels,
            'view' => $this->getView(),
        ]);
    }
}
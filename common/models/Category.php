<?php

namespace common\models;

use Yii;
use common\components\CategoryQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\db\Query;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 *
 * @property News[] $news
 *
 * @method boolean makeRoot
 * @method boolean prependTo(ActiveRecord $node, $runValidation = true, $attributes = null)
 * @method boolean appendTo(ActiveRecord $node, $runValidation = true, $attributes = null)
 * @method boolean insertAfter(ActiveRecord $node, $runValidation = true, $attributes = null)
 * @method boolean insertBefore(ActiveRecord $node, $runValidation = true, $attributes = null)
 * @method ActiveQuery parents($depth = null)
 * @method ActiveQuery children($depth = null)
 * @method ActiveQuery leaves
 * @method ActiveQuery prev
 * @method ActiveQuery next
 * @method boolean isRoot
 * @method boolean isLeaf
 */
class Category extends ActiveRecord
{

    private $_ownAndChildIds;
    private $_parent;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'leftAttribute' => 'lft',
                 'rightAttribute' => 'rgt',
                 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function getOwnAndChildIds()
    {
        if (!$this->_ownAndChildIds) {
            $this->_ownAndChildIds = (new Query())->select('id')->from(self::tableName())
                ->where('lft >= :lft AND rgt <= :rgt', [':lft' => $this->lft, ':rgt' => $this->rgt])
                ->orderBy('lft')->column(self::getDb());
        }
        return $this->_ownAndChildIds;
    }

    public function getParent()
    {
        if (!$this->_parent) {
            $this->_parent = $this->parents(1)->one();
        }
        return $this->_parent;
    }

    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    static public function getTreeArray()
    {
        $theme = self::findOne(['depth' => 0]);
        /** @var Category[] $themes_all */
        $themes_all = $theme->children()->all();


        if (!function_exists('common\\models\\getNestedArray')) {
            /*
             * Временная функция для превращения линейного списка из базы, во вложенный массив элементов
             */
            function getNestedArray($start, $themes_all, $prev)
            {
                $res = [];
                for ($i = $start, $ci = count($themes_all); $i < $ci; $i++) {
                    $t = $themes_all[$i];

                    if ($t->depth > $prev) {
                        list($arr, $next_i) = getNestedArray($i, $themes_all, $t->depth);
                        $res[] = $arr;
                        $i = $next_i - 1;
                    } elseif ($t->depth == $prev) {
                        $res[] = $t;
                    } else {
                        return [$res, $i];
                    }
                }
                return [$res, $i];
            }
        }

        list($res) = getNestedArray(0, $themes_all, 0);

        return $res[0] ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['category_id' => 'id']);
    }
}
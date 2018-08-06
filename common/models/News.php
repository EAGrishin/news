<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $sef_url
 * @property int $category_id
 * @property string $short_description
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_active
 *
 * @property Category $category
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'sef_url',
                'ensureUnique' => true
            ],
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'sef_url', 'category_id', 'short_description', 'description'], 'required'],
            ['sef_url', 'unique'],
            ['sef_url', 'match', 'pattern' => '%^[a-z0-9-]+$%', 'message' => 'Доступны только след. символы: a-z, «-»'],
            [['category_id', 'is_active'], 'integer'],
            [['short_description', 'description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'sef_url' => 'ЧПУ Url',
            'category_id' => 'Категория',
            'short_description' => 'Краткое описание',
            'description' => 'Подробный текст',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
            'is_active' => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public static function querySort($sort, $categoryIds = [])
    {
        $query = self::find();

        if ($categoryIds) {
            $query->andWhere(['in','category_id', $categoryIds]);
        }
        $query->andWhere(['is_active' => true]);

        return $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => (int)$sort ?? SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 3,
            ]
        ]);
    }
}
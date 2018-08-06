<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property integer $user_id
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 *
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required', 'message' => 'Необходимо указать текст комментария'],
            [['model_id', 'user_id'], 'integer'],
            [['text'], 'string', 'min' => 1, 'tooShort' => 'Комментарий должен содержать минимум 1 символ'],
            [['model'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'model_id' => 'Model ID',
            'user_id' => 'Пользователь',
            'text' => 'Текст',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}

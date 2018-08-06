<?php

namespace frontend\widgets\comments;

use common\models\Comment;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\StringHelper;


class Comments extends \yii\base\Widget
{
    /** @var  ActiveRecord */
    public $model;
    /** @var int */
    public $commentsLimit = 10;

    public $view = 'comments';

    public function init()
    {
        parent::init();

        $model = $this->saveComment();

        if ($model->id && !$model->getErrors()) {
            return Yii::$app->response->refresh();
        }
    }


    public function run()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()
                ->where([
                    'model' => $this->getModelName(),
                    'model_id' => $this->model->id,
                ])
                ->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => $this->commentsLimit,
            ],
        ]);

        echo $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'model' => (new Comment()),
        ]);
    }

    private function saveComment()
    {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $model->model = $this->getModelName();
            $model->model_id = $this->model->id;
            if(!Yii::$app->user->isGuest) {
                $model->user_id = Yii::$app->user->id;
            }
            $model->text = trim($model->text);
            $model->save();
        }
        return $model;
    }

    private function getModelName()
    {
        return StringHelper::basename($this->model->className());
    }
}
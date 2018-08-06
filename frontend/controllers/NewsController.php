<?php
/**
 * Created by PhpStorm.
 * User: evgeny
 * Date: 04.08.18
 * Time: 20:27
 */

namespace frontend\controllers;

use yii\web\Controller;
use common\models\News;
use yii\web\NotFoundHttpException;


class NewsController extends Controller
{

    public function actionTitle($sef_url)
    {
        $model = News::findOne(['sef_url' => $sef_url]);
        if (!$model) {
            throw new NotFoundHttpException("Новости не существует.");
        }
        return $this->render('news_title', [
            'model' => $model,
        ]);
    }
}
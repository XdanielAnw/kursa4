<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Subscription;
use yii\web\NotFoundHttpException;

class SubscriptionController extends Controller
{
    // Список всех подписок
    public function actionIndex()
    {
        $subscriptions = Subscription::find()->all(); // берём актуальные данные с БД
        return $this->render('index', ['subscriptions' => $subscriptions,]);
    }

    // Создание новой подписки
    public function actionCreate()
    {
        $model = new Subscription();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Подписка создана!');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // Редактирование существующей подписки
    public function actionUpdate($id)
    {
        $model = Subscription::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Подписка не найдена');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Подписка обновлена!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    // Удаление подписки
    public function actionDelete($id)
    {
        $model = Subscription::findOne($id);
        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Подписка удалена!');
        }

        return $this->redirect(['index']);
    }
}

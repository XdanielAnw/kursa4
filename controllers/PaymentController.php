<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Subscription;
use app\models\Payment;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class PaymentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'process'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Только для авторизованных
                    ],
                ],
            ],
        ];
    }

    /**
     * Страница выбора оплаты
     */
    public function actionIndex($plan)
    {
        $subscription = Subscription::findOne($plan);
        if (!$subscription) {
            throw new NotFoundHttpException('Подписка не найдена.');
        }

        return $this->render('index', [
            'subscription' => $subscription,
        ]);
    }

    /**
     * Обработка оплаты
     */
    public function actionProcess()
{
    $request = Yii::$app->request;
    $user = Yii::$app->user->identity;

    $subscriptionId = $request->post('subscription_id');
    $paymentMethod = $request->post('payment_method');

    $subscription = Subscription::findOne($subscriptionId);
    if (!$subscription) {
        throw new NotFoundHttpException('Подписка не найдена.');
    }

    // Создаем запись о платеже
    $payment = new Payment();
    $payment->user_id = $user->id;
    $payment->subscription_id = $subscription->id;
    $payment->price = $subscription->price;
    $payment->payment_date = date('Y-m-d H:i:s');
    $payment->status = 'success';
    $payment->save();

    // Меняем роль пользователя в базе
    switch ($subscription->title) {
        case 'Лайт':
            $user->role = 0; 
            break;
        case 'Премиум':
            $user->role = 1; 
            break;
        case 'Творец':
            $user->role = 2; 
            break;
        case 'Админ':
            $user->role = 3; 
            break;
    }
    $user->save(false); // сохраняем без валидации, чтобы точно обновилось

    // Обновляем identity в сессии, чтобы сразу применились новые данные
    Yii::$app->user->login($user);

    Yii::$app->session->setFlash('success', 'Оплата прошла успешно. Ваша роль обновлена.');
    return $this->redirect(['/site/index']);
}
}

<?php
use yii\bootstrap5\Html;
use app\models\Subscription;

/** @var yii\web\View $this */
$this->title = 'Подписки';
?>

<div class="container py-5">

    <div class="text-center mb-5">
        <h2 class="display-4 fw-bold text-light">Подписки</h2>
        <p class="lead text-light">
            Выберите подходящий план для доступа ко всем материалам сервиса.
        </p>
    </div>

    <div class="row justify-content-center">

        <?php
        // Получаем все подписки из БД
        $subscriptions = Subscription::find()->all();
        $user = Yii::$app->user;

        foreach ($subscriptions as $sub):

            // Логика кнопок по роли пользователя
            $buttonText = 'Получить';
            $buttonUrl = ['/payment/index', 'plan' => $sub->id];
            $buttonOptions = ['class' => 'btn btn-lg btn-primary w-100 mb-2'];

            $role = $user->isGuest ? 0 : $user->identity->role;

            if ($user->isGuest) {
                $buttonText = 'Войти';
                $buttonUrl = ['/site/login'];
            } else {
                $role = $user->identity->role;

                switch ($sub->title) {

                    case 'Лайт':
                        if ($role === 0) {
                            $buttonText = 'Текущий план';
                        } else {
                            $buttonText = 'Уже включено';
                            $buttonUrl = '#';
                            $buttonOptions['class'] = 'btn btn-lg btn-secondary w-100 mb-2';
                            $buttonOptions['disabled'] = true;
                        }
                        break;

                    case 'Премиум':
                        if ($role == 1) {
                            $buttonText = 'Текущий план';
                            $buttonUrl = '#';
                            $buttonOptions['class'] = 'btn btn-lg btn-secondary w-100 mb-2';
                            $buttonOptions['disabled'] = true;
                        } elseif ($role > 1) {
                            $buttonText = 'Уже включено';
                            $buttonUrl = '#';
                            $buttonOptions['class'] = 'btn btn-lg btn-secondary w-100 mb-2';
                            $buttonOptions['disabled'] = true;
                        } else {
                            $buttonText = 'Перейти на Премиум';
                        }
                        break;

                    case 'Творец':
                        if ($role >= 2) {
                            $buttonText = 'Текущий план';
                            $buttonUrl = '#';
                            $buttonOptions['class'] = 'btn btn-lg btn-secondary w-100 mb-2';
                            $buttonOptions['disabled'] = true;
                        } else {
                            $buttonText = 'Перейти на Творец';
                        }
                        break;

                    default:
                        $buttonText = 'Получить';
                        break;
                }

                if ($buttonText === 'Вы уже используете этот план' || $buttonText === 'Ваш текущий план') {
                    $buttonUrl = '#';
                    $buttonOptions['class'] = 'btn btn-lg btn-current-plan w-100 mb-2';
                    $buttonOptions['disabled'] = true;
                }
            }
            ?>

            <?php
            $features = [
                'Лайт' => [
                    'Доступ к бесплатным материалам',
                    'Ограниченный функционал'
                ],

                'Премиум' => [
                    'Все материалы сервиса',
                    'Приоритетная поддержка',
                    'Эксклюзивный контент'
                ],

                'Творец' => [
                    'Все возможности Премиум',
                    'Загрузка своих материалов',
                    'Статистика и аналитика'
                ]
            ];

            $subFeatures = $features[$sub->title] ?? [];

            switch ($sub->title) {

                case 'Премиум':
                    $planClass = 'plan-premium';
                    break;

                case 'Творец':
                    $planClass = 'plan-creator';
                    break;

                default:
                    $planClass = 'plan-free';
            }
            ?>

            <div class="col-md-4 mb-4">
                <div class="card shadow-lg hover-shadow <?= $planClass ?>" style="transition: transform 0.3s;">

                    <div class="card-header text-center text-white bg-primary">
                        <h3 class="my-0 fw-normal">
                            <?= Html::encode($sub->title) ?>
                        </h3>
                    </div>

                    <div class="card-body text-center">

                        <h2 class="card-title pricing-card-title mb-3">
                            <?= number_format($sub->price, 0, '.', ' ') ?> ₽ / месяц
                        </h2>

                        <!-- <= $sub->duration_days ?> -->

                        <p class="lead text-muted mb-3">
                            Доступ к <?= Html::encode(strtolower($sub->title)) ?> плану.
                        </p>

                        <ul class="list-unstyled mt-3 mb-4 text-start">
                            <li class="text-center fw-bold">
                                - Основные возможности подписки -
                            </li>

                            <?php foreach ($subFeatures as $feature): ?>
                                <li>- <?= Html::encode($feature) ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <?= Html::a($buttonText, $buttonUrl, $buttonOptions) ?>

                        <?php if ($buttonText === 'Получить'): ?>
                            <small class="text-muted">
                                Безопасная оплата через банковские карты
                            </small>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

</div>

<style>
    .card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, .25);
    }

    .plan-free {
        border: 2px solid #6c757d;
    }

    .plan-free .card-header {
        background: #6c757d;
    }

    .plan-free .btn {
        background: #6c757d;
        border-color: #6c757d;
    }

    .plan-premium {
        border: 2px solid #28a745;
    }

    .plan-premium .card-header {
        background: linear-gradient(135deg, #28a745, #5ddf8e);
    }

    .plan-premium .btn {
        background: #28a745;
        border-color: #28a745;
    }

    .plan-premium .btn:hover {
        background: #218838;
    }

    .plan-creator {
        border: 2px solid #ffc107;
    }

    .plan-creator .card-header {
        background: linear-gradient(135deg, #ffc107, #ffda6a);
        color: #000;
    }

    .plan-creator .btn {
        background: #ffc107;
        border-color: #ffc107;
        color: #000;
    }

    .plan-creator .btn:hover {
        background: #e0a800;
    }

    .btn-current-plan {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        color: #fff !important;
        cursor: not-allowed;
    }

    .btn-current-plan:hover {
        background-color: #6c757d !important;
        color: #fff !important;
    }
</style>
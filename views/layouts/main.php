<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>



    <header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">

                <!-- Лого -->
                <a href="<?= Yii::$app->homeUrl ?>"
                    class="d-flex align-items-center text-white text-decoration-none">
                    <span class="fs-4 fw-bold">DigitalХаб</span>
                </a>

                <!-- Навигация -->
                <ul class="nav col-12 col-lg-auto mx-lg-auto mb-2 mb-lg-0 justify-content-center">
                    <li>
                        <?= Html::a('Фотографии', ['/site/gallery-images'], [
                            'class' => 'nav-link px-2 text-white'
                        ]) ?>
                    </li>
                    <li>
                        <?= Html::a('Видео', ['/site/gallery-videos'], [
                            'class' => 'nav-link px-2 text-white'
                        ]) ?>
                    </li>
                    <li>
                        <?= Html::a('Иконки', ['/site/gallery-icons'], [
                            'class' => 'nav-link px-2 text-white'
                        ]) ?>
                    </li>
                    <?php if (Yii::$app->user->isGuest || Yii::$app->user->identity->role != 3): ?>
                        <li>
                            <?= Html::a('Подписки', ['/subscription/index'], [
                                'class' => 'nav-link px-2 text-warning fw-semibold'
                            ]) ?>
                        </li>
                    <?php endif; ?>

                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 3): ?>
                        <li>
                            <?= Html::a('Модерация', ['/admin/moderation'], [
                                'class' => 'nav-link px-2 text-danger fw-bold'
                            ]) ?>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Правая часть -->
                <div class="text-end">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <?= Html::a('Вход', ['/site/login'], ['class' => 'btn btn-outline-light me-2']) ?>
                        <?= Html::a('Регистрация', ['/site/register'], ['class' => 'btn btn-warning']) ?>
                    <?php else: ?>
                        <?php if (Yii::$app->user->identity->role == 3): // Админ 
                        ?>
                            <?= Html::a('Админ панель', ['/admin/index'], ['class' => 'btn btn-outline-danger me-2']) ?>
                        <?php elseif (Yii::$app->user->identity->role == 2): // Creator 
                        ?>
                            <?= Html::a('Творческий кабинет', ['/creator/index'], ['class' => 'btn btn-primary me-2']) ?>
                            <?= Html::a('Личный кабинет', ['/cabinet/index'], ['class' => 'btn btn-outline-light me-2']) ?>
                        <?php else: ?>
                            <?= Html::a('Личный кабинет', ['/cabinet/index'], ['class' => 'btn btn-outline-light me-2']) ?>
                        <?php endif; ?>
                        <?= Html::a('Выход', ['/site/logout'], [
                            'class' => 'btn btn-danger',
                            'data-method' => 'post'
                        ]) ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </header>




    <main id="main" class="main flex-shrink-0 hv-50" role="main" style="background-color: #000; ">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>



    <footer class="bg-light border-top mt-auto">
        <div class="container py-4">
            <div class="row">

                <!-- О сервисе -->
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold">DigitalХаб</h5>
                    <p class="text-muted small">
                        Платформа с премиальными футажами, фотографиями и иконками
                        для дизайнеров, видеомейкеров и креаторов.
                    </p>
                    <p class="text-muted small mb-0">
                        © 2026 DigitalХаб
                    </p>
                </div>

                <!-- Контент -->
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">Контент</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <?= Html::a('Фотографии', ['/site/gallery-images'], ['class' => 'nav-link px-0 text-muted']) ?>
                        </li>
                        <li class="nav-item">
                            <?= Html::a('Видео', ['/site/gallery-videos'], ['class' => 'nav-link px-0 text-muted']) ?>
                        </li>
                        <li class="nav-item">
                            <?= Html::a('Иконки', ['/site/gallery-icons'], ['class' => 'nav-link px-0 text-muted']) ?>
                        </li>
                    </ul>
                </div>

                <!-- Аккаунт -->
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">Аккаунт</h6>
                    <ul class="nav flex-column">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li class="nav-item"><?= Html::a('Вход', ['/site/login'], ['class' => 'nav-link px-0 text-muted']) ?></li>
                            <li class="nav-item"><?= Html::a('Регистрация', ['/site/register'], ['class' => 'nav-link px-0 text-muted']) ?></li>
                        <?php else: ?>
                            <?php if (Yii::$app->user->identity->role == 3): ?>
                                <li class="nav-item"><?= Html::a('Админ панель', ['/admin/index'], ['class' => 'nav-link px-0 text-muted']) ?></li>
                            <?php elseif (Yii::$app->user->identity->role == 2): ?>
                                <li class="nav-item"><?= Html::a('Личный кабинет', ['/cabinet/index'], ['class' => 'nav-link px-0 text-muted']) ?></li>
                                <li class="nav-item"><?= Html::a('Творческий кабинет', ['/creator/index'], ['class' => 'nav-link px-0 text-muted']) ?></li>
                            <?php else: ?>
                                <li class="nav-item"><?= Html::a('Личный кабинет', ['/cabinet/index'], ['class' => 'nav-link px-0 text-muted']) ?></li>
                            <?php endif; ?>
                        <?php endif; ?>
                        <li class="nav-item"><?= Html::a('Подписки', ['/subscription/index'], ['class' => 'nav-link px-0 text-muted']) ?></li>
                    </ul>
                </div>

            </div>
        </div>
    </footer>

    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.classList.remove('show'); // bootstrap fade
                alert.style.transition = 'opacity 0.1s';
                alert.style.opacity = '0';

                setTimeout(() => alert.remove(), 100);
            });
        }, 6000);
    </script>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
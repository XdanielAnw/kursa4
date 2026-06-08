<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\BootstrapPluginAsset;

/** @var yii\web\View $this */
/** @var app\models\Asset[] $assets */

BootstrapAsset::register($this);
BootstrapPluginAsset::register($this);

    $photoAssets = [];

    if (!empty($assets)) {

        foreach ($assets as $asset) {

            // Только одобренные материалы
            if ($asset->status_id != 2) {
                continue;
            }

            // Проверяем наличие файла
            if (!empty($asset->file_url)) {

                $extension = strtolower(pathinfo($asset->file_url, PATHINFO_EXTENSION));

                if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $photoAssets[] = $asset;
                }
            }
        }
    }
$this->title = 'My Yii Application';
?>

<div class="site-index">

<div class="container py-5 text-center">
  <div class="d-flex justify-content-center align-items-center text-center">
      <div class="mb-5" style="max-width: 1200px; width: 100%;">
  <!-- Заголовок -->
      <h1 class="mb-3 text-white">Бесплатные стоковые материалы</h1>
      <p class="mb-4 text-white">Скачивайте качественные фото и видеоматериалы с лицензией для любых проектов.</p>

    <!-- Форма поиска -->
        <form action="<?= \yii\helpers\Url::to(['/search/index']) ?>" method="get" class="mx-auto" style="max-width:600px;">
            <div class="input-group">
                <input 
                    type="text" 
                    name="term" 
                    class="form-control" 
                    placeholder="Поиск: Фото или Видео" 
                    autocomplete="off" 
                    autofocus
                    value="<?= isset($_GET['term']) ? Html::encode($_GET['term']) : '' ?>"
                >
                <button class="btn btn-primary" type="submit">Поиск</button>
            </div>
        </form>

  <!-- Популярные запросы -->
    <div class="mt-4 mb-3">
      <span class="text-white me-2">Популярные:</span>
      <a href="<?= \yii\helpers\Url::to(['/search/index', 'q' => 'Фото']) ?>"
        class="badge bg-secondary text-decoration-none me-1">
        Фото 
      </a>
      <a href="<?= \yii\helpers\Url::to(['/search/index', 'q' => 'Видео']) ?>"
        class="badge bg-secondary text-decoration-none me-1">
        Видео
      </a>
      <a href="<?= \yii\helpers\Url::to(['/search/index', 'q' => 'Иконки']) ?>"
        class="badge bg-secondary text-decoration-none me-1">
        Иконки
      </a>
    </div>
    </div>
    </div>

  <!-- Карусель Bootstrap 5 -->
  <?php if (!empty($photoAssets)): ?>
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="1000" data-bs-wrap="true">

        <!-- Слайды -->
        <div class="carousel-inner">
          <?php foreach ($photoAssets as $index => $asset): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
              <img src="<?= Html::encode($asset->file_url) ?>" class="d-block w-100" alt="<?= Html::encode($asset->title) ?>">
              <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                <h5><?= Html::encode($asset->title) ?></h5>
                <?php if ($asset->is_premium): ?>
                  <span class="badge bg-warning text-dark">Премиум</span>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Стрелки -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Предидущая</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Следующая</span>
        </button>
    </div>

<!-- FAQ секция -->
<div class="container py-5">
    <h2 class="mb-4 text-white text-center">Часто задаваемые вопросы (FAQ)</h2>
    <div class="accordion" id="faqAccordion">

        <!-- Вопрос 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading1">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                    Как использовать бесплатные материалы?
                </button>
            </h2>
            <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-white bg-dark bg-opacity-60 rounded p-3">
                    Вы можете скачивать и использовать все бесплатные материалы без указания авторства для любых проектов, кроме запрещенных законом.
                </div>
            </div>
        </div>

        <!-- Вопрос 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                    Какие материалы являются премиум?
                </button>
            </h2>
            <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-white bg-dark bg-opacity-60 rounded p-3">
                    Премиум-материалы имеют специальную пометку и доступны только пользователям с подпиской.
                </div>
            </div>
        </div>

        <!-- Вопрос 3 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                    Как искать нужные материалы?
                </button>
            </h2>
            <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-white bg-dark bg-opacity-60 rounded p-3">
                    Используйте форму поиска сверху или популярные теги для быстрого доступа к нужным фото и видео.
                </div>
            </div>
        </div>

    </div>
</div>


<?php else: ?>
<p class="text-center text-light py-5">Нет фото для карусели</p>
<?php endif; ?>


</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var myCarousel = document.querySelector('#carouselExampleCaptions');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 1000,
        wrap: true
    });
});
</script>

<style>
/* Общий фон страницы */
body, html {
    margin: 0;
    padding: 0;
    background-color: #000;
    color: #fff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Заголовки */
h1, h2, h3 {
    font-weight: 600;
}

/* Карусель */
.carousel-item img {
    max-height: 500px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.carousel-item:hover img {
    transform: scale(1.01);
}

.carousel-caption h5 {
    font-size: 1.5rem;
    font-weight: 500;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1);
}


.input-group .form-control {
    border-radius: 0.25rem 0 0 0.25rem;
}

.input-group .btn {
    border-radius: 0 0.25rem 0.25rem 0;
}

.badge {
    cursor: pointer;
    transition: transform 0.2s ease;
}

.badge:hover {
    transform: scale(1.05);
}


.accordion-button {
    background-color: #111 !important;
    color: #fff !important;
    font-weight: 500;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.accordion-button:not(.collapsed) {
    background-color: #333 !important;
    color: #fff !important;
}

.accordion-body {
    font-size: 1rem;
    line-height: 1.6;
}


.d-flex.justify-content-center.align-items-center {
    scroll-margin-top: 20px;
}


@media (max-width: 768px) {
    .carousel-item img {
        max-height: 300px;
    }

    .carousel-caption h5 {
        font-size: 1.2rem;
    }
}
</style>

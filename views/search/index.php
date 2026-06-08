<?php
use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Asset[] $assets */
/** @var string $term */
/** @var int|null $category */

$this->title = 'Результаты поиска';
?>

<section class="py-2 text-center container">
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">

            <h3 class="text-light">
                Результаты поиска
                <?php if (!empty($term)): ?>
                    по запросу: "<?= Html::encode($term) ?>"
                <?php endif; ?>
            </h3>

            <!-- Форма поиска -->
            <form action="<?= Url::to(['/search/index']) ?>" method="get" class="mt-3">
                <div class="input-group">
                    <input
                        type="text"
                        name="term"
                        class="form-control"
                        placeholder="Поиск по названию"
                        value="<?= Html::encode($term ?? '') ?>"
                    >
                    <button class="btn btn-primary">Поиск</button>
                </div>
            </form>

            <!-- Категории -->
            <div class="mt-3">
                <a href="<?= Url::to(['/search/index', 'category' => 1]) ?>"
                   class="badge <?= $category == 1 ? 'bg-primary' : 'bg-secondary' ?> text-decoration-none me-1">
                    Фото
                </a>
                <a href="<?= Url::to(['/search/index', 'category' => 2]) ?>"
                   class="badge <?= $category == 2 ? 'bg-primary' : 'bg-secondary' ?> text-decoration-none me-1">
                    Видео
                </a>
                <a href="<?= Url::to(['/search/index', 'category' => 3]) ?>"
                   class="badge <?= $category == 3 ? 'bg-primary' : 'bg-secondary' ?> text-decoration-none me-1">
                    Иконки
                </a>
            </div>

        </div>
    </div>
</section>

<div class="album py-5 bg-black">
<div class="container">

<?php if (empty($assets)): ?>
    <p class="text-center text-light">Ничего не найдено 😔</p>
<?php else: ?>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

<?php foreach ($assets as $asset): ?>
    <div class="col d-flex">
                    <div class="card shadow-sm w-100 position-relative">

                <?php if ($asset->is_premium): ?>
                    <span class="premium-badge" title="Премиум контент">⭐</span>
                <?php endif; ?>

                <?php if ($asset->category_id == 2): ?>
                    <!-- VIDEO -->
                    <video class="asset-media" muted loop>
                        <source src="<?= Html::encode($asset->file_url) ?>" type="video/mp4">
                    </video>

                <?php elseif ($asset->category_id == 3): ?>
                    <!-- ICON -->
                    <div class="icon-media">
                        <img src="<?= Html::encode($asset->file_url) ?>" alt="">
                    </div>

                <?php else: ?>
                    <!-- IMAGE -->
                    <img src="<?= Html::encode($asset->file_url) ?>" class="asset-media" loading="lazy">
            <?php endif; ?>
            <div class="overlay d-flex flex-column justify-content-center align-items-center text-center">
                <h5 class="overlay-title"><?= Html::encode($asset->title) ?></h5>
                <div class="btn-group mt-2">
                    <?= Html::a(
                        'Просмотр',
                        ['/asset/view', 'id' => $asset->id],
                        ['class' => 'btn btn-sm btn-outline-light']
                    ) ?>
                </div>
            </div>
                <!-- OVERLAY -->
                <!-- <div class="mt-auto d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        = Html::a('Просмотр', ['/asset/view', 'id'=>$asset->id], ['class'=>'btn btn-sm btn-outline-secondary']) 
                    </div>
                    <small class="text-muted">= strtoupper(Html::encode($asset->type)) </small>
                </div>  -->
        </div>
    </div>
<?php endforeach; ?>

</div>
<?php endif; ?>

</div>
</div>

<style>
.card {
    position: relative;
    overflow: hidden;
}

/* Фото и видео */
.asset-media {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
    background-color: #111;
}

/* Иконки — отдельно */
.icon-media {
    width: 100%;
    height: 220px;
    background: #111;
    display: flex;
    justify-content: center;
    align-items: center;
}

.icon-media img {
    width: 90px;
    height: 90px;
    object-fit: contain;
    filter: invert(1);
}

/* Overlay — ОБЩИЙ */
.overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.6);
    color: #fff;
    opacity: 0;
    transition: opacity 0.3s ease;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.card:hover .overlay {
    opacity: 1;
}

/* Текст */
.overlay-title {
    font-size: 1.1rem;
    font-weight: 600;
}

.btn-outline-light {
    border-color: #fff;
    color: #fff;
}

.btn-outline-light:hover {
    background: #fff;
    color: #000;
}

.premium-badge {
    position: absolute;
    top: -10px;
    right: -10px;
    z-index: 10;
    color: #000;
    border-radius: 50%;
    padding: 6px 8px;
    font-size: 1.2rem;
}

</style>
<?php
use yii\bootstrap5\Html;

/** @var app\models\Asset[] $assets */
$userSubscription = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->role; // 0 = обычная, 1 = премиум и т.д.
?>

<main>

<section class="py-1 text-center container">
    <div class="row py-lg-2">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h3 class="text-light">Фотографии</h3>
            <p class="lead text-light">
                Качественные изображения для презентаций, соцсетей и личных проектов.
            </p>
        </div>
    </div>
</section>

        <div class="album py-5 bg-black">
        <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

        <?php 
        // Фильтруем только фото (category_id = 1)
        $photoAssets = array_filter($assets, fn($asset) => $asset->category_id == 1);

        if (!empty($photoAssets)): 
            foreach ($photoAssets as $asset): 
        ?>
        <div class="col d-flex">
            <div class="card shadow-sm w-100 position-relative">

                <!-- Премиум корона -->
                <?php if ($asset->is_premium): ?>
                <span class="premium-badge" title="Премиум контент">⭐</span>
                <?php endif; ?>

                <div class="image-wrapper">
                    <img src="<?= Html::encode($asset->file_url) ?>" 
                        alt="<?= Html::encode($asset->title) ?>" 
                        loading="lazy">
                </div>

                <!-- Overlay поверх картинки -->
                <div class="overlay d-flex flex-column justify-content-center align-items-center text-center">
                    <h5 class="overlay-title"><?= Html::encode($asset->title) ?></h5>
                    <div class="btn-group mt-2">
                        <?= Html::a('Просмотр', ['/asset/view', 'id'=>$asset->id], ['class'=>'btn btn-sm btn-outline-light']) ?>
                    </div>
                </div>
    </div>
</div>


    <?php 
        endforeach; 
    else: 
    ?>
        <p class="text-center text-light">Нет материалов</p>
    <?php endif; ?>

    </div>
  </div>
</div>
</main>

<style>

.card {
    position: relative;
    overflow: hidden; /* чтобы overlay не вылезал */
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6); /* тёмный полупрозрачный фон */
    color: #fff;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card:hover .overlay {
    opacity: 1;
}

.overlay-title {
    font-size: 1.1rem;
    font-weight: 600;
}

.btn-outline-light {
    border-color: #fff;
    color: #fff;
}

.btn-outline-light:hover {
    background-color: #fff;
    color: #000;
}

  .premium-badge {
    position: absolute;
    top: -10px;
    right: -10px;
    z-index: 20;
    color: #000;
    border-radius: 50%;
    padding: 6px 8px;
    font-size: 1.2rem;
  }

  .image-wrapper {
    width: 100%;
    height: 220px;        /* фиксированная высота карточки */
    overflow: hidden;     /* обрезает лишнее */
    background: #000;     /* фон на случай прозрачного PNG */
}

.image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;    /* заполняет контейнер и сохраняет пропорции */
    display: block;
}
</style>
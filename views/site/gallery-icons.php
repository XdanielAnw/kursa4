<?php
use yii\bootstrap5\Html;

/** @var app\models\Asset[] $assets */
$userSubscription = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->role; // 0 = обычная, 1 = премиум и т.д.
?>

<main>

<section class="py-1 text-center container">
    <div class="row py-lg-2">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h3 class="text-light">Иконки</h3>
            <p class="lead text-light">
                Современные векторные иконки для веб-дизайна, приложений и презентаций.
            </p>
        </div>
    </div>
</section>

<div class="album py-5 bg-black">
  <div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-6 g-6 ">

    <?php 
    $iconAssets = array_filter($assets, fn($asset) => $asset->category_id == 3);

    if (!empty($iconAssets)): 
        foreach ($iconAssets as $asset): 
    ?>
        <div class="col d-flex">
            <div class="card shadow-sm w-100 position-relative mb-4">
                <!-- Премиум корона -->
                <?php if ($asset->is_premium): ?>
                    <span class="premium-badge" title="Премиум контент">⭐</span>
                <?php endif; ?>

                <img style="width: 150px; height: 150px;" src="<?= Html::encode($asset->file_url) ?>" class="card-img-top" alt="<?= Html::encode($asset->title) ?>">
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= Html::encode($asset->title) ?></h5>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <?= Html::a('Просмотр', ['/asset/view', 'id'=>$asset->id], ['class'=>'btn btn-sm btn-outline-secondary']) ?>
                        </div>
                        <small class="text-muted"><?= strtoupper(Html::encode($asset->type)) ?></small>
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
<?php
use yii\helpers\Html;

/** @var app\models\Asset[] $assets */
?>

<div class="container py-5">
  <h3 class="mb-4">Фотографии</h3>

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <?php foreach ($assets as $asset): ?>
      <div class="col d-flex">
        <div class="card shadow-sm w-100">

          <img
            src="<?= Html::encode($asset->preview_url) ?>"
            class="card-img-top"
            style="height: 220px; object-fit: cover;"
          >

          <div class="card-body d-flex flex-column">
            <h6><?= Html::encode($asset->title) ?></h6>

            <p class="card-text text-muted" style="flex-grow:1;">
              <?= Html::encode($asset->description) ?>
            </p>

            <?= Html::a(
              'Просмотр',
              ['asset/view', 'id' => $asset->id],
              ['class' => 'btn btn-sm btn-outline-primary mt-auto']
            ) ?>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

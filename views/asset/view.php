<?php

use yii\bootstrap5\Html;

/** @var $model app\models\Asset */
$userSubscription = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->role; // 0 = обычная, 1 = премиум и т.д.
?>

<div class="container py-5">
    <div class="row">
        <!-- Медиа -->
        <div class="col-md-8 d-flex justify-content-center align-items-center">
            <?php
            $type = strtolower($model->type);

            if (in_array($type, ['mp4', 'mov', 'mkv'])): ?>
                <video class="media-view rounded shadow" controls>
                    <source src="<?= Html::encode($model->file_url) ?>" type="video/mp4">
                    Ваш браузер не поддерживает видео тег
                </video>

            <?php elseif ($type === 'svg' || $type === 'png' || $type === 'jpg' || $type === 'jpeg'): ?>
                <img src="<?= Html::encode($model->file_url) ?>"
                    class="media-view rounded shadow"
                    alt="<?= Html::encode($model->title) ?>">
            <?php endif; ?>
        </div>

        <!-- Информация -->
        <div class="col-md-4">
            <h2 class="text-light">
                <?= Html::encode($model->title) ?>
                <?php if ($model->is_premium): ?>
                    <span title="Премиум контент">⭐</span>
                <?php endif; ?>
            </h2>

            <p class="text-light"><strong>Тип: </strong><?= Html::encode($model->type) ?></p>
            <p class="text-light">
                <strong>Категория: </strong>
                <?= $model->category ? Html::encode($model->category->title ?? $model->category->id) : 'Без категории' ?>
            </p>

            <div class="mt-3 mb-3">
                <strong class="text-light">Теги:</strong>
                <?php if (!empty($model->tags)): ?>
                    <?php foreach ($model->tags as $tag): ?>
                        <span class="badge bg-secondary me-1"><?= Html::encode($tag->title) ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-muted">Нет тегов</span>
                <?php endif; ?>
            </div>

            <p>
                <?php if ($model->is_premium && $userSubscription < 1): ?>
                    <?= Html::a('Оформить подписку', ['/subscription/index'], ['class' => 'btn btn-warning fw-bold']) ?>
                <?php else: ?>
                    <?= Html::a('Скачать', ['/asset/download', 'id' => $model->id], [
                        'class' => 'btn btn-outline-primary'
                    ]) ?>
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>

<style>
    .media-view {
        width: 100%;
        max-width: 600px;
        /* ограничение по ширине */
        height: auto;
        display: block;
        object-fit: contain;
        /* сохраняет пропорции */
        background-color: #fff;
        /* чтобы светлые иконки не сливались с фоном */

    }
</style>
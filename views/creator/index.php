<?php

use yii\bootstrap5\Html;

/** @var array $assets */
$this->title = 'Таблица Моего Контента';
?>

<div class="container py-5"
    style="background-color:#010101; border-radius:8px; padding:30px; overflow-x:hidden;">

    <h3 class="mb-4 text-white">
        <?= Html::encode($this->title) ?>
    </h3>

    <p>
        <?= Html::a(
            'Добавить новые файлы',
            ['create'],
            ['class' => 'btn btn-primary']
        ) ?>
    </p>

    <div class="row g-4">

        <?php foreach ($assets as $asset): ?>

            <div class="col-12 col-md-6 col-xl-4">

                <div class="card h-100 shadow-sm border-0">

                    <?php if ($asset->file_url): ?>

                        <?php if (in_array($asset->type, ['png', 'jpg', 'jpeg', 'svg'])): ?>

                            <img
                                src="<?= Html::encode($asset->file_url) ?>"
                                class="card-img-top media-preview">

                        <?php elseif ($asset->type === 'mp4'): ?>

                            <video controls class="media-preview">
                                <source
                                    src="<?= Html::encode($asset->file_url) ?>"
                                    type="video/mp4">
                            </video>

                        <?php endif; ?>

                    <?php endif; ?>

                    <div class="card-body">

                        <h5 class="card-title">
                            <?= Html::encode($asset->title) ?>
                        </h5>

                        <!-- <p class="small text-muted">
                            ID: <= $asset->id ?>
                        </p> -->

                        <p>
                            <strong>Теги:</strong><br>

                            <?php
                            $tagNames = array_map(
                                fn($tag) => $tag->title,
                                $asset->tags
                            );

                            echo Html::encode(
                                implode(', ', $tagNames)
                            );
                            ?>
                        </p>

                        <p>
                            <strong>Категория:</strong>

                            <?= Html::encode(
                                $asset->category->title ?? 'Не указано'
                            ) ?>
                        </p>

                        <p>
                            <strong>Подписка:</strong>

                            <?= !empty($asset->is_premium)
                                ? '⭐ Премиум'
                                : 'Бесплатно'
                            ?>
                        </p>

                    </div>

                    <div class="card-footer bg-white border-0">

                        <?= Html::a(
                            'Удалить',
                            [
                                'asset/delete',
                                'id' => $asset->id
                            ],
                            [
                                'class' => 'btn btn-danger w-100',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить этот файл?',
                                    'method' => 'post'
                                ]
                            ]
                        ) ?>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<style>
    body {
        overflow-x: hidden;
    }

    .media-preview {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
    }

    .card {
        overflow: hidden;
    }

    .card-title {
        word-break: break-word;
    }

    .btn-primary {
        font-weight: 600;
    }
</style>
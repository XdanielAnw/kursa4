    <?php

    use yii\bootstrap5\Html;

    /** @var array $assets */
    $this->title = 'Таблица Контента';
    ?>

    <div class="container py-5" style="background-color: #010101; border-radius: 8px; padding: 30px;">
        <h3 class="mb-4" style="color: #fff;"><?= Html::encode($this->title) ?></h3>

        <p>
            <?= Html::a('Добавить новые файлы', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>

        <div class="table-responsive">
            <table class="table"
                style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <thead style="background-color: #e0e0e0;">
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Теги</th>
                        <th>Превью</th>
                        <th>Подписка</th>
                        <th>Создатель</th>
                        <th>Категория</th>
                        <th>Удаление</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assets as $asset): ?>
                        <tr style="transition: background 0.3s;" onmouseover="this.style.background='#f5f5f5';"
                            onmouseout="this.style.background='transparent';">
                            <td><?= $asset->id ?></td>
                            <td><?= Html::encode($asset->title) ?></td>
                            <td>
                                <?php
                                $tagNames = array_map(function ($tag) {
                                    return $tag->title;
                                }, $asset->tags);
                                echo Html::encode(implode(', ', $tagNames));
                                ?>
                            </td>
                            <td>
                                <?php if ($asset->file_url): ?>
                                    <?php if (in_array($asset->type, ['png', 'jpg', 'jpeg', 'svg'])): ?>
                                        <img src="<?= Html::encode($asset->file_url) ?>" width="100" style="border-radius: 4px;">
                                    <?php elseif (in_array($asset->type, ['mp4', 'mov'])): ?>
                                        <video width="150" controls style="border-radius: 4px;">
                                            <source src="<?= Html::encode($asset->file_url) ?>" type="video/mp4">
                                            Ваш браузер не поддерживает видео тег
                                        </video>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td><?= !empty($asset->is_premium) ? '⭐' : '-' ?></td>
                            <td><?= Html::encode($asset->creator->username ?? 'Неизвестно') ?></td>
                            <td><?= Html::encode($asset->category->title ?? 'Не указано') ?></td>
                            <td>
                                <?= Html::a('Удалить', [
                                    'asset/delete',
                                    'id' => $asset->id
                                ], [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Вы уверены, что хотите удалить этот файл?',
                                        'method' => 'post',
                                    ]
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .table th,
        .table td {
            vertical-align: middle;
            border-color: #010101;
        }

        .table th {
            font-weight: 600;
        }

        .btn-primary {
            font-weight: 600;
        }

        
    </style>
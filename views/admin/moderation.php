<?php
use yii\helpers\Html;

/** @var $assets app\models\Asset[] */
$this->title = 'Модерация контента';
?>

<h2 class="display-10 fw-bold text-light"><?= Html::encode($this->title) ?></h2>

<table class="table table-bordered table-dark">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Файл</th>
            <th>Creator</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($assets as $asset): ?>
            <tr>
                <td><?= $asset->id ?></td>
                <td><?= Html::encode($asset->title) ?></td>
                <td><?= Html::a('Открыть', $asset->file_url, ['target' => '_blank']) ?></td>
                <td><?= Html::encode($asset->creator->username ?? 'Неизвестно') ?></td>
                <td>
                    <?= Html::a('Одобрить', ['approve', 'id' => $asset->id], [
                        'class' => 'btn btn-success btn-sm',
                        'data-confirm' => 'Одобрить этот контент?',
                        'data-method' => 'post'
                    ]) ?>

                    <?= Html::a('Отклонить', ['reject', 'id' => $asset->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data-confirm' => 'Удалить этот контент?',
                        'data-method' => 'post'
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

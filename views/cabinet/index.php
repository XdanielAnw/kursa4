<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var app\models\User $user */
?>
<div class="cabinet-wrapper">

    <div class="cabinet-header">
        <h2>Личный кабинет</h2>
        <p>Управление профилем и загрузками</p>
    </div>

    <div class="glass-card">

        <div class="profile-grid">

            <div class="profile-info">
                <div class="label">Логин</div>
                <div class="value"><?= Html::encode($user->login) ?></div>

                <div class="label">ФИО</div>
                <div class="value"><?= Html::encode($user->username) ?></div>

                <div class="label">Email</div>
                <div class="value"><?= Html::encode($user->email) ?></div>

                <div class="label">Статус</div>
                <div class="value">
                    <?php

                    switch ($user->role) {
                        case 0:
                            echo '<span class="tag light">Лайт</span>';
                            break;
                        case 1:
                            echo '<span class="tag premium">Премиум</span>';
                            break;
                        case 2:
                            echo '<span class="tag creator">Творец</span>';
                            break;
                        case 3:
                            echo '<span class="tag admin">Админ</span>';
                            break;
                        default:
                            echo '<span class="tag">Не указана</span>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

    <!-- DOWNLOADS -->
    <div class="section-title">
        Мои скачивания
    </div>

    <?php if (!empty($downloads)): ?>

        <div class="grid">

            <?php foreach ($downloads as $download): ?>
                <?php if ($download->asset): ?>

                    <div class="card">

                        <div class="thumb">

                            <?php if (in_array($download->asset->type, ['png', 'jpg', 'jpeg', 'svg'])): ?>
                                <img src="<?= Html::encode($download->asset->file_url) ?>">
                            <?php elseif (in_array($download->asset->type, ['mp4', 'mov', 'webm'])): ?>

                                <video class="media-preview" muted>
                                    <source src="<?= Html::encode($download->asset->file_url) ?>" type="video/mp4">
                                </video>

                            <?php else: ?>
                                <div class="video-badge">FILE</div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body">

                            <div class="title">
                                <?= Html::encode($download->asset->title) ?>
                            </div>

                            <div class="meta">
                                ID: #<?= $download->asset->id ?>
                            </div>

                            <a class="btn" href="/asset/download?id=<?= $download->asset->id ?>">
                                Скачать снова
                            </a>

                        </div>

                    </div>

                <?php endif; ?>
            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="empty">
            У вас пока нет скачиваний
        </div>

    <?php endif; ?>

    <!-- LOGOUT -->
    <div class="logout">
        <?= Html::beginForm(['/site/logout'], 'post') ?>
        <button class="logout-btn">Выйти</button>
        <?= Html::endForm() ?>
    </div>

</div>

<style>
    body {
        background: radial-gradient(circle at top, #1b1b1b, #0a0a0a);
        color: #fff;
        font-family: Inter, sans-serif;
    }

    .cabinet-wrapper {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
    }

    .cabinet-header h1 {
        font-size: 34px;
        margin-bottom: 5px;
    }

    .cabinet-header p {
        color: #aaa;
    }

    /* GLASS CARD */
    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        padding: 20px;
        border-radius: 16px;
        margin-bottom: 30px;
    }

    .profile-info .label {
        color: #888;
        font-size: 12px;
        margin-top: 10px;
    }

    .profile-info .value {
        font-size: 15px;
        margin-bottom: 8px;
    }

    /* TAGS */
    .tag {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .tag.premium {
        background: #00bcd4;
        color: #000;
    }

    .tag.creator {
        background: #ff9800;
        color: #000;
    }

    .tag.admin {
        background: #ff5252;
    }

    .tag.light {
        background: #9e9e9e;
    }

    /* GRID */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    /* CARD */
    .card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.06);
        transition: 0.2s;
    }

    .card:hover {
        transform: translateY(-4px);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .thumb {
        width: 100%;
        height: 180px;
        position: relative;
        overflow: hidden;
        background: #111;
    }

    /* ОБЩИЙ СТИЛЬ ДЛЯ ВСЕХ МЕДИА */
    .thumb img,
    .thumb video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* VIDEO overlay fix */
    .media-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* fallback */
    .video-badge {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #111;
        font-weight: bold;
        color: #ff9800;
    }

    /* CARD BODY */
    .card-body {
        padding: 12px;
    }

    .title {
        color: #fff;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .meta {
        font-size: 12px;
        color: #888;
        margin-bottom: 10px;
    }

    /* EMPTY */
    .empty {
        padding: 40px;
        text-align: center;
        color: #777;
        border: 1px dashed #333;
        border-radius: 12px;
    }

    /* LOGOUT */
    .logout {
        text-align: center;
        margin-top: 40px;
    }

    .logout-btn {
        background: transparent;
        border: 1px solid #ff5252;
        color: #ff5252;
        padding: 8px 16px;
        border-radius: 10px;
        cursor: pointer;
    }

    .logout-btn:hover {
        background: #ff5252;
        color: #000;
    }
</style>
<?php

use app\models\Category;
use app\models\User;
use app\models\Asset;
use yii\bootstrap5\ArrayHelper;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;


/** @var $model app\models\Asset */
$this->title = 'Добавить контент';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">

            <div class="card bg-dark text-light shadow-lg">
                <div class="card-header text-center fs-4 fw-bold">
                    <?= Html::encode($this->title) ?>
                </div>
                <div class="card-body">

                    <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data'],
                    ]); ?>

                    <div class="row g-4">

                        <!-- ================= LEFT: UPLOAD ================= -->
                        <div class="col-md-5">

                            <?= $form->field($model, 'file')->fileInput([
                                'id' => 'fileInput',
                                'class' => 'd-none'
                            ])->label('Выбрать файл') ?>

                            <div class="upload-zone" id="uploadZone">

                                <div class="upload-inner" id="uploadPlaceholder">
                                    <div class="plus">+</div>
                                    <div class="text">Перетащите файл или нажмите</div>
                                </div>

                                <div class="preview-wrapper d-none" id="previewWrapper">
                                    <img id="previewImage" class="preview-img" />

                                    <button type="button" class="change-btn" id="changeBtn">
                                        ✎
                                    </button>
                                </div>

                            </div>

                        </div>

                        <!-- ================= RIGHT: FORM ================= -->
                        <div class="col-md-7">

                            <?= $form->field($model, 'title')->textInput([
                                'required' => true,
                                'class' => 'form-control bg-secondary text-light border-0'
                            ]) ?>

                            <?= $form->field($model, 'type')->dropDownList(
                                [
                                    'png' => 'Изображение (png)',
                                    'jpg' => 'Изображение (jpg)',
                                    'jpeg' => 'Изображение (jpeg)',
                                    'mp4' => 'Видео (mp4)',
                                    'mov' => 'Видео (mov)',
                                    'mkv' => 'Видео (mkv)',
                                    'svg' => 'Иконка (svg)',
                                ],
                                [
                                    'prompt' => 'Выберите тип контента',
                                    'class' => 'form-select bg-secondary text-light border-0'
                                ]
                            ) ?>

                            <?= $form->field($model, 'is_premium')->checkbox([
                                'label' => 'Премиальный контент',
                                'class' => 'form-check-input'
                            ]) ?>

                            <?= $form->field($model, 'tagsInput')->textInput([
                                'placeholder' => 'Введите до 5 тегов через запятую',
                                'class' => 'form-control bg-secondary text-light border-0'
                            ]) ?>

                            <?= $form->field($model, 'category_id')->dropDownList(
                                [
                                    1 => 'Фотография',
                                    2 => 'Видео',
                                    3 => 'Иконка'
                                ],
                                [
                                    'prompt' => 'Категория',
                                    'class' => 'form-select bg-secondary text-light border-0'
                                ]
                            ) ?>

                        </div>

                        <div class="mt-4 text-center">
                            <?= Html::submitButton('Предложить пост', ['class' => 'btn btn-warning px-5 fw-bold']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .upload-zone {
            height: 320px;
            border: 2px dashed #666;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            background: #2b2b2b;
        }

        .upload-zone:hover {
            border-color: #ffc107;
            background: #333;
        }

        .upload-inner {
            text-align: center;
            color: #bbb;
        }

        .upload-inner .plus {
            font-size: 56px;
            font-weight: bold;
            color: #ffc107;
        }

        .upload-inner .text {
            margin-top: 8px;
            font-size: 14px;
        }

        #preview img,
        #preview video {
            width: 100%;
            border-radius: 12px;
            margin-top: 10px;
        }

        .upload-zone {
            height: 320px;
            border: 2px dashed #666;
            border-radius: 16px;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            background: #2b2b2b;
            transition: 0.3s;
        }

        .upload-zone:hover {
            border-color: #ffc107;
            background: #333;
        }

        .upload-inner {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #bbb;
        }

        .upload-inner .plus {
            font-size: 56px;
            color: #ffc107;
            font-weight: bold;
        }

        .upload-inner .text {
            font-size: 14px;
            margin-top: 5px;
        }

        /* PREVIEW IMAGE */
        .upload-zone {
            border: 2px dashed #666;
            border-radius: 16px;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            background: #2b2b2b;
            transition: 0.3s;

            /* важно */
            width: 100%;
        }

        .preview-wrapper {
            position: relative;
            width: 100%;
        }

        /* 🔥 главное изменение */
        .preview-img {
            width: 100%;
            height: auto;
            max-height: 420px;
            /* ограничение чтобы не ломало страницу */
            display: block;
            border-radius: 12px;
        }

        /* кнопка */
        .change-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }

        .change-btn:hover {
            background: #ffc107;
            color: #000;
        }



        .tag-chip {
            display: inline-block;
            background: #ffc107;
            color: #000;
            padding: 5px 10px;
            border-radius: 20px;
            margin: 5px 5px 0 0;
            font-size: 12px;
            font-weight: bold;
        }
    </style>


    <script>
        const fileInput = document.getElementById('fileInput');
        const zone = document.getElementById('uploadZone');

        const placeholder = document.getElementById('uploadPlaceholder');
        const previewWrapper = document.getElementById('previewWrapper');
        const previewImage = document.getElementById('previewImage');
        const changeBtn = document.getElementById('changeBtn');

        // открыть выбор файла
        zone.addEventListener('click', () => fileInput.click());
        changeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            fileInput.click();
        });

        // drag over
        zone.addEventListener('dragover', (e) => {
            e.preventDefault();
            zone.style.borderColor = '#ffc107';
        });

        // drag leave
        zone.addEventListener('dragleave', () => {
            zone.style.borderColor = '#666';
        });

        // drop
        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            fileInput.files = e.dataTransfer.files;
            showPreview(fileInput.files[0]);
        });

        // change
        fileInput.addEventListener('change', () => {
            showPreview(fileInput.files[0]);
        });

        // preview
        function showPreview(file) {
            if (!file) return;

            const reader = new FileReader();

            reader.onload = function(e) {
                const url = e.target.result;

                if (file.type.startsWith('image')) {

                    previewImage.src = url;

                    placeholder.classList.add('d-none');
                    previewWrapper.classList.remove('d-none');

                } else {
                    alert('Можно загружать только изображения');
                }
            };

            reader.readAsDataURL(file);
        }
    </script>
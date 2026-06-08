<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Логин';
?>

<div class="site-login" style="min-height: 60vh; display: flex; align-items: center; justify-content: center; background-color: #000;">
    <div class="card p-4 shadow-lg" style="width: 400px; background-color: #010101; border: 1px solid #fff;">
        <h3 class="text-center text-white mb-4">Страница Авторизации</h3>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label text-white'],
                'inputOptions' => ['class' => 'form-control bg-dark text-white border-white'],
                'errorOptions' => ['class' => 'invalid-feedback text-red'],
            ],
        ]); ?>

        <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"form-check mb-3\">{input} {label}</div>\n{error}",
            'labelOptions' => ['class' => 'form-check-label text-white'],
            'inputOptions' => ['class' => 'form-check-input'],
        ]) ?>

        <div class="form-group mt-3">
            <div class="d-flex justify-content-between gap-2">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-outline-primary w-50', 'name' => 'login-button']) ?>
                <?= Html::a('Зарегистрироваться', ['/site/register'], ['class'=>'btn btn-outline-info w-50 text-center']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="mt-3 text-white small text-center">
            для <strong>admin/admin</strong>
        </div>
    </div>
</div>

<style>
/* Поля ввода */
.form-control:focus {
    border-color: #fff;
    box-shadow: none;
    background-color: #010101;
    color: #fff;
}

/* Кнопки */
.btn-outline-primary {
    color: #fff;
    border-color: #fff;
}
.btn-outline-primary:hover {
    background-color: #fff;
    color: #000;
}

.btn-outline-info {
    color: #fff;
    border-color: #17a2b8;
}
.btn-outline-info:hover {
    background-color: #17a2b8;
    color: #fff;
}

/* Checkbox */
.form-check-input:checked {
    background-color: #fff;
    border-color: #fff;
}

/* Подписи */
.form-label {
    font-weight: 500;
}
</style>

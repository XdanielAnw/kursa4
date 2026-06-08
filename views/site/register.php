<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
?>
<div class="site-register" style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background-color: #000;">
    <div class="card p-4 shadow-lg" style="width: 400px; background-color: #010101; border: 1px solid #fff;">
        <h3 class="text-center text-white mb-4">Регистрация</h3>

        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'login')->textInput(['class'=>'form-control bg-dark text-white border-white']) ?>
            <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control bg-dark text-white border-white']) ?>
            <?= $form->field($model, 'username')->textInput(['class'=>'form-control bg-dark text-white border-white']) ?>
            <?= $form->field($model, 'email')->textInput(['class'=>'form-control bg-dark text-white border-white']) ?>
            
        
            <div class="form-group mt-4 g-1">
                <div class="d-flex ">
                    <?= Html::submitButton('Создать аккаунт', ['class' => 'btn btn-outline-primary w-100']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><!-- site-register -->

<style>
    .form-label {
        color: #fff;
    }
</style>

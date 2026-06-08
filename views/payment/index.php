<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Subscription $subscription */

$this->title = 'Оплата ' . Html::encode($subscription->title);
?>

<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-white">
            Оплата <?= Html::encode($subscription->title) ?>
        </h1>

        <p class="lead text-white">
            Вы собираетесь подключить подписку на
            <?= Html::encode($subscription->duration_days) ?>
            дней за
            <?= Html::encode($subscription->price) ?> ₽.
        </p>
    </div>

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-lg border-primary">

                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-normal my-0">
                        <?= Html::encode($subscription->title) ?>
                        –
                        <?= Html::encode($subscription->price) ?> ₽ /
                        <?= Html::encode($subscription->duration_days) ?> дней
                    </h3>
                </div>

                <div class="card-body">

                    <?php $form = ActiveForm::begin([
                        'id' => 'payment-form',
                        'action' => ['payment/process'],
                        'options' => [
                            'class' => 'needs-validation',
                            'novalidate' => true
                        ]
                    ]); ?>

                    <?= Html::hiddenInput('subscription_id', $subscription->id) ?>

                    <div class="mb-4">

                        <label class="form-label fw-bold">
                            Выберите способ оплаты:
                        </label>

                        <?= Html::dropDownList(
                            'payment_method',
                            null,
                            [
                                'card' => 'Банковская карта',
                                'sber' => 'СберБанк',
                                't-bank' => 'Т-Банк',
                                'alfa' => 'АльфаБанк',
                            ],
                            [
                                'class' => 'form-select',
                                'required' => true
                            ]
                        ) ?>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Номер карты
                        </label>

                        <input
                            type="text"
                            name="card_number"
                            class="form-control only-numbers card-format"
                            placeholder="0000-0000-0000-0000"
                            maxlength="19"
                            inputmode="numeric"
                            required
                        >

                        <div class="invalid-feedback">
                            Введите корректный номер карты
                        </div>

                    </div>

                    <div class="mb-3 row">

                        <div class="col">

                            <label class="form-label">
                                Срок действия
                            </label>

                            <input type="text" name="expiry" class="form-control" placeholder="MM/YY" maxlength="5"
                                required>

                            <div class="invalid-feedback">
                                Неверный формат даты
                            </div>

                        </div>

                        <div class="col">

                            <label class="form-label">
                                CVC
                            </label>

                            <input type="text" name="cvc" class="form-control only-numbers" placeholder="123"
                                maxlength="3" inputmode="numeric" pattern="[0-9]{3}" required>

                            <div class="invalid-feedback">
                                Неверный CVC
                            </div>

                        </div>

                    </div>

                    <div class="d-grid mt-4">

                    <?= Html::submitButton(
                        'Оплатить ' . Html::encode($subscription->price) . ' ₽',
                        [
                            'class' => 'btn btn-lg btn-primary',
                            'id' => 'payBtn',
                            'disabled' => true
                        ]
                    ) ?>

                    </div>

                    <?php ActiveForm::end(); ?>

                    <small class="text-muted d-block mt-3 text-center">
                        Все платежи защищены и безопасны.
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
.custom-error {
    font-size: 12px;
}
</style>

<script>
'use strict';

document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('payment-form');
    const btn = document.getElementById('payBtn');

    const cardInput = document.querySelector('.card-format');
    const expiryInput = document.querySelector('input[name="expiry"]');
    const cvcInput = document.querySelector('input[name="cvc"]');
    const method = form.querySelector('select[name="payment_method"], select[name*="payment_method"]');

    function validate() {

        const card = (cardInput?.value || '').replace(/\D/g, '');
        const expiry = expiryInput?.value || '';
        const cvc = cvcInput?.value || '';
        const payment = method?.value || '';

        let valid = true;

        if (card.length !== 16) valid = false;

        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) valid = false;

        if (cvc.length !== 3) valid = false;

        if (!payment) valid = false;

        btn.disabled = !valid;

        return valid;
    }

    // ===== карта
    cardInput?.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '').slice(0, 16);
        e.target.value = value.replace(/(.{4})/g, '$1-').replace(/-$/, '');
        validate();
    });

    // ===== expiry
    expiryInput?.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '').slice(0, 4);
        e.target.value = value.length > 2
            ? value.slice(0,2) + '/' + value.slice(2)
            : value;
        validate();
    });

    // ===== cvc
    cvcInput?.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 3);
        validate();
    });

    // ===== select
    method?.addEventListener('change', validate);

    form?.addEventListener('submit', (e) => {
        if (!validate()) e.preventDefault();
    });

    validate();
});

console.log(method);
</script>
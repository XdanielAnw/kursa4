<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Payment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $subscription_id
 * @property float $price
 * @property string $payment_date
 * @property string $status
 *
 * @property Subscription $subscription
 */
class Payment extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'subscription_id', 'price', 'status'], 'required'],
            [['user_id', 'subscription_id'], 'integer'],
            [['price'], 'number'],
            [['payment_date'], 'safe'],
            [['status'], 'string', 'max' => 255],
            [['subscription_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscription::class, 'targetAttribute' => ['subscription_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'subscription_id' => 'Subscription ID',
            'price' => 'Цена',
            'payment_date' => 'Payment Date',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Subscription]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscription()
    {
        return $this->hasOne(Subscription::class, ['id' => 'subscription_id']);
    }

}

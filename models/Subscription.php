<?php

namespace app\models;


use Yii;


/**
 * This is the model class for table "Subscription".
 *
 * @property int $id
 * @property string $title
 * @property float $price
 * @property int $duration_days
 *
 * @property Payment[] $payments
 * @property UserSubscription[] $userSubscriptions
 */
class Subscription extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price', 'duration_days'], 'required'],
            [['price'], 'number'],
            [['duration_days'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'duration_days' => 'Duration Days',
        ];
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::class, ['subscription_id' => 'id']);
    }

    /**
     * Gets query for [[UserSubscriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSubscriptions()
    {
        return $this->hasMany(UserSubscription::class, ['subscription_id' => 'id']);
    }

}

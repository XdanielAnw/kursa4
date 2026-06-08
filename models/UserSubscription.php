<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "UserSubscription".
 *
 * @property int $id
 * @property int $user_id
 * @property int $subscription_id
 * @property string $start_date
 * @property string $end_date
 * @property int $is_active
 *
 * @property Subscription $subscription
 * @property User $user
 */
class UserSubscription extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'UserSubscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active'], 'default', 'value' => 0],
            [['user_id', 'subscription_id', 'start_date', 'end_date'], 'required'],
            [['user_id', 'subscription_id', 'is_active'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'is_active' => 'Is Active',
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}

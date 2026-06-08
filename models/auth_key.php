<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $username
 * @property string $email
 * @property int $role
 * @property string $auth_key
 * @property string $created_at
 *
 * @property Asset[] $assets
 * @property UserSubscription[] $userSubscriptions
 */
class auth_key extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'default', 'value' => 0],
            [['login', 'password', 'username', 'email', 'auth_key'], 'required'],
            [['role'], 'integer'],
            [['created_at'], 'safe'],
            [['login', 'password', 'username', 'email', 'auth_key'], 'string', 'max' => 255],
            [['login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'username' => 'Username',
            'email' => 'Email',
            'role' => 'Role',
            'auth_key' => 'Auth Key',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Assets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssets()
    {
        return $this->hasMany(Asset::class, ['creator_id' => 'id']);
    }

    /**
     * Gets query for [[UserSubscriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSubscriptions()
    {
        return $this->hasMany(UserSubscription::class, ['user_id' => 'id']);
    }

}

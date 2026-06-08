<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
class User extends ActiveRecord implements IdentityInterface 
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User';
    }

    public function rules()
    {
        return [
            [['role'], 'default', 'value' => 0],
            [['login', 'password', 'username', 'email'], 'required'],
            [['role'], 'integer'],
            [['created_at'], 'safe'],
            [['login', 'password', 'username', 'email', 'auth_key'], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['login'], 'string', 'min' => 5],
            [['password'], 'string', 'min' => 3],
            [['login'], 'match', 'pattern' => '/^[a-z\d]+$/i', 'message' => 'латиница и цифры, не менее 6 символов'],
            [['username'], 'match', 'pattern' => '/^[а-яё\s]+$/ui', 'message' => 'символы кириллицы и побелы, не менее 3 символов'],
            [['email'],'email', 'message' => 'Почта должна содержать специальный знак @, например pochta@gmail.com'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'username' => 'Имя пользователя',
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

    public static function findByUsername(string $login): bool | User
    {
        return static::findOne(['login' => $login]) ?? false;
    }

    public function validatePassword(string $password): bool
    {  
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    
    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

}

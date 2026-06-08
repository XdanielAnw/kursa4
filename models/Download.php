<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Download".
 *
 * @property int $id
 * @property int $user_id
 * @property int $asset_id
 *
 * @property Asset $asset
 * @property User $user
 */
class Download extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Download';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'asset_id'], 'required'],
            [['user_id', 'asset_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['asset_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asset::class, 'targetAttribute' => ['asset_id' => 'id']],
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
            'asset_id' => 'Asset ID',
        ];
    }

    /**
     * Gets query for [[Asset]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAsset()
    {
        return $this->hasOne(Asset::class, ['id' => 'asset_id']);
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

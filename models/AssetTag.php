<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "AssetTag".
 *
 * @property int $asset_id
 * @property int $tag_id
 *
 * @property Asset $asset
 * @property Tag $tag
 */
class AssetTag extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'AssetTag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asset_id', 'tag_id'], 'required'],
            [['asset_id', 'tag_id'], 'integer'],
            [['asset_id', 'tag_id'], 'unique', 'targetAttribute' => ['asset_id', 'tag_id']],
            [['asset_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asset::class, 'targetAttribute' => ['asset_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::class, 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'asset_id' => 'Asset ID',
            'tag_id' => 'Tag ID',
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
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }

}

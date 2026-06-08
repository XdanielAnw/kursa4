<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Tag".
 *
 * @property int $id
 * @property string $title
 *
 * @property AssetTag[] $assetTags
 * @property Asset[] $assets
 */
class Tag extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
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
        ];
    }

    /**
     * Gets query for [[AssetTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssetTags()
    {
        return $this->hasMany(AssetTag::class, ['tag_id' => 'id']);
    }

    /**
     * Gets query for [[Assets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssets()
    {
        return $this->hasMany(Asset::class, ['id' => 'asset_id'])->viaTable('AssetTag', ['tag_id' => 'id']);
    }

}

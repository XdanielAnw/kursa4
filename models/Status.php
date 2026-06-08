<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Status".
 *
 * @property int $id
 * @property string $title
 * @property string $aliase
 *
 * @property Asset[] $assets
 */
class Status extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'aliase'], 'required'],
            [['title', 'aliase'], 'string', 'max' => 255],
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
            'aliase' => 'Aliase',
        ];
    }

    /**
     * Gets query for [[Assets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssets()
    {
        return $this->hasMany(Asset::class, ['status_id' => 'id']);
    }

}

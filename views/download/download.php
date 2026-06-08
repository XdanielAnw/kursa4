<?php

namespace app\models;

use yii\db\ActiveRecord;

class Download extends ActiveRecord
{
    public static function tableName()
    {
        return 'download';
    }

    public function getAsset()
    {
        return $this->hasOne(
            Asset::class,
            ['id' => 'asset_id']
        );
    }

    public function getUser()
    {
        return $this->hasOne(
            User::class,
            ['id' => 'user_id']
        );
    }
}

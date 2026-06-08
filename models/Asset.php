<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Asset".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string|null $preview_url
 * @property string $file_url
 * @property int $is_premium
 * @property int $status_id
 * @property int $creator_id
 * @property int $category_id
 *
 * @property Status $status
 * @property AssetTag[] $assetTags
 * @property Category $category
 * @property User $creator
 * @property Tag[] $tags
 */
class Asset extends \yii\db\ActiveRecord
{
    public $file;

    public $tagsInput;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Asset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
{
    return [
        [['title'], 'required'],
            [['type'], 'default', 'value' => 'image'],
            [['is_premium'], 'boolean'],
            [['is_premium'], 'default', 'value' => 0],
            [['creator_id', 'category_id',  'status_id'], 'integer'],
            [['creator_id'], 'default', 'value' => Yii::$app->user->id],
            [['status_id'], 'default', 'value' => 1],
            [['title', 'preview_url', 'file_url'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
            [['file'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'mp4', 'mov', 'mkv', 'svg']],
            [['tagsInput'], 'string'],
            [['tagsInput'], 'validateTags'], // кастомная валидация тегов
    ];
}

/**
     * Кастомная валидация тегов: максимум 5
     */
    public function validateTags($attribute, $params)
    {
        $tags = array_filter(array_map('trim', explode(',', $this->$attribute)));
        if (count($tags) > 5) {
            $this->addError($attribute, 'Можно выбрать максимум 5 тегов.');
        }
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'type' => 'Тип файла',
            'preview_url' => 'Preview Url',
            'file_url' => 'Путь к файлу (/uploads/images-videos-icons/file_name.format)',
            'is_premium' => 'Премиальный',
            'creator_id' => 'ID Создателя',
            'category_id' => 'Категория',
            'status_id' => 'Статус',
            'tagsInput' => 'Теги (до 5, через запятую)',
        ];
    }
    

    /**
     * Gets query for [[AssetTags]].
     *
     * @return \yii\db\ActiveQuery
     */
        public function getAssetTags()
    {
        return $this->hasMany(AssetTag::class, ['asset_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->via('assetTags'); // правильное имя связи
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

        public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Сохраняем теги после сохранения ассета
     */
    public function afterSave($insert, $changedAttributes)
{
    parent::afterSave($insert, $changedAttributes);

    if ($this->tagsInput) {
        $tags = array_filter(array_map('trim', explode(',', $this->tagsInput)));

        // Удаляем старые связи
        AssetTag::deleteAll(['asset_id' => $this->id]);

        foreach ($tags as $tagName) {
            // ищем тег по названию
            $tag = Tag::findOne(['title' => $tagName]);
            if (!$tag) {
                $tag = new Tag();
                $tag->title = $tagName;
                $tag->save(false);
            }

            $assetTag = new AssetTag();
            $assetTag->asset_id = $this->id;
            $assetTag->tag_id = $tag->id;
            $assetTag->save(false);
        }
    }
}

    public function deleteFile()
    {
        if ($this->file_url && file_exists(Yii::getAlias('@webroot') . $this->file_url)) {
            unlink(Yii::getAlias('@webroot') . $this->file_url);
        }

        $this->file_url = null;
        $this->save(false);
    }

}

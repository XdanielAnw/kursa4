<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Download;
use yii\web\NotFoundHttpException;
use app\models\Asset;

class AssetController extends Controller
{
    // Галерея изображений
    public function actionGalleryImages()
    {
        $assets = Asset::find()
            ->where(['status_id' => 2])
            ->andWhere(['in', 'type', ['png', 'jpg', 'jpeg', 'svg']])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('gallery-images', compact('assets'));
    }

    // Галерея видео
    public function actionGalleryVideos()
    {
        $assets = Asset::find()
            ->where(['status_id' => 2])
            ->andWhere(['category_id' => 2])
            ->andWhere(['in', 'type', ['mp4', 'mov', 'mkv']])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('gallery-videos', compact('assets'));
    }

    // Просмотр одного ассета
    public function actionView($id)
    {
        $model = Asset::find()
            ->where([
                'id' => $id,
                'status_id' => 2
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Материал не найден');
        }

        return $this->render('view', compact('model'));
    }

    public function actionCreate()
    {
        $model = new Asset();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                // Выбираем папку по категории
                switch ($model->category_id) {
                    case 1:
                        $folder = 'images';
                        break;   // Фотографии
                    case 2:
                        $folder = 'videos';
                        break;   // Видео
                    case 3:
                        $folder = 'icons';
                        break;    // Иконки
                    default:
                        $folder = 'uploads';
                }

                $fileName = uniqid() . '.' . $model->file->extension;
                $filePath = "/$folder/$fileName";

                // Сохраняем файл в папку
                $model->file->saveAs(Yii::getAlias('@webroot') . $filePath);

                // Присваиваем путь модели
                $model->file_url = $filePath;
            }

            // Сохраняем модель
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Asset::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Файл не найден');
        }

        // удалить файл с диска
        if ($model->file_url && file_exists(Yii::getAlias('@webroot') . $model->file_url)) {
            unlink(Yii::getAlias('@webroot') . $model->file_url);
        }

        // удалить запись
        $model->delete();

        Yii::$app->session->setFlash('success', 'Файл удалён');

        return $this->redirect(['/creator/index']);
    }

    public function actionDownload($id)
    {
        $asset = Asset::findOne($id);

        if (!$asset) {
            throw new NotFoundHttpException('Файл не найден');
        }

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $filePath = Yii::getAlias('@webroot') . $asset->file_url;

        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Файл отсутствует');
        }

        // сохраняем скачивание
        Yii::$app->db->createCommand()->insert('download', [
            'user_id' => Yii::$app->user->id,
            'asset_id' => $asset->id,
        ])->execute();

        return Yii::$app->response->sendFile($filePath);
    }
    
}

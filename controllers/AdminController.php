<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use app\models\Asset;

class AdminController extends Controller
{
    /**
     * Доступ ТОЛЬКО для админа (role = 1)
     */
    public function behaviors()
{
    return [
        'access' => [
            'class' => \yii\filters\AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'matchCallback' => function () {
                        return !Yii::$app->user->isGuest
                            && Yii::$app->user->identity->role == 3;
                    },
                ],
            ],
        ],
    ];
}

    /**
     * Все опубликованные ассеты (status = 2)
     */
    public function actionIndex()
    {
        $assets = Asset::find()
            ->where(['status_id' => 2])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', compact('assets'));
    }

    /**
     * Создание ассета админом (сразу публикуется)
     */
    public function actionCreate()
    {
        $model = new Asset();

        if ($model->load(Yii::$app->request->post())) {

            $model->creator_id = Yii::$app->user->id;
            $model->status_id = 2; // ⬅ сразу опубликовано

            $file = UploadedFile::getInstance($model, 'file');
            if ($file) {
                $uploadPath = Yii::getAlias('@webroot/uploads/images/');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $fileName = uniqid() . '.' . $file->extension;
                if ($file->saveAs($uploadPath . $fileName)) {
                    $model->file_url = '/uploads/images/' . $fileName;
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Файл успешно опубликован');
                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('error', implode(', ', $model->getFirstErrors()));
        }

        return $this->render('create', compact('model'));
    }

    /**
     * Модерация — файлы в ожидании (status = 1)
     */
    public function actionModeration()
    {
        $assets = Asset::find()
            ->where(['status_id' => 1])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('moderation', compact('assets'));
    }

    /**
     * Одобрить файл (status = 2)
     */
    public function actionApprove($id)
    {
        $asset = Asset::findOne($id);

        if ($asset && $asset->status_id == 1) {
            $asset->status_id = 2;
            $asset->save(false);
            Yii::$app->session->setFlash('success', 'Файл опубликован');
        }

        return $this->redirect(['moderation']);
    }

    /**
     * Отклонить файл (status = 3)
     */
    public function actionReject($id)
    {
        $asset = Asset::findOne($id);
    
        // Проверяем, что файл существует и находится в ожидании
        if ($asset && $asset->status_id == 1) {
            $asset->status_id = 3; // отклонён
            $asset->save(false);
    
            Yii::$app->session->setFlash('warning', 'Файл отклонён и больше не отображается администратору');
        }
    
        // После отклонения редиректим обратно на модерацию,
        // но теперь файл с status_id = 3 уже не попадёт в выборку
        return $this->redirect(['moderation']);
    }
}
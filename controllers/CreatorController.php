<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\models\Asset;

class CreatorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => fn () =>
                            Yii::$app->user->identity->role == 2 // creator
                    ],
                ],
            ],
        ];
    }

    // список МОИХ отправленных материалов
    public function actionIndex()
    {
        $assets = Asset::find()
            ->where(['creator_id' => Yii::$app->user->id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', compact('assets'));
    }

    // отправка на модерацию
    public function actionCreate()
    {
        $model = new Asset();

        if ($model->load(Yii::$app->request->post())) {

            $model->creator_id = Yii::$app->user->id;
            $model->status_id  = 1; // ⬅ ОТПРАВЛЕНО АДМИНУ

            $file = UploadedFile::getInstance($model, 'file');
            if ($file) {
                $path = Yii::getAlias('@webroot/uploads/pending/');
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                $fileName = uniqid() . '.' . $file->extension;
                if ($file->saveAs($path . $fileName)) {
                    $model->file_url = '/uploads/pending/' . $fileName;
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash(
                    'success',
                    'Материал отправлен администратору на проверку'
                );
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', compact('model'));
    }
}

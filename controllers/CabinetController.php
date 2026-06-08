<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use yii\filters\AccessControl;

use app\models\Download;

class CabinetController extends Controller
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
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        // Все скачивания пользователя
        $downloads = Download::find()
            ->where([
                'user_id' => $user->id
            ])
            ->with('asset')
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'user' => $user,
            'downloads' => $downloads,
        ]);
    }
}

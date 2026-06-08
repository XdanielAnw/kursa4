<?php

namespace app\controllers;

use Symfony\Component\VarDumper\VarDumper;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

use app\models\Asset;



class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
{
    $assets = Asset::find()->all(); // Все активы
    return $this->render('index', [
        'assets' => $assets,
    ]);
}

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash("success", "Вы успешно вошли!");
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister() 
    {
        $model = new \app\models\User(); 
        if ($model->load(Yii::$app->request->post())) { 
            if ($model->validate()) {
                $model->auth_key = Yii::$app->security->generateRandomString();
                $model->password = Yii::$app->security->generatePasswordHash($model->password);
                if ($model->save(false)) {
                    Yii::$app->user->login($model, 24 * 3600);
                    Yii::$app->session->setFlash('success','Успешная регистрация!');
                    Yii::$app->session->setFlash('info','Пользователь успешно авторизован!');
                    return $this->goHome();

                } else {
                    VarDumper::dump($model->errors, 10, true); die;
                }
            } 
        } 
        return $this->render('register', [ 'model' => $model, ]); 
    }

    // public function actionGalleryImages()
    // {
    //     // Получаем все активные фотографии
    //     $assets = Asset::find()->all();  
    
    //     // Передаем массив $assets в view
    //     return $this->render('gallery-images', [
    //         'assets' => $assets,
    //     ]);
    // }

    // public function actionGalleryVideos()
    // {
    //     return $this->render('gallery-videos');
    // }

    // public function actionGalleryIcons()
    // {
    //     return $this->render('gallery-icons');
    // }

    public function actionGalleryImages()
{
    // Выбираем только изображения: png, jpg, jpeg
    $assets = Asset::find()
        ->where(['category_id' => 1, 'status_id'   => 2])
        ->andWhere(['in', 'type', ['png','jpg','jpeg']])
        ->all();

    return $this->render('gallery-images', compact('assets'));
}

public function actionGalleryVideos()
{
    // Только mp4
    $assets = Asset::find()
        ->where(['category_id' => 2, 'status_id'   => 2])
        ->andWhere(['type' => ['mp4', 'mov', 'mkv']])
        ->all();

    return $this->render('gallery-videos', compact('assets'));
}

public function actionGalleryIcons()
{
    // Только svg
    $assets = Asset::find()
        ->where(['category_id' => 3, 'status_id'   => 2])
        ->andWhere(['type' => 'svg'])
        ->all();

    return $this->render('gallery-icons', compact('assets'));
}




}

<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Asset;

class SearchController extends Controller
{
    public function actionIndex()
    {
        // 🔍 Получаем параметры поиска
        $term = trim(Yii::$app->request->get('term', '')); // общий термин: название или тег
        $category = Yii::$app->request->get('category');

        // Создаем запрос с join на тег
        $query = Asset::find()->joinWith('tags'); // связь tags из Asset

        // Поиск по названию
        if ($term !== '') {
            $query->andWhere([
                'or',
                ['like', 'Asset.title', $term],
                ['like', 'Tag.title', $term], // ищем по тегам
            ]);
        }

        // Фильтр по категории
        if ($category) {
            $query->andWhere(['Asset.category_id' => (int)$category]);
        }

        // Чтобы не дублировались ассеты при нескольких тегах
        $query->distinct();

        $assets = $query->all();

        // Если это AJAX-запрос (для поиска в реальном времени)
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_assets', [
                'assets' => $assets,
            ]);
        }

        // Обычный рендер страницы
        return $this->render('index', [
            'assets' => $assets,
            'term' => $term,
            'category' => $category,
        ]);
    }
}

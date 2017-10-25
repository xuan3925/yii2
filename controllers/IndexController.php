<?php
    namespace app\controllers;

    use yii\web\Controller;
    use app\models\Category;

    class IndexController extends Controller{
        public function actionIndex(){
           $this->layout = 'main';
           $model = new Category();
           $menu = $model->getMenu();
           print_r($menu);
           return $this->render('index');
        }
    }
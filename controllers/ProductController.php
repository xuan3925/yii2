<?php
    namespace app\controllers;
    use yii\web\Controller;
    use app\models\Category;

    class ProductController extends  Controller{
        public $layout = 'main2';
        public function actionIndex(){

           return $this->render('index');
        }
        public function actionDetail(){
            return $this->render('detail');
        }
    }
<?php
    namespace app\controllers;
    use yii\web\Controller;

    class OrderController extends Controller{
        public $layout = 'main2';
        public function actionIndex(){
            return $this->render('index');
        }
        public function actionCheck(){
            return $this->render('check');
        }
    }
<?php
    namespace app\controllers;
    use yii\web\Controller;
    use Yii;
    class FooterController extends Controller{
        public function actionIndex(){
            $this->layout = false;
            return $this->render('index');

        }
    }
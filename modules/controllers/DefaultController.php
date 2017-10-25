<?php

    namespace app\modules\controllers;

    use app\modules\controllers\BaseController;
    use Yii;

    class DefaultController extends BaseController
    {

        public function actionIndex(){
            $this->layout = 'main';
            return $this->render('index');
        }
    }

<?php
    namespace app\modules\controllers;
    use yii\web\Controller;
    use app\modules\models\Admin;
    use Yii;
    class PublicController extends Controller{
        public function actionLogin(){
            $this->layout = false;
            $model = new Admin();
            if(Yii::$app->request->isPost){
                $post = Yii::$app->request->post();
                if($model->login($post)){
                    $this->redirect(['default/index']);
                    Yii::$app->end();
        }
            }
            return $this->render('login',['model' => $model]);
        }

        public function actionLogout(){
            $this->layout = false;
            Yii::$app->session->removeAll();
            if(!isset(Yii::$app->session['admin']['isLogin'])){
                $this->redirect(['public/login']);
                Yii::$app->end();
            }
            $this->goBack();
        }

        public function actionSeekpassword(){
            $this->layout = false;
            $model = new Admin();
            if(Yii::$app->request->isPost){
                $post = Yii::$app->request->post();
                if($model->seekpass($post)){
                    Yii::$app->session->setFlash('info','电子邮件已发送，请查收');
                }
            }
            return $this->render('seekpassword',['model'=>$model]);
        }

        //找回密码
        public function actionMailchangepass(){
            $this->layout = false;
            $time = Yii::$app->request->get('timestamp');
            $adminUser = Yii::$app->request->get('adminUser');
            $token = Yii::$app->request->get('token');
            $model = new Admin();
            $myToken = $model->createToken($adminUser,$time);
            if($token != $myToken){
                $this->redirect(['public/login']);
                Yii::$app->end();
            }
            if(time() - $time > 300){
                $this->redirect(['public/login']);
                Yii::$app->end();
            }
            if(Yii::$app->request->isPost){
                $post = Yii::$app->request->post();
                if($model->changepass($post)){
                    Yii::$app->session->setFlash('info','密码修改成功');
                }
            }
            $model->adminUser = $adminUser;
            return $this->render('mailchangepass',['model'=>$model]);
        }
    }
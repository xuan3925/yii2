<?php
    namespace app\controllers;
    use yii\web\Controller;
    use app\models\User;
    use Yii;
    class MemberController extends Controller{
        public function actionAuth(){
            $this->layout = 'main2';
            if(Yii::$app->request->isGet){
                $url = Yii::$app->request->referrer;
                if(empty($url)){
                    $url = "[index/index]";
                }
                Yii::$app->session->setFlash('referrer',$url);
            }
            $model = new User();
            if(Yii::$app->request->isPost){
                $post = Yii::$app->request->post();
                if($model->login($post)){
                    $url = Yii::$app->session->getFlash('referrer');
                    return $this->redirect($url);
                }
            }
            if(Yii::$app->session['isLogin'] == 1){
                return $this->redirect(['index/index']);
            }
            return $this->render('auth',['model'=>$model]);
        }

        //退出登录
        public function actionLogout(){
            Yii::$app->session->remove('userName');
            Yii::$app->session->remove('isLogin');
            if(!isset(Yii::$app->session['isLogin'])){
                return $this->goBack(Yii::$app->request->referrer);
            }
        }
    }
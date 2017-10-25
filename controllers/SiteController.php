<?php
    namespace app\controllers;
    use yii\web\Controller;
    use app\models\EntryForm;
    use Yii;
    class SiteController extends Controller{
        public function actionSay($message = 'hello'){
            $this->layout = false;
            return $this->render('say',['message'=>$message]);
        }
        public function actionEntry(){
            $model = new EntryForm;
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                return $this->render('entry-confirm',['model'=>$model]);
            }else{
                return $this->render('entry',['model'=>$model]);
            }
        }
    }
?>
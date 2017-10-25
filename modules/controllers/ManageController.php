<?php
    namespace app\modules\controllers;
    use app\modules\controllers\BaseController;
    use app\modules\models\Admin;
    use Yii;
    use yii\data\Pagination;

   class ManageController extends BaseController{
       //修改密码
       public function actionChangepass(){
           $this->layout = 'main';
           $model = Admin::find()->where('adminUser = :user',[':user'=>Yii::$app->session['admin']['adminUser']])->one();
            if(Yii::$app->request->isPost){
                $post = Yii::$app->request->post();
                if($model->changepass($post)){
                    Yii::$app->session->setFlash('info','修改成功');
                }
            }
           return $this->render('changepass',['model'=>$model]);
       }
       //修改邮箱
       public function actionChangemail(){
           $this->layout = 'main';
           $adminUser = Yii::$app->session['admin']['adminUser'];
           $model = Admin::find()->where('adminUser = :user',[':user'=>$adminUser])->one();
           if(Yii::$app->request->isPost){
               $post = Yii::$app->request->post();
               if($model->changeMail($post)){
                   Yii::$app->session->setFlash('info','邮箱修改成功');
               }
           }
           return $this->render('changemail',['model'=>$model]);
       }
       //管理员列表
       public function actionManagers(){
           $this->layout = 'main';
           $model = Admin::find();
           $count = $model->count();
           $pageSize = Yii::$app->params['pageSize']['manage'];
           $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
           $managers = $model->offset($pager->offset)->limit($pager->limit)->all();
           return $this->render('managers',['managers'=>$managers,'pager'=>$pager]);
       }
       //添加管理员
       public function actionReg(){
           $this->layout = 'main';
           $model = new Admin();
           if(Yii::$app->request->isPost){
               $post = Yii::$app->request->post();
               if($model->reg($post)){
                   Yii::$app->session->setFlash('info','创建成功');
               }else{
                   Yii::$app->session->setFlash('info','创建失败');
               }
           }
           $model->adminPwd = '';
           $model->repass = '';
           return $this->render('reg',['model'=>$model]);
       }
       //删除管理员
       public function actionDel(){
           $adminId = (int)Yii::$app->request->get('adminId');
           if(empty($adminId) || $adminId==1){
               Yii::$app->session->setFlash('info','删除失败');
               $this->redirect(['manage/managers']);
               Yii::$app->end();
           }
           $model = new Admin();
           $adminUser = $model->findOne($adminId);
           if(!$adminUser['adminId']){
               Yii::$app->session->setFlash('info','要删除的用户不存在！');
               $this->redirect(['manage/managers']);
               Yii::$app->end();
           }
           if($adminUser['adminUser'] == Yii::$app->session['admin']['adminUser']){
               Yii::$app->session->setFlash('info','当前用户正在使用，不可删除！');
               $this->redirect(['manage/managers']);
               Yii::$app->end();
           }
           if($model->deleteAll('adminId = :id',[':id'=>$adminId])){
               Yii::$app->session->setFlash('info',$adminUser['adminUser']);
               $this->redirect(['manage/managers']);
               Yii::$app->end();
           }
       }
   }
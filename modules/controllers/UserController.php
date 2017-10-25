<?php
    namespace app\modules\controllers;
    use app\modules\controllers\BaseController;
    use app\models\User;
    use Yii;
    use app\models\Profile;
    use yii\data\pagination;
    class UserController extends BaseController{
        //添加用户
        public function actionReg(){
            $this->layout = 'main';
            $model = new User();
            if(Yii::$app->request->isPost){
                $post = Yii::$app->request->post();
                if($model->userReg($post)){
                    Yii::$app->session->setFlash('info','用户添加成功');
                }
            }
            return $this->render('reg',['model'=>$model]);
        }
        //用户列表
        public function actionUsers(){
            $this->layout = 'main';
            $model = User::find()->joinWith('profile');
            $count = $model->count();
            $pageSize = Yii::$app->params['pageSize']['user'];
            $pager = new pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
            $users = $model->offset($pager->offset)->limit($pager->limit)->all();
            return $this->render('users',['users'=>$users,'pager'=>$pager]);
        }
        //删除用户
        public function actionDel(){
            try{
                $userId = (int)Yii::$app->request->get('userId');
                if(empty($userId)){
                    throw new \Exception();
                }
                $trans = Yii::$app->db->beginTransaction();
                if($obj = Profile::find()->where('userId = :id',[':id'=>$userId])->one()){
                    $res = Profile::deleteAll('userId=:id',[':id'=>$userId]);
                    if(empty($res)){
                        throw new \Exception();
                    }
                }
                if(!User::deleteAll('userId=:id',[':id'=>$userId])){
                    throw new \Exception();
                }
                $trans->commit();
            }catch(\Exception $e){
                if(Yii::$app->db->getTransaction()){
                    $trans->rollBack();
                }
            }
                $this->redirect(['user/users']);
            }


    }
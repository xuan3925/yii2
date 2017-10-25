<?php
    namespace app\modules\controllers;
    use app\modules\controllers\BaseController;
    use app\models\Category;
    use Yii;
    use yii\db\Exception;

    class CategoryController extends BaseController{
        //分类列表
        public function actionList(){
            $this->layout = 'main';
            $model = new Category();
            $cates = $model->getList();
            return $this->render('cates',['cates'=>$cates]);
        }

        //修改分类
        public function actionMod(){
            $this->layout = 'main';
            $cateId = Yii::$app->request->get('cateId');
            $model = Category::find()->where('cateId=:id',[':id'=>$cateId])->one();
            if(Yii::$app->request->isPost){
                $post = Yii::$app->request->post();
                if($model->load($post) && $model->save()){
                    Yii::$app->session->setFlash('info','修改成功');
                }
            }
            $list = $model->getOptions();
            return $this->render('add',['model'=>$model,'list'=>$list]);
        }

        //删除分类
        public function actionDel(){
            try{
                $cateId = Yii::$app->request->get('cateId');
                if(empty($cateId)){
                    throw new \Exception('参数错误');
                }
                $data = Category::find()->where('parentId=:pid',[':pid'=>$cateId])->one();
                if($data){
                    throw new \Exception('该分类下有子类，不允许删除');
                }
                if(!Category::deleteAll('cateId=:id',[':id'=>$cateId])){
                    throw new \Exception('分类删除失败');
                }
            } catch (\Exception $e){
                Yii::$app->session->setFlash('info',$e->getMessage());
            }
            return $this->redirect(['category/list']);
        }
        //添加分类
        public function actionAdd(){
            $this->layout = 'main';
            $model = new Category();
            $list = $model->getOptions();
            if(Yii::$app->request->isPost){
                $post = Yii::$app->request->post();
                if($model->Add($post)){
                    Yii::$app->session->setFlash('info','添加成功');
                }
            }

            return $this->render('add',['model'=>$model,'list'=>$list]);
        }

    }

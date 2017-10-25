<?php
    namespace app\modules\controllers;
    use app\models\Category;
    use app\modules\controllers\BaseController;
    use app\models\Product;
    use Yii;
    use crazyfd\qiniu\Qiniu;
    use yii\db\Exception;


    class ProductController extends BaseController
    {
        /**
         * 图片添加操作
         * @return string
         */
        public function actionList()
        {
            $this->layout = 'main';
            $list = Product::find()->all();
            return $this->render('list', ['list' => $list]);
        }

        public function actionAdd()
        {
            $this->layout = 'main';
            $catgory = new Category();
            $model = new Product();
            $list = $catgory->getOptions();
            unset($list['0']);
            if (Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();
                $pics = $this->upload();
                if (!$pics) {
                    $model->addError('cover', '封面不能为空');
                    $model->addError('pics', '商品图片不能为空');
                } else {
                    $post['Product']['cover'] = $pics['cover'];
                    $post['Product']['pics'] = $pics['pics'];
                }
                if ($pics && $model->add($post)) {
                    Yii::$app->session->setFlash('info', '添加成功');
                } else {
                    Yii::$app->session->setFlash('info', '添加失败');
                }
            }
            return $this->render('add', ['model' => $model, 'list' => $list]);
        }

        public function upload()
        {
            if ($_FILES['Product']['error']['cover'] > 0) {
                return false;
            }
            $qiniu = new Qiniu(Product::AK, Product::SK, Product::DOMAIN, Product::BUCKET);
            $key = uniqid();
            $qiniu->uploadFile($_FILES['Product']['tmp_name']['cover'], $key);
            $cover = $qiniu->getLink($key);
            $pics = [];
            if ($_FILES['Product']['tmp_name']['pics']) {
                foreach ($_FILES['Product']['tmp_name']['pics'] as $k => $file) {
                    if ($_FILES['Product']['error']['pics'][$k] > 0) {
                        continue;
                    }
                    $key = uniqid();
                    $qiniu->uploadFile($file, $key);
                    $pics[$key] = $qiniu->getLink($key);
                }
            }
            return ['cover' => $cover, 'pics' => json_encode($pics)];
        }

        public function actionRemovepic()
        {
            $key = Yii::$app->request->get('key');
            $productId = Yii::$app->request->get('productId');
            $model = Product::find()->where('productId=:pid', ['pid' => $productId])->one();
            $qiniu = new Qiniu(Product::AK, Product::SK, Product::DOMAIN, Product::BUCKET);
            $qiniu->delete($key);
            $pics = json_decode($model->pics, true);
            unset($pics[$key]);
            Product::updateAll(['pics' => json_encode($pics)], 'productId=:pid', [':pid' => $productId]);
            return $this->redirect(['product/mod', 'productId' => $productId]);
        }

        public function actionMod()
        {
            $this->layout = 'main';
            $cate = new Category();
            $list = $cate->getOptions();
            unset($list[0]);
            $productId = Yii::$app->request->get('productId');
            $model = Product::find()->where('productId=:id', [':id' => $productId])->one();
            if (Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();
                $qiniu = new Qiniu(Product::AK, Product::SK, Product::DOMAIN, Product::BUCKET);
                $post['Product']['cover'] = $model->cover;
                if ($_FILES['Product']['error']['cover'] == 0) {
                    $key = uniqid();
                    $qiniu->uploadFile($_FILES['Product']['tmp_name']['cover'], $key);
                    $post['Product']['cover'] = $qiniu->getLink($key);
                    $qiniu->delete(basename($model->cover));
                }
                $pics = [];
                foreach ($_FILES['Product']['tmp_name']['pics'] as $k => $v) {
                    if ($_FILES['Product']['error']['pics'][$k] > 0) {
                        continue;
                    }
                    $key = uniqid();
                    $qiniu->uploadFile($v, $key);
                    $pics[$key] = $qiniu->getLink($key);
                }
                $post['Product']['pics'] = json_encode(array_merge(json_decode($model->pics, true), $pics));
                if ($model->load($post) && $model->save()) {
                    Yii::$app->session->setFlash('info', '修改成功');
                }
            }
            return $this->render('add', ['model' => $model, 'list' => $list]);
        }

        public function actionOff()
        {
            $productId = Yii::$app->request->get('productId');
            if (!empty($productId)) {
                $v = Product::updateAll(['isOn' => 0], 'productId = :pid', [':pid' => $productId]);
                if (!$v) {
                    Yii::$app->session->setFlash('info', '商品已下架');
                }
                return $this->redirect(['product/list']);
//                Yii::$app->end();
            }

        }

        public function actionOn()
        {
            $productId = Yii::$app->request->get('productId');
            if (!empty($productId)) {
                $v = Product::updateAll(['isOn' => 1], 'productId=:pid', [':pid' => $productId]);
                if (!$v) {
                    Yii::$app->session->setFlash('info', '商品已上架');
                }
                return $this->redirect(['product/list']);

            }

        }

        public function actionDel()
        {
            $productId = Yii::$app->request->get('productId');
            if (!empty($productId)) {
                $model = Product::find()->where('ProductId = :pid', [':pid' => $productId])->one();
                $key = basename($model->cover);
                $qiniu = new Qiniu(Product::AK, Product::SK, Product::DOMAIN, Product::BUCKET);
                $qiniu->delete($key);
                $pics = json_decode($model->pics, true);
                foreach ($pics as $k => $v) {
                    $qiniu->delete($k);
                }
                $stats = Product::deleteAll('ProductId = :pid', [':pid' => $productId]);
                if ($stats) {
                    Yii::$app->session->setFlash('info', '商品删除成功');
                } else {
                    Yii::$app->session->setFlash('info', '商品删除失败');
                }
                return $this->redirect(['product/list']);
            }

        }
    }
?>
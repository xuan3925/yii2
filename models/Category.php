<?php
    namespace app\models;
    use yii\db\ActiveRecord;
    use yii\helpers\ArrayHelper;
    use Yii;


    class Category extends ActiveRecord{
        public static function tableName(){
           return "{{%category}}";
        }
        public function attributeLabels(){
               return [
                   'parentId'=>'上级分类',
                   'title'=>'分类名称'
               ];
           }
        public function rules(){
            return[
                ['parentId','required','message'=>'上级分类不能为空'],
                ['title','required','message'=>'标题名称不能为空'],
                ['createTime','safe'],
                ['title','unique','message'=>'分类已存在，无法重复添加']
               ];
        }

        //添加分类数据
        public function Add($data){
            $data['Category']['createTime'] = time();
            if($this->load($data) && $this->save()){
                return true;
            }
            return false;
        }

        //获取数据
        public function getData(){
            $cates = self::find()->all();
            $cates = ArrayHelper::toArray($cates);
            return $cates;
           }
        //递归调用
        public function getTree($cates,$pid = 0){
            $tree = [];
            foreach($cates as $cate){
                if($cate['parentId']==$pid){
                    $tree[] = $cate;
                    $tree = array_merge($tree,$this->getTree($cates,$cate['cateId']));
                }
            }
            return $tree;
        }
        //设置前缀
        public function setPrefix($data,$p='|——'){
            $tree = [];
            $num = 1;
            $prefix = [0=>1];
            while($val = current($data)){
                $key = key($data);
                if($key > 0){
                    if($data[$key-1]['parentId'] != $val['parentId']){
                        $num++;
                    }
                }
                if(array_key_exists($val['parentId'],$prefix)){
                    $num = $prefix[$val['parentId']];
                }
                $val['title'] = str_repeat($p,$num).$val['title'];
                $prefix[$val['parentId']] = $num;
                $tree[] = $val;
                next($data);
            }
            return $tree;
        }
        public function getOptions(){
            $data = $this->getData();
            $tree = $this->getTree($data);
            $tree = $this->setPrefix($tree);
            $options = ['添加顶级分类'];
            foreach($tree as $cate){
                $options[$cate['cateId']] = $cate['title'];
            }
            return$options;
        }
        //查询分类
        public function getList(){
            $data = $this->getData();
            $tree = $this->getTree($data);
            $tree = $this->setPrefix($tree);
            return $tree;
        }

        //分类菜单
        public function getMenu(){
            $top = self::find()->where('parentId = :pid',[':pid'=>0])->asArray()->all();
            $data = [];
            foreach($top as $key=>$val){
                $parent['children'] = self::find()->where('parentId = :pid',[':pid'=>$val['cateId']])->asArray()->all();
                $data[$key] = $parent;
            }
            $data[]['top'] = $top;
            return $data;
        }
   }
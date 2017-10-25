<?php
    namespace app\models;
    use yii\db\ActiveRecord;

    class Product extends ActiveRecord{
        //七牛云
        const AK = 'gmrZovsGyiPFOiOOKec5kVNqIpvu1Z-K-Pox3gGx';
        const SK = 'IdQ-G2asoDMSiT9cKYfjoEFAHZgWrjS3ky6gzmEo';
        const DOMAIN = 'otmjt05pi.bkt.clouddn.com';
        const BUCKET = 'xuanimg';

        public static function tableName(){
            return '{{%product}}';
        }
        public function rules(){
            return [
                ['cateId','required','message'=>'分类不能为空'],
                ['title','required','message'=>'商品名称不能为空'],
                ['descr','required','message'=>'商品描述不能为空'],
                ['price','required','message'=>'商品价格不能为空'],
                [['price','saleprice'],'number','min'=>0.01,'message'=>'价格必须是数字'],
                ['num','number','min'=>0,'message'=>'库存必须是数字'],
                [['isHot','isSale','isOn','isTui'],'safe'],
                [['cover','pics'],'required']
            ];
        }

        public function attributeLabels()
        {
           return [
               'cateId' => '分类名称',
               'title' => '商品名称',
               'descr' => '商品描述',
               'price' => '商品价格',
               'isHot' => '是否热卖',
               'isSale' => '是否促销',
               'saleprice' => '促销价格',
               'isOn' => '是否上架',
               'isTui' => '是否推荐',
               'num' => '库存',
               'cover'  => '封面图片',
               'pics' => '商品图片'
           ];
        }

        public function add($data){
            if($this->load($data) && $this->save()){
                return true;
            }
            return false;
        }

    }
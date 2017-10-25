<?php
    namespace app\models;
    use yii\db\ActiveRecord;
    use Yii;
    class User extends ActiveRecord{
        public $rePass;
        public $rememberMe = true;
        //返回数据表
        public static function tableName(){
            return "{{%user}}";
        }
        public function rules(){
           return [
               ['userName','required','message'=>'用户名不能为空','on'=>['userReg','login']],
               ['userName','unique','message'=>'用户名已被注册','on'=>['userReg']],
               ['userPwd','required','message'=>'用户密码不能为空','on'=>['userReg','login']],
               ['userMail','required','message'=>'用户邮箱不能为空','on'=>['userReg']],
               ['userMail','unique','message'=>'邮箱已被注册','on'=>['userReg']],
               ['rePass','required','message'=>'确认密码不能为空','on'=>['userReg']],
               ['userMail','email','message'=>'邮箱格式不正确','on'=>['userReg']],
               ['rePass','compare','compareAttribute'=>'userPwd','message'=>'两次密码输入不一致','on'=>['userReg']],
               ['userPwd','validatePass','on'=>['login']]
           ];
        }
        //多表查询
        public function getProfile(){
            return $this->hasOne(Profile::className(),['userId' => 'userId']);
        }
        //验证密码
        public function validatePass(){
            if(!$this->hasErrors()){
                $data = self::find()->where(['userName'=>$this->userName,'userPwd'=>md5($this->userPwd)])->one();
                if(is_null($data)){
                    $this->addError('userPwd','用户名或密码错误');
                }
            }
        }
        //添加用户
        public function userReg($data){
            $this->scenario = 'userReg';
            if($this->load($data) && $this->validate()){
                $this->userPwd = md5($this->userPwd);
                if($this->save(false)){
                    return true;
                }
            }
            return false;
        }
        //用户登录
        public function login($data){
            $this->scenario = 'login';
            if($this->load($data) && $this->validate()){
                $lifeTime = $this->rememberMe ? 24*3600:0;
                $session = Yii::$app->session;
                session_set_cookie_params($lifeTime);
                $session['userName'] = $this->userName;
                $session['isLogin'] = 1;
                return (bool)$session['isLogin'];
            }
            return false;
        }
    }


<?php
    namespace app\modules\models;
    use yii\db\ActiveRecord;
    use Yii;
       class Admin extends ActiveRecord{
            //前台记住我选项
            public $rememberMe = true;
            public $repass;
            //返回数据表名
            public static function tableName(){
                return "{{%admin}}";
            }
            //指定form表单字段的中文名称
            public function attributeLabels(){
                return [
                    'adminUser'=>'管理员账号',
                    'adminPwd'=>'管理员密码',
                    'repass'=>'确认密码',
                    'adminMail'=>'管理员邮箱'
                ];
            }
            //validate验证规则
            public function rules(){
                return [
                    ['adminUser','required','message' => '管理员账号不能为空', 'on' => ['login','changepass','seekpass','adminAdd']],
                    ['adminUser','unique','message'=> '管理员账号已被注册','on' => ['adminAdd']],
                    ['adminPwd','required','message' => '管理员密码不能为空', 'on' => ['login','changepass','adminAdd','changemail']],
                    ['adminMail','required','message' => '管理员邮箱不能为空','on' => ['seekpass','adminAdd','changemail']],
                    ['adminMail','email','message'=> '邮箱格式不正确','on' => ['seekpass','adminAdd','changemail']],
                    ['adminMail','unique','message'=> '邮箱已被注册','on' => ['adminAdd','changemail']],
                    ['rememberMe','boolean','on' => ['login']],
                    ['adminPwd','validatePass','on' => ['login','changemail']],
                    ['adminMail','validateMail','on' =>['seekpass'] ],
                    ['repass','required','message'=> '确认密码不能为空','on'=>['changepass','adminAdd']],
                    ['repass','compare','compareAttribute'=>'adminPwd','message'=>'两次密码输出不一致','on'=>['changepass','adminAdd']]
                ];
            }
           //验证密码
           public function validatePass(){
               if(!$this->hasErrors()){
                    $data = self::find()->where('adminUser=:user and adminPwd=:pass ',[':user'=>$this->adminUser,
                        'pass'=>md5($this->adminPwd)])->one();
                   if(is_null($data)){
                        $this->addError('adminPwd','用户名或密码错误');
                   }
               }
           }
           //验证邮箱
           public function validateMail(){
               if(!$this->hasErrors()){
                   $data = self::find()->where('adminUser=:user and adminMail=:mail',[':user'=>$this->adminUser,
                       'mail'=>$this->adminMail])->one();
                   if(is_null($data)){
                        $this->addError('adminMail','管理员邮箱不匹配');
                   }
               }

           }

           //登录方法
            public function login($data){
                $this->scenario = "login";
                if($this->load($data) && $this->validate()){
                    //保存登录session
                    $lifetime = $this->rememberMe ? 24*3600:0;
                    $session = Yii::$app->session;
                    session_set_cookie_params($lifetime);
                    $session['admin'] = [
                        'adminUser' => $this->adminUser,
                        'isLogin' => 1
                    ];
                    $this->updateAll(['loginTime'=>time(),'loginIp'=>ip2long(Yii::$app->request->userIP)],
                        'adminUser = :user',[':user'=>$this->adminUser]);
                    return (bool)$session['admin']['isLogin'];
                }
                return false;
            }
           //创建token值
           public function createToken($adminUser,$time){
               return md5(md5($adminUser).base64_encode(Yii::$app->request->userIp).md5($time));
           }
            //找回密码
           public function seekpass($data){
                $this->scenario = 'seekpass';
                if($this->load($data) && $this->validate()){
                    $time = time();
                    $token = $this->createToken($data['Admin']['adminUser'],$time);
                    $mailer = Yii::$app->mailer->compose('seekpass',['adminUser'=>$data['Admin']['adminUser'],'time'=>$time,'token'=>$token]);
                    $mailer->setFrom('xuan3925@163.com');
                    $mailer->setTo($data['Admin']['adminMail']);
                    $mailer->setSubject('幕课商城-找回密码');
                    if($mailer->send()){
                        return true;
                    }
                }
                return false;
            }
           //修改密码
           public function changepass($data){
                $this->scenario = 'changepass';
                if($this->load($data) && $this->validate()){
                    return (bool)$this->updateAll(['adminPwd' => md5($this->adminPwd)],'adminUser = :user',[':user'=>$this->adminUser]);
               }
               return false;
           }
           //修改邮箱
           public function changeMail($data){
               $this->scenario = 'changemail';
               if($this->load($data) && $this->validate()){
                    return (bool)$this->updateAll(['adminMail'=>$this->adminMail],'adminUser = :user',[':user'=>$this->adminUser]);
               }
               return false;
           }
           //添加管理员
           public function reg($data){
               $this->scenario = 'adminAdd';
               if($this->load($data) && $this->validate()){
                   $this->adminPwd = md5($this->adminPwd);
                   if($this->save(false)){
                        return true;
                   }
               }
               return false;
           }
        }
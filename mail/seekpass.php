<p>尊敬的<?php echo $adminUser?>，您好！</p>

<p>您通过邮箱方式为主帐号<?php echo $adminUser?>找回密码，请在10分钟内更换您的密码，如果不做任何操作，系统将保留原密码。点击以下链接立即找回密码：（如果不能点击，请把下面网页地址复制到浏览器地址栏中打开！）</p>
<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['admin/public/mailchangepass','timestamp'=>$time,
    'adminUser'=>$adminUser,'token'=>$token]);?>
<p><a href="<?php echo $url?>"><?php echo $url?></a></p>
<p>该邮件为系统自动发送，请勿回复！</p>
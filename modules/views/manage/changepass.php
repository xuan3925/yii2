<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
?>
<link rel="stylesheet" href="assets/admin/css/compiled/new-user.css" type="text/css" media="screen" />
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>修改密码</h3></div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?php $form = ActiveForm::begin([
                            'options'=>['class'=>'new_user_form inline-input'],
                            'fieldConfig'=> ['template'=>'{label}{input}{error}']
                        ]);?>
<!--                        <form id="w0" class="new_user_form inline-input" action="/index.php?r=admin%2Fmanage%2Fchangepass" method="post">-->
                            <div class="form-group field-admin-adminuser">
                                <div class="span12 field-box">
                                    <?php echo $form->field($model,'adminUser')->textInput(['class'=>'span9','disabled'=>true]);?>
<!--                                    <input type="text" id="admin-adminuser" class="span9" name="Admin[adminuser]" value="admin" disabled></div>-->
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-admin-adminpass">
                                <div class="span12 field-box">
                                    <?php echo $form->field($model,'adminPwd')->passwordInput(['class'=>'span9','value'=>'']);?>
<!--                                    <label class="control-label" for="admin-adminpass">管理员密码</label>-->
<!--                                    <input type="password" id="admin-adminpass" class="span9" name="Admin[adminpass]" value=""></div>-->
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-admin-repass">
                                <div class="span12 field-box">
                                    <?php echo $form->field($model,'repass')->passwordInput(['class'=>'span9','value'=>''])?>
<!--                                    <label class="control-label" for="admin-repass">确认密码</label>-->
<!--                                    <input type="password" id="admin-repass" class="span9" name="Admin[repass]" value=""></div>-->
                                <p class="help-block help-block-error"></p>
                                    <?php
                                    if(Yii::$app->session->hasFlash('info')){
                                        echo Yii::$app->session->getFlash('info');
                                    }?>
                            </div>
                            <div class="span11 field-box actions">
                                <?php echo Html::submitButton('修改',['class'=>'btn-glow primary'])?>
<!--                                <button type="submit" class="btn-glow primary">修改</button>-->
                                <span>或者</span>
                                <?php echo Html::resetButton('重置',['class'=>'reset'])?>
<!--                                <button type="reset" class="reset">取消</button></div>-->
                        <?php $form = ActiveForm::end(); ?>
                    </div>
                </div>
                <!-- side right column -->

                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧填写管理员相关信息，包括管理员账号，电子邮箱，以及密码</div>
                    <h6>重要提示：</h6>
                    <p>管理员可以管理后台功能模块</p>
                    <p>请谨慎修改</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
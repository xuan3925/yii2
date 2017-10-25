<?php
    use yii\bootstrap\ActiveForm;
?>
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加新用户</h3></div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?php
                            if(Yii::$app->session->hasFlash('info')){
                                echo Yii::$app->session->getFlash('info');
                            }
                        $form = ActiveForm::begin([
                            'options'=>['class'=>'new_user_form inline-input'],
                            'fieldConfig'=>[
                                'template'=>'{input}{error}'
                            ]
                        ]);?>
<!--                        <form id="w0" class="new_user_form inline-input" action="/index.php?r=admin%2Fuser%2Freg" method="post">-->
<!--                            <input type="hidden" name="_csrf" value="TDdVOGxYYWg.eTJeFGpMAn0PNGgULhQ9PQc0dDk7KR4ocARBXiwiGg==">-->
                            <div class="form-group field-user-username">
                                <div class="span12 field-box">
                                    <label class="control-label" for="user-username">用户名</label>
<!--                                    <input type="text" id="user-username" class="span9" name="User[username]">-->
                                    <?php echo $form->field($model,'userName')->textInput(['class'=>'span9'])?>
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-user-useremail">
                                <div class="span12 field-box">
                                    <label class="control-label" for="user-useremail">电子邮箱</label>
                                    <?php echo $form->field($model,'userMail')->textInput(['class'=>'span9'])?>
<!--                                    <input type="text" id="user-useremail" class="span9" name="User[useremail]">-->
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-user-userpass">
                                <div class="span12 field-box">
                                    <label class="control-label" for="user-userpass">用户密码</label>
                                    <?php echo $form->field($model,'userPwd')->passwordInput(['class'=>'span9','value'=>''])?>
<!--                                    <input type="password" id="user-userpass" class="span9" name="User[userpass]" value="">-->
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group field-user-repass">
                                <div class="span12 field-box">
                                    <label class="control-label" for="user-repass">确认密码</label>
                                    <?php echo $form->field($model,'rePass')->passwordInput(['class'=>'span9','value'=>''])?>
<!--                                    <input type="password" id="user-repass" class="span9" name="User[repass]" value="">-->
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="span11 field-box actions">
                                <?php echo yii\helpers\Html::submitButton('添加',['class'=>'btn-glow primary'])?>
<!--                                <button type="submit" class="btn-glow primary">添加</button>-->
                                <span>OR</span>
                                <?php echo yii\helpers\Html::resetButton('取消',['class'=>'reset'])?>
<!--                                <button type="reset" class="reset">取消</button>-->
                            </div>
<!--                        </form>-->
                        <?php ActiveForm::end();?>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧表单当中填入要添加的用户信息,包括用户名,密码,电子邮箱</div>
                    <h6>商城用户说明</h6>
                    <p>可以在前台进行登录并且进行购物</p>
                    <p>前台也可以注册用户</p>
                </div>
            </div>
        </div>
    </div>
</div>
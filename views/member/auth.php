<?php
    use yii\bootstrap\ActiveForm;
?>
<!-- ============================================================= HEADER : END ============================================================= -->		<!-- ========================================= MAIN ========================================= -->
    <main id="authentication" class="inner-bottom-md">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <section class="section sign-in inner-right-xs">
                        <h2 class="bordered">登录</h2>
                        <p>欢迎您回来，请您输入您的账户名密码</p>

                        <div class="social-auth-buttons">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn-block btn-lg btn btn-facebook"><i class="fa fa-qq"></i> 使用QQ账号登录</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn-block btn-lg btn btn-twitter"><i class="fa fa-weibo"></i> 使用新浪微博账号登录</button>
                                </div>
                            </div>
                        </div>
                            <?php $form = ActiveForm::begin([
                                'fieldConfig'=>[
                                    'template'=>'{input}{error}'],
                                    'options'=>[
                                        'class'=>'login-form cf-style-1',
                                        'role'=>'form'
                                    ]
                            ])?>
<!--                        <form role="form" class="login-form cf-style-1">-->
                            <div class="field-row">
                                <label>用户名</label>
<!--                                <input type="text" class="le-input">-->
                                <?php echo $form->field($model,'userName')->textInput(['class'=>'le-input'])?>
                            </div><!-- /.field-row -->

                            <div class="field-row">
                                <label>密码</label>
                                <?php echo $form->field($model,'userPwd')->passwordInput(['class'=>'le-input'])?>
<!--                                <input type="text" class="le-input">-->
                            </div><!-- /.field-row -->

                            <div class="field-row clearfix">

<!--                                    <input type="checkbox" class="le-checbox auto-width inline">-->
                                    <?php echo $form->field($model,'rememberMe')->checkbox([
                                        'template'=>'<span class="pull-left"><label class="content-color">{input}<span class="bold">记住我</span></label></span>',
                                        'class'=>'le-checbox auto-width inline'])?>
                        	<span class="pull-right">
                        		<a href="#" class="content-color bold">忘记密码 ?</a>
                        	</span>
                            </div>

                            <div class="buttons-holder">
<!--                                <butte="submit" class="le-buon typtton huge">安全登录</button>-->
                                <?php echo yii\helpers\Html::submitButton('安全登录',['class'=>'le-buon typtton huge'])?>
                            </div><!-- /.buttons-holder -->
<!--                        </form><!-- /.cf-style-1 -->
                            <?php ActiveForm::end();?>
                    </section><!-- /.sign-in -->
                </div><!-- /.col -->

                <div class="col-md-6">
                    <section class="section register inner-left-xs">
                        <h2 class="bordered">新建账户</h2>
                        <p>创建一个属于你自己的账户</p>

                        <form role="form" class="register-form cf-style-1">
                            <div class="field-row">
                                <label>电子邮箱</label>
                                <input type="text" class="le-input">
                            </div><!-- /.field-row -->

                            <div class="buttons-holder">
                                <button type="submit" class="le-button huge">注册</button>
                            </div><!-- /.buttons-holder -->
                        </form>

                        <h2 class="semi-bold">加入我们您将会享受到前所未有的购物体验 :</h2>

                        <ul class="list-unstyled list-benefits">
                            <li><i class="fa fa-check primary-color"></i> 快捷的购物体验</li>
                            <li><i class="fa fa-check primary-color"></i> 便捷的下单方式</li>
                            <li><i class="fa fa-check primary-color"></i> 更加低廉的商品</li>
                        </ul>

                    </section><!-- /.register -->

                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container -->
    </main><!-- /.authentication -->
    <!-- ========================================= MAIN : END ========================================= -->		<!-- ============================================================= FOOTER ============================================================= -->

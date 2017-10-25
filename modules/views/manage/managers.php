<?php
    use yii\helpers\Url;
?>
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>管理员列表</h3>
                <div class="span10 pull-right">
                    <a href="<?php echo Url::to(['manage/reg'])?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新管理员</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span2">管理员ID</th>
                        <th class="span2">
                            <span class="line"></span>管理员账号</th>
                        <th class="span2">
                            <span class="line"></span>管理员邮箱</th>
                        <th class="span3">
                            <span class="line"></span>最后登录时间</th>
                        <th class="span3">
                            <span class="line"></span>最后登录IP</th>
                        <th class="span2">
                            <span class="line"></span>添加时间</th>
                        <th class="span2">
                            <span class="line"></span>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->

                    <?php foreach($managers as $v):?>
                    <tr>
                        <td><?php echo $v->adminId?></td>
                        <td><?php echo $v->adminUser?></td>
                        <td><?php echo $v->adminMail?></td>
                        <td><?php echo date('Y-m-d H:i:s',$v->loginTime)?></td>
                        <td><?php echo long2ip($v->loginIp)?></td>
                        <td><?php echo $v->createTime?></td>
                        <td class="align-right">
                            <a href="<?php echo Url::to(['manage/del','adminId'=>$v->adminId])?>">删除</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <?php if(Yii::$app->session->hasFlash('info')){
                echo Yii::$app->session->getFlash('info');
            }?>
            <div class="pagination pull-right">
                <?php echo \yii\widgets\LinkPager::widget([
                    'pagination'=>$pager,
//                    'prevPageLabel'=>'<','nextPageLabel'=>'>'
                ])?>
            </div>
            <!-- end users table --></div>
    </div>
</div>
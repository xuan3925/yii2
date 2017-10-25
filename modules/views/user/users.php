<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>会员列表</h3>
                <div class="span10 pull-right">
                    <a href="<?php echo yii\helpers\Url::to(['user/reg'])?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新用户</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span3 sortable">
                            <span class="line"></span>用户名</th>
                        <th class="span3 sortable">
                            <span class="line"></span>真实姓名</th>
                        <th class="span2 sortable">
                            <span class="line"></span>昵称</th>
                        <th class="span3 sortable">
                            <span class="line"></span>性别</th>
                        <th class="span3 sortable">
                            <span class="line"></span>年龄</th>
                        <th class="span3 sortable">
                            <span class="line"></span>生日</th>
                        <th class="span3 sortable align-right">
                            <span class="line"></span>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php foreach($users as $v):?>
                    <tr class="first">
                        <td>
                            <img src="assets/admin/img/contact-img.png" class="img-circle avatar hidden-phone" />
                            <a href="#" class="name"><?php echo $v->userName?></a>
                            <span class="subtext"></span>
                        </td>
                        <td><?php echo isset($v->profile->trueName)?$v->profile->trueName:'未填写' ?></td>
                        <td><?php echo isset($v->profile->nickName)?$v->profile->nickName:'未填写'?></td>
                        <td><?php echo isset($v->profile->sex)?$v->profile->sex:'未填写'?></td>
                        <td><?php echo isset($v->profile->tage)?$v->profile->age:'未填写'?></td>
                        <td><?php echo isset($v->profile->birthday)?$v->profile->birthday:'未填写'?></td>
                        <td class="align-right">
                            <a href="<?php echo yii\helpers\Url::to(['user/del','userId'=>$v->userId])?>">删除</a></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right">
                <?php echo yii\widgets\linkPager::widget([
                    'pagination'=>$pager,
                ])?>
            </div>
            <!-- end users table --></div>
    </div>
</div>
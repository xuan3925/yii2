<?php
    use yii\helpers\Url;
    ?>
<div class="content">
    <div class="container-fluid">
        <script type="text/javascript">
            var info =  "<?php echo Yii::$app->session->getFlash('info');?>";
            if(info){
                alert(info);
            }
        </script>
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>商品列表</h3>
                <div class="span10 pull-right">
                    <a href="<?php echo Url::to(['product/add'])?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新商品</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span6 sortable">
                            <span class="line"></span>商品名称</th>
                        <th class="span2 sortable">
                            <span class="line"></span>商品库存</th>
                        <th class="span2 sortable">
                            <span class="line"></span>商品单价</th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否热卖</th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否促销</th>
                        <th class="span2 sortable">
                            <span class="line"></span>促销价</th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否上架</th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否推荐</th>
                        <th class="span3 sortable align-right">
                            <span class="line"></span>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php
                        foreach($list as $v){
                    ?>
                    <tr class="first">
                        <td>
                            <img src="http://<?php echo $v['cover']?>-coveSmall" height='120' width='80' />
                            <a href="#" class="name"><?php echo $v['title']?></a></td>
                        <td><?php echo $v['num']?></td>
                        <td><?php echo $v['price']?></td>
                        <td><?php echo $v['isHot']?'热卖':'不热卖' ?></td>
                        <td><?php echo $v['isSale']?'促销':'不促销' ?></td>
                        <td><?php echo $v['saleprice']?></td>
                        <td><?php echo $v['isOn']?'上架':'下架' ?></td>
                        <td><?php echo $v['isTui']?'推荐':'不推荐' ?></td>
                        <td class="align-right">
                            <a href="<?php echo Url::to(['product/mod','productId'=>$v['productId']])?>">编辑</a>
                            <a href="<?php echo Url::to(['product/on','productId'=>$v['productId']])?>">上架</a>
                            <a href="<?php echo Url::to(['product/off','productId'=>$v['productId']])?>">下架</a>
                            <a href="<?php echo Url::to(['product/del','productId'=>$v['productId']])?>">删除</a></td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right"></div>
            <!-- end users table --></div>
    </div>
</div>
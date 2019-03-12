
    <link rel="stylesheet" href="<?php echo e(env('STATIC_URL')); ?>/css/cartlist.css">
    <link rel="stylesheet" href="<?php echo e(env('STATIC_URL')); ?>/layui/css/layui.css">
    <link rel="stylesheet" href="<?php echo e(env('STATIC_URL')); ?>/css/address.css">
    <link rel="stylesheet" href="<?php echo e(env('STATIC_URL')); ?>/css/sm.css">

<?php $__env->startSection('content'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">结算支付</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
</div>
<div>
    <div class="g-pay-lst">
        <ul>
            <?php

                $count=0.00
            ?>
            <?php $__currentLoopData = $cart_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <input type="hidden" cart_id="<?php echo e($v['cart_id']); ?>" class="cart_id">

                <a href="">
                        <span>
                            <img src="<?php echo e(env('PUBLIC_URL')); ?><?php echo e($v['goods_img']); ?>" border="0" alt="">
                        </span>
                    <dl>
                        <dt>
                            <?php echo e($v['sku_name']); ?>

                        </dt>
                        <?php
                            $price=$v['add_price'] * $v['buy_number'];
                        ?>
                        <dd><em class="price">1</em>人次/<em>￥ <?php echo e($price); ?></em></dd>
                    </dl>
                </a>
                <?php
                $count+=$v['add_price'] * $v['buy_number'];
                ?>
            </li>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div id="divMore">

        </div>
        <p class="gray9">总需支付金额：<em class="orange"><i>￥</i>246</em></p>
    </div>

    <div class="addr-wrapp">
        <div class="addr-list">
            <ul>
                <li>
                    <span>地址：</span>
                    <p id="txt">北京市昌平区沙河镇小汤山别墅区12号</p>
                </li>
            </ul>
        </div>
    </div>
    <div class="other_pay marginB">


            <a href="javascript:;" class="wzf checked">
            <b class="z-set"></b>第三方支付<em class="orange fr"><span class="colorbbb">需要支付&nbsp;</span><b>￥</b>1.00</em>
        </a>
        <div class="net-pay">
            <a href="javascript:;" class="checked" id="jdPay">
                <span class="zfb"></span>
                <b class="z-set"></b>
            </a>
            <a href="javascript:;" id="jdPay">
                <span class="kq"></span>
                <b class="z-set"></b>
            </a>
        </div>
        <div class="paylip">我们提倡理性消费</div>
    </div>
    <div class="g-Total-bt">
        <dd><a id="btnPay" href="javascript:;" class="orangeBtn fr w_account">立即支付</a></dd>
    </div>

</div>
<?php $__env->stopSection(); ?>
    <script src="<?php echo e(env('STATIC_URL')); ?>/js/jquery-1.11.2.min.js"></script>

<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.w_account').click(function () {
            var txt=$('#txt').text();
            var cart_id="<?php echo request()->get('cart_id'); ?>";

            $.ajax({
                url:"<?php echo e(url('redis')); ?>",
                data:'cart_id='+cart_id+'&txt='+txt,
                type:'post',
                dataType:'json',
                success:function (json_info) {
                    if(json_info.status==1000){
                        var url="<?php echo e(url('/loo?order_id=__ORDER_ID__')); ?>";
                        url=url.replace('__ORDER_ID__',json_info.data.order_id);
                        window.location.href =url;
                    }else{
                        alert(json_info.data);
                    }
                }

            });

        })

    });






</script>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
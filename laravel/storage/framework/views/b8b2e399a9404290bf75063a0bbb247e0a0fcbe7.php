
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta charset="utf-8">
    <title>所有分类</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo e(env('CATE_URL')); ?>/css/swiper-3.2.5.min.css" />
    <link rel="stylesheet" href="<?php echo e(env('CATE_URL')); ?>/css/ectouch.css" />
    <link rel="stylesheet" href="<?php echo e(env('CATE_URL')); ?>/css/search.css" />
</head>
<body style="max-width:640px;font-size: 14px;">
<?php $__env->startSection('content'); ?>
<div id="loading"><img src="<?php echo e(env('CATE_URL')); ?>/images/loading.gif" /></div>
<div class="con">
    <div class="category-top">
        <header>
            <section class="search">
                <div class="text-all dis-box j-text-all">
                    <div class="box-flex input-text"> <a class="a-search-input j-search-input" href="javascript:void(0)"></a>
                        <input type="text" placeholder="商品搜索" />
                        <i class="iconfont icon-guanbi is-null j-is-null"></i> </div>
                </div>
            </section>
        </header>
    </div>

    <aside>
        <div class="menu-left scrollbar-none" id="sidebar">
            <ul>
                <li  class="active">全部商品</li>
                <?php $__currentLoopData = $cateInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                <li  class="active"><?php echo e($v['cate_name']); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </aside>
    <section class="menu-right padding-all j-content">
        <h5>全部商品</h5>
        <ul>
            <li class="w-3"><a href="#"></a> <img src="<?php echo e(env('CATE_URL')); ?>/images/tp.png" /><span>全部商品</span></li>
        </ul>
    </section>
    <?php $__currentLoopData = $cateInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $son): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <section class="menu-right padding-all j-content" style="display:none">
        <?php $__currentLoopData = $son['son']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h5><?php echo e($vv['cate_name']); ?></h5>
        <ul>
            <?php $__currentLoopData = $vv['son']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vvv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="w-3">
                <a href="<?php echo e(url('all_show')); ?>?cate_id= <?php echo e($vvv['cate_id']); ?>"></a>
                <img src="<?php echo e(env('CATE_URL')); ?>/images/tp.png" /><span><?php echo e($vvv['cate_name']); ?>

                </span>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="search-div j-search-div ts-3">
    <section class="search">
        <form action="9" method="post">
            <div class="text-all dis-box j-text-all">
                <div class="box-flex input-texts">
                    <input class="j-input-text" type="text" id="username" name="keywords" placeholder="请输入搜索关键词！" />
                    <i class="iconfont icon-guanbi is-null j-is-null"></i> </div>
                <button type="button" class="btn-submit" id="btn">搜索</button>
            </div>
        </form>
    </section>
    <section class="search-con">
        <div class="swiper-scroll history-search">
            <table>

            </table>
         
            <div class="swiper-scrollbar"></div>
        </div>
    </section>
    <footer class="close-search j-close-search"> 点击关闭 </footer>
</div>

<script type="text/javascript">
    //设置cookie
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }
    function clearHistroy(){
        setCookie('ECS[keywords]', '', -1);
        document.getElementById("search_histroy").style.visibility = "hidden";
    }
</script>
<script type="text/javascript" src="<?php echo e(env('CATE_URL')); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('CATE_URL')); ?>/js/swiper-3.2.5.min.js"></script>
<script type="text/javascript" src="<?php echo e(env('CATE_URL')); ?>/js/ectouch.js"></script>
<script type="text/javascript" src="<?php echo e(env('CATE_URL')); ?>/js/jquery.json.js"></script>
<script type="text/javascript" src="<?php echo e(env('CATE_URL')); ?>/js/common.js"></script>
<script type="text/javascript">
    $(function($){
        $('#sidebar ul li').click(function(){
            $(this).addClass('active').siblings('li').removeClass('active');
            var index = $(this).index();
            $('.j-content').eq(index).show().siblings('.j-content').hide();
        })

        $(function(){
            $('#btn').click(function(){
                var username=$('#username').val();
                var str='';
                var y;
                $.ajax({
                    url:"<?php echo e(url('searcha')); ?>",
                    data:'username='+username,
                    dataType:'json',
                    type:'post',
                    success:function(json_info){
                        if(json_info.status==100){
                            alert(json_info.data)
                        }else{
                            var a=json_info.res;

                            for(var i=0;i<a.length;i++){
                                str+='    <li id="23468">\n' +
                                    '        <span class="gList_l fl">\n' +
                                    '            <img class="lazy" src="<?php echo e(env('PUBLIC_URL')); ?>/'+a[i]['_source']['brand_logo']+'" style="height:120px">\n' +
                                    '        </span>\n' +
                                    '        <div class="gList_r">\n' +
                                    '            <em class="gray9">'+a[i]['_source']['brand_name']+'</em>\n' +
                                    '            <em class="gray9">'+a[i]['highlight']['brand_describe']+'</em>\n' +
                                    '            <div class="gRate">\n' +
                                    '                <div class="Progress-bar">\n' +
                                    '                    <p class="u-progress">\n' +
                                    '                        <span style="width: 91.91286930395593%;" class="pgbar">\n' +
                                    '                            <span class="pging"></span>\n' +
                                    '                        </span>\n' +
                                    '                    </p>\n' +
                                    '                    <ul class="Pro-bar-li">\n' +
                                    '                        <li class="P-bar01"><em>7342</em>已参与</li>\n' +
                                    '                        <li class="P-bar02"><em>7988</em>总需人次</li>\n' +
                                    '                        <li class="P-bar03"><em>646</em>剩余</li>\n' +
                                    '                    </ul>\n' +
                                    '                </div>\n' +
                                    '                <a codeid="12785750" class="" canbuy="646"><s></s></a>\n' +
                                    '            </div>\n' +
                                    '        </div>\n' +
                                    '    </li>';
                            }
                            $('table').html(str);
                        }

                    }
                })
            });
        })

    })
</script>
</body>
</html>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
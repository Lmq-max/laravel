@extends('layouts.main')
@section('title',$title)
@section('content')
    <link rel="stylesheet" href="{{env('STATIC_URL')}}/css/swiper.min.css">
    <link rel="stylesheet" href="{{env('STATIC_URL')}}/css/css/bootstrap.css">
    <link rel="stylesheet" href="{{env('STATIC_URL')}}/css/css/iconfont.css">
    <link rel="stylesheet" href="{{env('STATIC_URL')}}/css/css/base.css">
    <link rel="stylesheet" href="{{env('STATIC_URL')}}/css/css/goods.css">
    <link rel="stylesheet" href="{{env('STATIC_URL')}}/layui/css/layui.css">
    <div class="marginB" id="loadingPicBlock">
        <div class="goods-wrap marginB site-demo-fiow layui-field-title" style="margin-top:20px">
            <div style="position: fixed;top:0;width: 100%;z-index: 2" >
                <div class="goods margin-top-3d9rem margin-bottom-6rem" style="margin-top: -10px">
                    <ul class="xx-nav-tabs xx-nav">
                        <li class="text-center">
                            <a href="javascript:;" order="1" class="xjp-inline-block font-size-1d2rem active " style="width: 100%">
                                <span>全部</span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="javascript:;" order="2" class="xjp-inline-block font-size-1d2rem" style="width: 100%">
                                销量
                                <span class="a">↓</span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="javascript:;" order="3" class="xjp-inline-block font-size-1d2rem" style="width: 100%">
                                价格
                                <span class="a">↓</span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="javascript:;" order="4" class="xjp-inline-block font-size-1d2rem" style="width: 100%">最新</a>
                        </li>
                    </ul>

                </div>
            </div>

            <input type="hidden" value="{{$cid}}" id="cid">
            <div class="goods-wrap marginB site_demo_flow" style="margin-top: 100px">
                <ul id="demo" class="goods-list clearfix">

                </ul>
            </div>


        </div>
    </div>
    <script src="{{env('STATIC_URL')}}/layui/layui.js"></script>
    <script src="{{env('STATIC_URL')}}/js/jquery-1.11.2.min.js"></script>
    <script>
        $(function () {
            upload(1,0)
            function upload(order_field,order_type){

                layui.use('flow', function() {
                    var $ = layui.jquery;
                    var flow = layui.flow;
                    var cid=$('#cid').val()
                    $('#demo').html('');
                    flow.load({
                        elem: '#demo'
                        , isLazyimg: true
                        , done: function (page, next) {
                            $.get('{{url('/prolist')}}?page='+page+'&cid='+cid+'&order_field='+order_field+'&order_type='+order_type,function (res) {

                                next(res.view_content, page < res.page_count);
                            })
                        }
                    });
                })
            }
            $('.xjp-inline-block').click(function () {
                $('.xjp-inline-block').removeClass('active')
                $(this).addClass('active')
                var order_field=$(this).attr('order');
                //1是正序  2是倒叙
                var order_type=0;
                if(order_field==2||order_field==3){
                    var type=$(this).find('.a').text()
                    if(type=='↓'){
                        $(this).find('.a').text('↑')
                        order_type=2;
                    }else if(type=='↑'){
                        $(this).find('.a').text('↓')
                        order_type=1;
                    }else{
                        $(this).find('.a').text('↓')
                        order_type=2;
                    }
                }else{
                    $('.a').text('↓')
                }
                upload(order_field,order_type)
            })

            $('.text-center').click(function () {
                $('.text-center').find('a').removeClass('active');
                $(this).find('a').addClass('active')


            })
        })
    </script>
@endsection

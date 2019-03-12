@extends('layouts.main')
    <link href="{{env('STATIC_URL')}}/css/comm.css" rel="stylesheet" type="text/css" />
    <link href="{{env('STATIC_URL')}}/css/cartlist.css" rel="stylesheet" type="text/css" />
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
<input name="hidUserID" type="hidden" id="hidUserID" value="-1" />
<div>
    <!--首页头部-->
    <div class="m-block-header">
        <a href="/" class="m-public-icon m-1yyg-icon"></a>
        <a href="/" class="m-index-icon">编辑</a>
    </div>
    <!--首页头部 end-->
    <div class="g-Cart-list">
        <ul id="cartBody">

                @foreach($info as $v)
                {{--<input type="hidden" cart_id="{{$v['cart_id']}}" id="cart_id">--}}
                <input type="hidden" value="{{$v['sku_id']}}" sku_id="{{$v['sku_id']}}" id="sku_id">
                <li>
                    <input type="hidden" value="{{$v['add_price']*$v['buy_number']}}">

                    <s class="xuan"></s>
                    {{--<a class="fl u-Cart-img" href="/v44/product/12501977.do">
                        <img src="{{env('PUBLIC_URL')}}{{$v['goods_img']}}" border="0" alt="">
                    </a>--}}
                    <div class="u-Cart-r">

                        {{--<a href="/v44/product/12501977.do" class="gray6">{{$v['sku_name']}}</a>--}}

                        <?php
                        $price= $v['add_price'] * $v['buy_number'];
                        ?>
                        <span style="color:red;" class="gray9">
                                <em> ￥{{$price}}元</em>
                        </span>
                        <div class="num-opt">
                            <em class="num-mius dis min" class="dis"  sku_id="{{$v['sku_id']}}"><i></i></em>
                            <input class="text_box" name="num" maxlength="6" sku_id="{{$v['sku_id']}}" type="text" value="{{$v['buy_number']}}" codeid="12501977">
                            <em class="num-add add" class="add" sku_id="{{$v['sku_id']}}"><i></i></em>
                        </div>
{{--
                        <input type="hidden" value="{{$v['cart_id']}}" cart_id="{{$v['cart_id']}}" name="cart">
--}}
                        <a href="javascript:;" name="delLink" class="z-del"><s></s></a>

                    </div>
                </li>

                @endforeach
        </ul>
    </div>
    <div id="mycartpay" class="g-Total-bt g-car-new" style="">

        <dl>
            <dt class="gray6">
                <s class="quanxuan"></s>全选
                <p class="money-total">合计<em class="orange total">￥<span class="so"></span> </em></p>

            </dt>
            <dd>
                <a href="javascript:;" id="a_payment" class="orangeBtn w_account remove">删除</a>
                <a href="{{'payment'}}" id="a_payment" class="orangeBtn w_account">去结算</a>
            </dd>
        </dl>
    </div>

 @endsection

    <script src="{{env('STATIC_URL')}}/js/jquery-1.11.2.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.add').click(function () {
                all(2, $(this).prev());
            });
            $('.dis').click(function () {
                all(1, $(this).next());
            });

            function all($type, $ele) {
                var buy_number = parseInt($ele.val());

                //alert(buy_number);return false;

                if ($type == 1) {
                    buy_number = buy_number - 1
                } else if ($type == 2) {
                    buy_number = buy_number + 1
                }

                if (buy_number <= 1) {
                    buy_number = 1
                }

                var sku_id = $ele.attr('sku_id');
                $.ajax({
                    url: "{{url('/number')}}",
                    data: 'sku_id=' + sku_id + '&buy_number=' + buy_number,
                    dataType: 'json',
                    type: 'post',
                    success: function (json_info) {
                        if (json_info.status == 1000) {
                            location.href = "{{url('/cart_show')}}"
                        }
                    }
                })
            }

            // current
            //全选
            $(".quanxuan").click(function () {
                if ($(this).hasClass('current')) {
                    $(this).removeClass('current');

                    $(".g-Cart-list .xuan").each(function () {
                        if ($(this).hasClass("current")) {
                            $(this).removeClass("current");
                        } else {
                            $(this).addClass("current");
                        }
                    });
                } else {
                    $(this).addClass('current');

                    $(".g-Cart-list .xuan").each(function () {
                        $(this).addClass("current");
                        // $(this).next().css({ "background-color": "#3366cc", "color": "#ffffff" });
                    });

                }
                GetCount();

            });
            // 单选
            $(".g-Cart-list .xuan").click(function () {
                if ($(this).hasClass('current')) {
                    $(this).removeClass('current');
                } else {
                    $(this).addClass('current');

                }
                if ($('.g-Cart-list .xuan.current').length == $('#cartBody li').length) {
                    $('.quanxuan').addClass('current');
                } else {
                    $('.quanxuan').removeClass('current');
                }
                GetCount();
            });

            // 已选中的总额

            function GetCount() {
                var conts = 0;
                var aa = 0;
                $(".g-Cart-list .xuan").each(function () {

                    if ($(this).hasClass("current")) {
                        for (var i = 0; i < $(this).length; i++) {
                            conts += parseInt($(this).prev('input').val());
                            // aa += 1;
                        }
                    }
                });

                $(".total").html('<span>￥</span>'+(conts).toFixed(2));
            }
            GetCount();


            /**
             *删除
             */
            $('.z-del').click(function () {
                var cart_id=$(this).prev('input').val();
                $.ajax({
                    url:"{{url('cart_del')}}",
                    data:'cart_id='+cart_id,
                    type: 'post',
                    datatype:'json',
                    success:function (json_msg) {
                        if(json_msg.status==1000){
                            window.location.href="{{url('cart_show')}}";
                        }
                    }
                });
            });


            $('.w_account').click(function () {



                    var cart_id='';
                    $('.xuan').each(function () {
                        if ($(this).hasClass('current')) {
                            if (cart_id=='') {
                                cart_id +=  $(this).siblings('div').children('input').attr('cart_id');
                            } else {
                                cart_id += ',' +  $(this).siblings('div').children('input').attr('cart_id');
                            }
                        }
                    });
                    if (cart_id=='') {
                        alert('请选择要购买的商品');
                        return false;
                    }
                $.ajax({
                    url:"{{url('order')}}",
                    data:'cart_id='+cart_id,
                    type:'post',
                    dataType:'json',
                    success:function (json_info) {
                        if(json_info.status==1000){
                            window.location.href ="{{url('payment')}}?cart_id="+cart_id;
                        }
                    }

                });


            })





        });


    </script>

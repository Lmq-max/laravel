@extends('layouts.main')
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta charset="utf-8">
    <title>所有分类</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{env('CATE_URL')}}/css/swiper-3.2.5.min.css" />
    <link rel="stylesheet" href="{{env('CATE_URL')}}/css/ectouch.css" />
    <link rel="stylesheet" href="{{env('CATE_URL')}}/css/search.css" />
</head>
<body style="max-width:640px;font-size: 14px;">
@section('content')
<div id="loading"><img src="{{env('CATE_URL')}}/images/loading.gif" /></div>
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
                @foreach($cateInfo as $v)   
                <li  class="active">{{$v['cate_name']}}</li>
                @endforeach
            </ul>
        </div>
    </aside>
    <section class="menu-right padding-all j-content">
        <h5>全部商品</h5>
        <ul>
            <li class="w-3"><a href="#"></a> <img src="{{env('CATE_URL')}}/images/tp.png" /><span>全部商品</span></li>
        </ul>
    </section>
    @foreach($cateInfo as $son)
    <section class="menu-right padding-all j-content" style="display:none">
        @foreach($son['son'] as $vv)
        <h5>{{$vv['cate_name']}}</h5>
        <ul>
            @foreach($vv['son'] as $vvv)
            <li class="w-3">
                <a href="{{url('all_show')}}?cate_id= {{$vvv['cate_id']}}"></a>
                <img src="{{env('CATE_URL')}}/images/tp.png" /><span>{{$vvv['cate_name']}}
                </span>
            </li>
            @endforeach
        </ul>
        @endforeach
    </section>
    @endforeach
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
         {{--   <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <p>
                        <label class="fl">热门搜索</label>
                    </p>
                    <ul class="hot-search a-text-more">
                        <li class="w-3"><a href="#"><span>美国</span></a></li>
                        <li class="w-3"><a href="#"><span>新生婴儿</span></a></li>
                    </ul>
                    <p class="hos-search">
                        <label class="fl">最近搜索</label>
                        <span class="fr" onClick="javascript:clearHistroy();"><i class="fr"></i></span> </p>
                    <ul class="hot-search a-text-more a-text-one" id="search_histroy">
                    </ul>
                </div>
            </div>--}}
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
<script type="text/javascript" src="{{env('CATE_URL')}}/js/jquery.min.js"></script>
<script type="text/javascript" src="{{env('CATE_URL')}}/js/swiper-3.2.5.min.js"></script>
<script type="text/javascript" src="{{env('CATE_URL')}}/js/ectouch.js"></script>
<script type="text/javascript" src="{{env('CATE_URL')}}/js/jquery.json.js"></script>
<script type="text/javascript" src="{{env('CATE_URL')}}/js/common.js"></script>
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
                    url:"{{url('searcha')}}",
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
                                    '            <img class="lazy" src="{{env('PUBLIC_URL')}}/'+a[i]['_source']['brand_logo']+'" style="height:120px">\n' +
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
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>登录</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="{{env('STATIC_URL')}}/css/comm.css" rel="stylesheet" type="text/css" />
    <link href="{{env('STATIC_URL')}}/css/login.css" rel="stylesheet" type="text/css" />
    <link href="{{env('STATIC_URL')}}/css/vccode.css" rel="stylesheet" type="text/css" />
    <link href="{{env('STATIC_URL')}}/layui/css/layui.css" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">登录</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="home-icon"></i></a>
</div>

<div class="wrapper">
    <div class="registerCon">
        <div class="binSuccess5">
            <ul>
                <li class="accAndPwd">
                    <dl>
                        <div class="txtAccount">
                            <input onkeyup="showClose()" id="txtAccount" type="text" placeholder="请输入您的手机号码/邮箱" value="1397720537@qq.com"><i></i>
                        </div>
                        <cite class="passport_set" style="display: none"></cite>
                    </dl>
                    <dl>
                        <input id="txtPassword" type="password" placeholder="密码" value="" maxlength="20" /><b></b>
                    </dl>
                   {{-- <dl>
                        <input type="text" placeholder="验证码" value="" maxlength="20" /><b></b>
                        <img src="{{captcha_src()}}" id="vcode_img" onclick="changeVcode()" alt="">
                    </dl>--}}
                </li>
            </ul>
            <a id="btnLogin" href="javascript:;" class="orangeBtn loginBtn">登录</a>
        </div>
        <div class="forget">
            <a href="/find_pwd">忘记密码？</a><b></b><a href="{{url('register')}}">新用户注册</a>
        </div>
    </div>
    <div class="oter_operation gray9" style="display: block;">

        <p>登录666潮人购账号后，可在微信进行以下操作：</p>
        1、查看您的潮购记录、获得商品信息、余额等<br />
        2、随时掌握最新晒单、最新揭晓动态信息
    </div>
</div>


</body>
</html>
<script type="text/javascript" src="{{env('STATIC_URL')}}/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="{{env('STATIC_URL')}}/layui/layui.js"></script>
<script type="text/javascript" src="{{env('STATIC_URL')}}/js/common.js"></script>


<script type="text/javascript">
    $.ajaxSetup({ headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    })

    $('.loginBtn').click(function(){
        var user_name=$('#txtAccount').val();
        if(user_name==''){
            alert('请输入你的用户名');
        }
        var user_pwd=$('#txtPassword').val();
        if(user_pwd==''){
            alert('请输入密码');
        }
        var vcode=$('#vcode_img').parent('dl').children('input').val();
        if(vcode==''){
            alert('请输入验证码');
            return false;
        }
        $.ajax({
            url:'{{url('login')}}',
            data:'user_name='+user_name+'&user_pwd='+user_pwd,//+'&vcode='+vcode,
            dataType:'json',
            type:'post',
            success:function(json_info){

                if(json_info.status==1000){
                    alert('登陆成功');
                    location.href="{{url('index')}}"
                }else{
                    alert(json_info.data);
                }
            }
        })

    })
    function showClose(){
        if($('#txtAccount').val()==''){
            $('.passport_set').hide();
        }else{
            $('.passport_set').show();
        }
    }

    function changeVcode(){
        var url=$('#vcode_img').prop('src')+'?'+Math.random();
        $('#vcode_img').prop('src',url);
    }


    $('.passport_set').click(function(){
        $('#txtAccount').val('');
        $('#txtPassword').val('');
        $('.passport_set').hide();
    })
    showClose();
</script>

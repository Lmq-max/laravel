<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>修改支付密码</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="{{env('STATIC_URL')}}/css/comm.css" rel="stylesheet" type="text/css" />
    <link href="{{env('STATIC_URL')}}/css/login.css" rel="stylesheet" type="text/css" />
    <link href="{{env('STATIC_URL')}}/css/findpwd.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{env('STATIC_URL')}}/layui/css/layui.css">
    <link rel="stylesheet" href="{{env('STATIC_URL')}}/css/modipwd.css">
    <script src="{{env('STATIC_URL')}}/js/jquery-1.11.2.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">修改登录密码</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
</div>



<div class="wrapper">
    <form class="layui-form" action="">
        <div class="registerCon regwrapp">
            <div class="account">
                <em>账户名：</em> <i>{{$cateInfo}}</i>
            </div>
            <div><em>新密码</em><input id="pwd" type="password" placeholder="请输入6-16位数字、字母组成的新密码"></div>
            <div><em>确认新密码</em><input id="pwd2" type="password" placeholder="确认新密码"></div>
            <div class="save"><span>保存</span></div>
        </div>
    </form>
</div>


<script type="text/javascript" src="{{env('STATIC_URL')}}/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="{{env('STATIC_URL')}}/layui/layui.js"></script>
<script type="text/javascript" src="{{env('STATIC_URL')}}/js/common.js"></script>
<script>

    $.ajaxSetup({ headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
        $('.save').click(function () {
            var pwd=$('#pwd').val();
            var pwd2=$('#pwd2').val();

            if(pwd != pwd2){
                alert('两次输入的密码不一致');
                return false;
            }
            $.ajax({
                url:"{{url('savepwd')}}",
                data:'pwd='+pwd+'&pwd2='+pwd2,
                type:'post',
                dataType:'json',
                success:function(json_info) {
                    if(json_info.status==1000){
                        alert('密码修改成功，请返回登录！');
                    }else{
                        alert(json_info.data);
                    }
                }
            });

        })

</script>

</body>
</html>

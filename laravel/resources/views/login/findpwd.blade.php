<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>找回密码</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="{{env('STATIC_URL')}}/css/comm.css" rel="stylesheet" type="text/css" />
    <link href="{{env('STATIC_URL')}}/css/login.css" rel="stylesheet" type="text/css" />
    <link href="{{env('STATIC_URL')}}/css/find.css" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">找回密码</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="home-icon"></i></a>
</div>

<div class="wrapper">
    <div class="registerCon">
        <div class="binSuccess5">
            <ul>
                <li class="accAndPwd">
                    <dl class="phone">
                        <div class="txtAccount">
                            <input id="txtAccount" type="text" placeholder="请输入您的手机号" value="18001216012"><i></i>
                            <a href="javascript:void(0);" class="sendcode" id="btn">获取验证码</a>
                        </div>
                        <cite class="passport_set" style="display: none"></cite>
                    </dl>
                    <dl>
                        <input id="txtPassword" type="text" placeholder="请输入验证码" value="" maxlength="20" /><b></b>
                    </dl>
                </li>
            </ul>
            <a id="btnLogin" href="javascript:;" class="orangeBtn loginBtn">下一步</a>
        </div>
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
    });

        var tel=$('#txtAccount').val();

        $('#btn').click(function(){
            $('#btn').html(60+'s');
            $('#btn').prop('disable',true);
            set=setInterval(goTime,1000);
            $.ajax({
                url:"{{url('find_pwd')}}",
                data:'tel='+tel,
                dataType:'json',
                type:'post',
                success:function(json_info){
                    if(json_info.status==1000){
                        alert('发送成功')
                    }else{
                        alert(json_info.msg);
                    }
                }
            })
        });
        function goTime(){
            res=parseInt($('#btn').html());
            to=res-1;
            $('#btn').html(to +'s');
            if(to<0){
                $('#btn').html('获取');
                $('#btn').prop('disable',false);
                clearInterval(set);
            }
        }

        $('.loginBtn').click(function () {
            var sendCode=$('#txtPassword').val();

            $.ajax({
                url:"{{url('sendCode')}}",
                data:'sendCode='+sendCode,
                type:'post',
                datatype:'json',
                success:function (info) {
                    if(info.status==1000){
                        window.location.href="{{url('savepwd')}}";
                    }else{
                        alert(info.data);
                    }
                }
            });
        });





</script>

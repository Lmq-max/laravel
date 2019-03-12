<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>注册验证</title>
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
    <strong id="m-title"></strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
</div>



<div class="wrapper">
    <form class="layui-form" action="">
        <div class="registerCon">
            <ul>
                <li class="auth"><em>请输入验证码</em></li>
                <li><p>我们已向<em class="red">{{$user_info}}</em>发送验证码短信，请查看短信并输入验证码。</p></li>
                <li>
                    <input type="hidden" value="{{$user_info}}" id="tel">
                    <input type="text" id="userMobile" placeholder="请输入验证码" value=""/>
                    <a href="javascript:void(0);" class="sendcode" id="btn">获取</a>
                </li>
                <li><a id="findPasswordNextBtn" href="javascript:void(0);" class="orangeBtn">确认</a></li>
                <li>换了手机号码或遗失？请致电客服解除绑定400-666-2110</li>
            </ul>
        </div>
    </form>
</div>


<script src="{{env('STATIC_URL')}}/layui/layui.js"></script>
<script type="text/javascript" src="{{env('STATIC_URL')}}/js/common.js"></script>
<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form();

        //监听提交
        form.on('submit(formDemo)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });
    });

</script>

</body>
</html>
<script>
    $.ajaxSetup({ headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    })
    $(function(){
        var tel=$('#tel').val();
        var userMobile=$('#userMobile').val();

        $('#btn').click(function(){
            $('#btn').html(5+'s');
            $('#btn').prop('disable',true);
            set=setInterval(goTime,1000);
            $.ajax({
                url:"{{url('sendCode')}}",
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
         })
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
        $('.orangeBtn').click(function(){
            var userMobile=$('#userMobile').val();
            $.ajax({
                url:'{{url('regauths')}}',
                data:'userMobile='+userMobile,
                dataType:'json',
                type:'post',
                success:function(json_info){
                    if(json_info.status==1000){
                        location.href="{{url('login')}}"
                    }else{
                        alert(json_info.msg);
                    }
                }
            })
        })
    })
</script>

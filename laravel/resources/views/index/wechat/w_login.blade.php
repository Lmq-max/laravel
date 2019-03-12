
<head lang="en">
    <meta charset="UTF-8">
    <title>微信授权登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{env('STATIC_URL')}}/layui/css/layui.css">
    <script src="{{env('STATIC_URL')}}layui/layui.js"></script>
    <script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body  style="text-align: center">

<div >

    <img src="{{ Session::get('w_login.headimgurl')}}" alt="">
    <br/>
    <div style="text-align: center;margin-top: 20px">
        <!-- layui 2.2.5 新增 -->
        <button class="layui-btn layui-btn-fluid" openid="{{ Session::get('w_login.openid')}}" uid="{{$uid}}">确认登录</button>
    </div>
    <br/>
    <div style="text-align: center">
        <!-- layui 2.2.5 新增 -->
        <button class="layui-btn layui-btn-fluid btn">取消</button>
    </div>
</div>
</body>
<script type="text/javascript">
    $(function () {
        $.ajaxSetup({ headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $('.btn').click(function () {
            WeixinJSBridge.invoke('closeWindow',{},function(res){});
        });
        $('.layui-btn').click(function () {
            var openid=$(this).attr('openid');

            var uid=$(this).attr('uid');

            $.ajax({
                url:'{{url('w_login3')}}',
                data:'openid='+openid+'&uid='+uid,
                dataType:'json',
                type:'post',
                success:function (json_info){
                    if(json_info.status==1000){
                        WeixinJSBridge.invoke('closeWindow',{},function (res) {})
                    }else{
                        alert(json_info.msg)
                    }
                }
            });
            WeixinJSBridge.invoke('closeWindow',{},function(res){});
        })
    })
</script>



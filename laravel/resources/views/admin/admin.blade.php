<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layout 后台大布局 - Layui</title>
    <link rel="stylesheet" href="{{env('LAYUI_URL')}}/css/layui.css">
    <script src="{{env('LAYUI_URL')}}/layui.js"></script>

<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    @include('admin.layout.top')
    <div class="layui-side layui-bg-black">

    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        @section('content')

        @show
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;

    });
</script>
</body>
</html>
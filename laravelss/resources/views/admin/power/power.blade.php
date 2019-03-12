@extends('admin.layout.main')
@section('content')
<head>
    <meta charset="UTF-8">
    <title>节点添加</title>
</head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<body>
<h2>---节点添加---</h2>
<form class="layui-form" action="">
    <div class="layui-form-item">
        ...
        <label class="layui-form-label">节点名称</label>
        <div class="layui-input-inline">
            <input type="text" name="node_name"  placeholder="请输入节点名称" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">节点路径</label>
        <div class="layui-input-inline">
            <input type="text" name="node_url" placeholder="请输入节点路径" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">父级权限</label>
            <div class="layui-input-inline">
                <select name="pid">
                    <option value="0">---请选择---</option>
                    @foreach($list as $v)
                        <option value="{{$v->node_id}}">{{$v->node_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否展示</label>
        <div class="layui-input-block">
            <input type="radio" name="status" value="1" title="是" checked="">
            <input type="radio" name="status" value="0" title="否">
        </div>
    </div>
    <div class="layui-input-block">
        <button class="layui-btn" lay-submit lay-filter="*">提交</button>
        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
</form>
</body>
@endsection
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="{{env('CATE_URL')}}/js/common.js"></script>
<script>
    $(function(){
        layui.use(['form','layer'],function(){
            var layer=layui.layer;
            var form=layui.form;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            //监听提交
            form.on('submit(*)', function(data){
                //console.log(data)
                $.post(
                    "{{url('main/power')}}",
                    data.field,
                    function(json_info){
                        if(json_info.status==1000){
                            alert('添加节点成功');
                        }else{
                            alert(data.msg)
                        }
                    }//,
                    //'json'

                );
                return false;
            });



        })


    })

</script>
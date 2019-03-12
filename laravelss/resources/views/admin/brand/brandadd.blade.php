@extends('admin.layout.main')
@section('content')

<h2>---品牌添加----</h2>&nbsp;&nbsp;&nbsp;
<meta name="csrf-token" content="{{ csrf_token() }}">
<form class="layui-form layui-form-pane">
    <div class="layui-form-item">
        <label class="layui-form-label">品牌名称</label>
        <div class="layui-input-inline">
            <input type="text" name="brand_name"  autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">品牌地址</label>
        <div class="layui-input-inline">
            <input type="text" name="brand_url" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">品牌描述</label>
        <div class="layui-input-block">
            <textarea  class="layui-textarea" name="brand_describe"></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" name="brand_sort" id="date1" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">品牌logo</label>
            <input type="hidden" name="brand_logo" id="logo">
            <div class="layui-input-inline">
                <button type="button" class="layui-btn" id="myfile">
                    <i class="layui-icon"></i>上传文件
                </button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否展示</label>
        <div class="layui-input-block">
            <input type="radio" name="brand_show" value="1" title="是" checked="">
            <input type="radio" name="brand_show" value="0" title="否">1
        </div>
    </div>
    <div class="layui-input-block">
        <button class="layui-btn" lay-submit lay-filter="*">提交</button>
        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
</form>
@endsection
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<script>
    $(function(){
        layui.use(['form','layer','upload'],function(){
            var form=layui.form;
            var layer=layui.layer;
            var upload=layui.upload;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //执行实例
            var uploadInst = upload.render({
                elem: '#myfile' //绑定元素
                ,url: "{{url('main/uploads')}}" //上传接口
                ,field:'file'
                ,done:function(res,index,upload){
                    layer.msg(res.font,{icon:res.code});
                    if(res.code==1){
                        $('#logo').val(res.src);
                    }
                }
            });



            //监听提交
            form.on('submit(*)',function(data){

                $.post(
                    "{{url('main/brandadd')}}",
                    data.field,
                    function(json_info){
                       if(json_info.status==1000){
                           alert('添加成功');
                       }else{
                           alert(json_info.data);
                       }
                    },
                    'json'
                );
                return false;
            });
        })


    })

</script>
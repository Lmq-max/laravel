
@extends('admin.layout.main')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<form class="layui-form" action="" style="margin-left: 200px;">
    <div style="width: 600px;">
        <div class="layui-form-item">
            <label class="layui-form-label">轮播图标题</label>
            <div class="layui-input-block">
                <input type="text" name="" id="s_name" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">轮播图路由</label>
            <div class="layui-input-block">
                <input type="text" name="" id="s_url" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">轮播图排序</label>
            <div class="layui-input-block">
                <input type="text" name="" id="s_num"   class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">轮播图</label>
                <input type="hidden" name="" id="logo">

                <button type="button" class="layui-btn" id="test1">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>

            </div>

        </div>
        <div class="layui-input-block">
            <a class="layui-btn">提交</a>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
@endsection
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>

<script>
    $(function(){
        $.ajaxSetup({ headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        })
        layui.use(['form','upload'],function() {
            var layer = layui.layer;
            var upload = layui.upload;

            //执行实例
            var uploadInst = upload.render({
                elem: '#test1' //绑定元素
                ,url: "{{url('main/upload')}}" //上传接口
                ,field:'file'
                ,done:function(res,index,upload){
                    layer.msg(res.font,{icon:res.code});
                    if(res.code==1){
                        $('#logo').val(res.src);
                    }
                }
            });



            $('.layui-btn').click(function () {
                var s_name=$('#s_name').val();
                var s_url=$('#s_url').val();
                var s_num=$('#s_num').val();
                var logo=$('#logo').val();
                $.ajax({
                    url:'{{url('main/title')}}',
                    data:'s_name='+s_name+'&s_url='+s_url+'&s_num='+s_num+'&logo='+logo,
                    dataType:'json',
                    type:'post',
                    success:function(json_info){

                        if(json_info.status==1000){
                            alert('添加成功');

                        }else{
                            alert(json_info.data);
                        }
                    }
                })
            })

        })
    })
</script>

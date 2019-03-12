
@extends('admin.layout.main')
<link rel="stylesheet" href="{{env('STATIC_URL')}}/layui/css/layui.css">
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">关键字</label>
                <div class="layui-input-inline">
                    <input type="text" name="test" id="test" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">单选框</label>
            <div class="layui-input-block">
                <input type="radio" name="type"   value="1" title="文字" checked="">
                <input type="radio" name="type" value="2" title="照片">
                <input type="radio" name="type" value="3" title="视频">
            </div>
        </div>
        <div class="layui-form-item test" style="display: none" >
            <div class="layui-inline">
                <label class="layui-form-label">回复内容</label>
                <div class="layui-input-inline">
                    <input type="text" name="txt" id="txt"  autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item imgage" style="display: none" >
            <label class="layui-form-label">回复图片</label>
            <div class="layui-input-block">
                <input type="hidden" name="image" id="image">
                <button type="button" class="layui-btn" id="myfile">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
            </div>
        </div>
        <div class="layui-form-item upload" style="display: none" >
            <label class="layui-form-label">回复视频</label>
            <div class="layui-input-block">
                <input type="hidden" name="video" id="video">
                <button type="button" class="layui-btn" id="test5">
                    <i class="layui-icon">&#xe67c;</i>上传视频
                </button>
            </div>
        </div>
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="*">提交<button>
            <button type="reset" class="layui-btn layui-btn-primary">重置<button>
        </div>

    </form>


@endsection

<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>

<script src="{{env('STATIC_URL')}}/layui/layui.js"></script>

<script>
    $(function(){

        $.ajaxSetup({ headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        })

        layui.use(['form','layer','upload'],function(){
            var layer=layui.layer;
            var form=layui.form;
            var upload=layui.upload;

            //单张图片上传
            upload.render({
                elem:'#myfile'
                ,url:"{{url('main/key_upload')}}"
                ,filed:'file'
                ,done:function(res,index,upload){
                    layer.msg(res.font,{icon:res.code});
                    if(res.code==1){
                        $('#image').val(res.src);
                    }
                }
            });

            //视频上传
            var uploadInst = upload.render({
                elem: '#test5' //绑定元素
                ,url: "{{url('main/key_video')}}" //上传接口
                ,accept: 'video'
                ,exts : 'mp4'
                ,headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                ,done: function(json_res){
                    //上传完毕回调
                    layer.msg(json_res.font,{icon:json_res.code});
                    if(json_res.code==1000){
                        $('#video').val(json_res.src);
                    }
                }

            });





            $(".layui-icon").click(function () {
            var _val=$(this).parent('div').prev('input').val();

            if(_val == 1){
                $('.test').show();
                $('.imgage').hide();
                $('.upload').hide();

            }else if(_val == 2){
                $('.test').hide();
                $('.imgage').show();
                $('.upload').hide();

            }else{
                $('.test').hide();
                $('.imgage').hide();
                $('.upload').show();

            }
        });
            /*监听提交*/
            form.on('submit(*)', function(data){

                $.post(
                    "{{url('main/keyword')}}",
                    data.field,
                    function(json_info) {

                        //console.log(json_info);
                        if (json_info.status == 1000) {
                            alert('添加成功')
                        }else{
                            alert(json_info.msg);
                        }
                    },'json'
                );
                //console.log(data.field)
                return false;
            });



        })
    })
</script>























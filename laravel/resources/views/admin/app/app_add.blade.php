@extends('admin.layout.main')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div style="width: 600px;">

        <div class="layui-form-item">
            <label class="layui-form-label">关注回复</label>
            <div class="layui-input-block">
                <input type="text" id="attention" class="layui-input">
            </div>
        </div>
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="*">提交<tton>
                    <button type="reset" class="layui-btn layui-btn-primary">重置<tton>
        </div>
    </div>
@endsection
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="{{env('STATIC_URL')}}/layui/css/layui.css">
<script src="{{env('STATIC_URL')}}/layui/layui.js"></script>

<script>
    $(function(){

        $.ajaxSetup({ headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        })

        layui.use(['form','layer'],function(){
            var layer=layui.layer;
            var form=layui.form;

            //监听提交
            $('.layui-btn').click(function(){
                var attention=$('#attention').val();

                $.ajax({
                    url:"{{url('main/app_add')}}",
                    data:'attention='+attention,
                    dataType:'json',
                    type:'post',
                    success:function(json_info){
                        if(json_info.status==1000) {
                            alert('添加成功');
                        }else{
                            alert(json_info.data);
                        }

                    }
                })
            });
        })
    })
</script>

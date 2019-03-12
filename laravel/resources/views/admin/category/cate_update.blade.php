@extends('admin.layout.main')
@section('content')
<h2>---分类修改---</h2>

<form class="layui-form" action="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" name="cate_id" value="{{$data['cate_id']}}">
    <div class="layui-form-item">
        <label class="layui-form-label">分类名称</label>
        <div class="layui-input-inline">
            <input type="text" name="cate_name"placeholder="请输入标题" value="{{$data['cate_name']}}" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">父类id</label>
            <div class="layui-input-inline">
                <select name="pid">
                    @foreach($info as $v)
                    <option value="{{$v['cate_id']}}" selected>{{str_repeat('-',$v['level']*2)}}{{$v['cate_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">是否展示</label>
            <div class="layui-input-block">
                <input type="checkbox" id="cate_show" name="cate_show" value="{{$data['cate_show']}}" lay-skin="switch" lay-text="ON|OFF">
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">是否在导航栏上展示</label>
            <div class="layui-input-block">
                <input type="checkbox" id='cate_navshow' name="cate_navshow" value="{{$data['cate_navshow']}}" lay-skin="switch"  lay-text="ON|OFF">
            </div>
        </div>
    </div>
    <div class="layui-input-block">
        <button class="layui-btn" lay-submit lay-filter="*">提交</button>
        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
</form>
@endsection
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="{{env('CATE_URL')}}/js/common.js"></script>
<script>

    $(function(){

        var cate_show=$('#cate_show').val();
        if(cate_show==1){
            $('#cate_show').attr('checked',true);
        }else{
            $('#cate_show').attr('checked',false);
        }
        /*是否在导航栏展示*/
        var cate_navshow=$('#cate_navshow').val();
        if(cate_navshow==1){
            $('#cate_navshow').attr('checked',true);
        }else{
            $('#cate_navshow').attr('checked',false);
        }


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
                $.ajax({
                    url:"{{url('main/save')}}"
                    ,data:data.field
                    ,dataType:'json'
                    ,type:'post'
                    ,success:function (json_info) {
                        if(json_info.status==1000){
                            alert('修改成功');
                        }else{
                            alert(json_info.msg);
                        }
                    }
                });
                return false;
            });



        })


    })

</script>
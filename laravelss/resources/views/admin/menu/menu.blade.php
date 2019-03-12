@extends('admin.layout.main')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
<form class="layui-form" action="">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">菜单名称</label>
            <div class="layui-input-inline">
                <input type="text" name="menu_name" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">父级菜单</label>
            <div class="layui-input-inline">
                <select name="parent" lay-filter="parent">
                    <option value=" ">--请选择--</option>
                    @foreach($menu_info as $v)
                        <option value="{{$v->menu_id}}">{{$v->menu_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">按钮类型</label>
            <div class="layui-input-inline">
                <select name="interest" lay-filter="menu_type">
                    <option value="">--按钮类型--</option>
                    <option value="1">页面跳转</option>
                    <option value="2">点击事件</option>
                    <option value="3">扫码推送</option>
                </select>
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
<link rel="stylesheet" href="{{env('STATIC_URL')}}/layui/css/layui.css">
<script src="{{env('STATIC_URL')}}/layui/layui.js"></script>

<script type="text/javascript">
    $(function () {
        $.ajaxSetup({ headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        layui.use(['form','layer'],function() {
            var layer = layui.layer;
            var form = layui.form;

            form.on('select(menu_type)',function(data){
                var menu_type=data.value;
                var div_str='<div class="layui-inline add">\n' +
                    '            <label class="layui-form-label">__MENU_NAME__</label>\n' +
                    '            <div class="layui-input-inline">\n' +
                    '                <input type="text" name="content" lay-verify="required" autocomplete="off" class="layui-input">\n' +
                    '            </div>\n' +
                    '        </div>';

                if( menu_type ==1){
                    div_str=div_str.replace('__MENU_NAME__','跳转链接');
                }else if(menu_type==2) {
                    div_str=div_str.replace('__MENU_NAME__','点击事件');
                }else{
                    div_str=div_str.replace('__MENU_NAME__','扫码推送');
                }

                $('.add').remove();
                data.othis.parents('.layui-inline').after(div_str);
            });

            //*监听提交*/
            form.on('submit(*)', function(data){

                $.ajax({
                        url: "{{url('main/menu')}}",
                        data:data.field,
                        type:'post',
                        dataType:'json',
                        success:function (json_info) {
                            if (json_info.status == 1000) {
                                alert('添加成功');
                            } else {
                                alert(json_info.data)
                            }
                        }
            });
                return false;
            });


        })


    })
</script>



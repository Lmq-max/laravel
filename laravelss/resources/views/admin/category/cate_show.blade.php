@extends('admin.layout.main')
@section('content')

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>分类表格</legend>
</fieldset>

<div class="layui-form">
    <table class="layui-table">
        <thead>
        <tr>
            <th>分类id</th>
            <th>分类名称</th>
            <th>时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
      @foreach($info as $v)
        <tr class="showHide" pid="{{$v['pid']}}" cate_id="{{$v['cate_id']}}" style="display: none;">
            <td>
                {{str_repeat('-',$v['level']*2)}}
                <a href="javascript:;" class="showCate">+</a>
                {{$v['cate_id']}}
            </td>
            <td>
                {{str_repeat('-',$v['level']*2)}}
                <span class="showInput">{{$v['cate_name']}}</span>
                <input class="change" style="display: none;" type="text" column="cate_name" cate_id="{{$v['cate_id']}}" value="{{$v['cate_name']}}">
            </td>
            <td>{{date("Y-m-d H:i:s",$v['cate_time'])}}</td>
            <td>
                <a href="{{url('main/delete')}}?cate_id= {{$v['cate_id']}}"  cate_id="{{$v['cate_id']}}" pid="{{$v['pid']}}">删除</a>
                <a href="{{url('main/update')}}?cate_id= {{$v['cate_id']}}"  cate_id="{{$v['cate_id']}}" pid="{{$v['pid']}}">编辑</a>
            </td>

        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<script>
    $(function(){
        layui.use(['layer','table'],function(){
            var layer=layui.layer;
            var table=layui.table;

            showTr(0);
            //展示
            function showTr(cate_id){
                var _tr=$('.showHide');
                _tr.each(function(index){
                    if($(this).attr('pid')==cate_id){
                        $(this).show();
                    }
                })
            }
            //隐藏
            function hideTr(cate_id){
                var _tr=$('.showHide');
                _tr.each(function(index){
                    var pid=$(this).attr('pid');
                    if(pid==cate_id){
                        var new_cateId=$(this).attr('cate_id');
                        hideTr(new_cateId);
                        $(this).hide();
                    }
                })
            }

            //给超链接绑定点击事件
            $('.showCate').click(function(){
                //获取当前对象的文本值  +  -
                var sign=$(this).html();
                //获取当前分类的id
                var cate_id=$(this).parents('tr').attr('cate_id');
                if(sign=='+'){
                    //展示此分类的子类
                    showTr(cate_id);
                    $(this).html('-');
                }else{
                    //隐藏此分类的子类
                    hideTr(cate_id);
                    $(this).html('+');
                }
            });

            //给showInput绑定点击事件
            $('.showInput').click(function(){
                $(this).next('input').show();
                $(this).hide();
            });

            //文本框绑定失去焦点事件
            $('.change').blur(function(){
                var column=$(this).attr('column');
                var cate_id=$(this).attr('cate_id');
                var _value=$(this).val();
                var _this=$(this);
                $.post(
                    "{:url('Category/cateChange')}",
                    {column:column,cate_id:cate_id,value:_value},
                    function(msg){
                        layer.msg(msg.font,{icon:msg.code});
                        if(msg.code==1){
                            _this.hide();
                            _this.prev('span').html(_value);
                            _this.prev('span').show();
                        }
                    },
                    'json'
                )




            })

        })
    })
</script>


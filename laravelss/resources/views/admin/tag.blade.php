@extends('admin.layout.main')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <table lay-filter="parse-table-demo">
        <tbody>
        <tr>
            <td>id</td>
            <td>标签名</td>
            <td>删除</td>
            <td>发消息</td>
        </tr>
        @foreach($tag as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->tag_name}}</td>
            <td><a href="{{url('main/deltag')}}?id={{$v->id}}">删除</a></td>
            <td><a href="{{url('main/msgs')}}?uid={{$v->id}}">发消息</a></td>
            <td><a href="{{url('main/openid')}}?uid={{$v->id}}">openid群发</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>

@endsection
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<script src="{{env('STATIC_URL')}}/layui/layui.js"></script>

<link rel="stylesheet" href="{{env('STATIC_URL')}}/layui/css/layui.css">
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    layui.use('table', function(){
        var table = layui.table;

        var $ = layui.$, active = {
            parseTable: function(){
                table.init('parse-table-demo', { //转化静态表格
                    //height: 'full-500'
                });
            }
        };

        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
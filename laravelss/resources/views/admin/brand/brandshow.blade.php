<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{env('LAYUI_URL')}}/css/layui.css">
<script src="{{env('LAYUI_URL')}}/layui.js"></script>
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
@extends('admin.layout.main')
@section('content')
<table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>品牌id</th>
        <th>品牌名称</th>
        <th>品牌连接</th>
        <th>品牌logo</th>
        <th>品牌描述</th>
        <th>品牌时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($page as $v)
    <tr>
        <td>{{$v->brand_id}}</td>
        <td>{{$v->brand_name}}</td>
        <td>{{$v->brand_url}}</td>
        <td><img src="/{{$v->brand_logo}}" alt=""></td>
        <td>{{$v->brand_describe}}</td>
        <td>{{date("Y-m-d H:i:s",$v->brand_time)}}</td>
        <td>
            <a href="{{url('main/brand_del')}}?brand_id={{$v->brand_id}}">删除</a>
            <a href="{{url('main/brand_update')}}?brand_id={{$v->brand_id}}">修改</a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
{{ $page->links() }}
@endsection
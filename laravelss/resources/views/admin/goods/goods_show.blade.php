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
        <th>商品id</th>
        <th>商品名称</th>
        <th>商品图片</th>
    </tr>
    </thead>
    <tbody>
    @foreach($info as $v)
    <tr>
        <td>{{$v->goods_id}}</td>
        <td>{{$v->goods_name}}</td>
        <td><img src="{{env('PUBLIC_URL')}}{{$v->goods_img}}" alt=""></td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection

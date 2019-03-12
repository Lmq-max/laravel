@extends('admin.layout.main')
 @section('content')
     <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="{{env('STATIC_URL')}}/layui/css/layui.css">
<script src="{{env('STATIC_URL')}}/layui/layui.js"></script>
<div class="layui-form">
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>

        <tr>
            <th>id</th>
            <th>用户openID</th>
            <th>打标签</th>



        </tr>
        @foreach($w as $v)
        <tr>
            <th>{{$v->id}}</th>
            <th>{{$v->openid}}</th>
            <th><a href="{{url('main/qian')}}?uid={{$v->id}}">添加到标签</a></th>


        </tr>
            @endforeach
        </thead>

    </table>
</div>
     @endsection

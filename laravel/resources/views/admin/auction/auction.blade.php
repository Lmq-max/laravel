@extends('admin.layout.main')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div style="margin-left: 200px;">
    <div>
        商品名字：<input type="text" name="g_name" id="g_name">
    </div>
    <div>
        低价：<input type="text" name="g_price" id="g_price">
    </div>
    <div>
        每次加价：<input type="text" name="g_prices" id="g_prices">
    </div>
    <div>
        竞拍时间：<input type="datetime-local" name="g_time" id="g_time">————<input type="datetime-local" name="g_times" id="g_times">
    </div>
    <div>
        <input type="button" value="提交" class="btn">
    </div>
</div>
@endsection
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.btn').click(function () {
        var g_name=$('#g_name').val();
        var g_price=$('#g_price').val();
        var g_prices=$('#g_prices').val();
        var g_time=$('#g_time').val();
        var g_times=$('#g_times').val();

        /**
         * 点击提交
         */
        $.ajax({
            url:"{{url('main/auction_add')}}"
            ,data:'g_name='+g_name+'&g_price='+g_price+'&g_prices='+g_prices+'&g_time='+g_time+'&g_times='+g_times
            ,dataType:'json'
            ,type:'post'
            ,success:function (json_info) {
                if(json_info.status==1000){
                    alert('添加成功');
                }else{
                    alert(json_info.msg);
                }
            }
        });

    })
})

</script>
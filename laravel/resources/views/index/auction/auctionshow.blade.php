
<meta name="csrf-token" content="{{ csrf_token() }}">
<div>
    <div>
        商品名字：{{$res->g_name}}
    </div>
    <div>
        低价：{{$res->g_price}}元
    </div>
    <div>
        每次加价：{{$res->g_prices}}元
    </div>
    <div>
        竞拍时间：{{$res->g_time}}
    </div>
    <div>
        <p>
            说明：
        </p>
        <p>
            开始之后，到 <b> <span style="color:red"> {{$res->g_times}}</span></b>后自动结束
        </p>
    </div>
    <hr/>
    <div>
        <p>我要加价：</p>
        <p class="btn_a">&nbsp&nbsp&nbsp&nbsp当前价格：<span style="color:red" >{{$res->g_price}}</span>元</p>
    </div>
    <br/>
    <div>
        <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp价格：<input placeholder="不能低于当前价格" type="text" name="price" id="price"></p>
        <p>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="button" value="出价" id="btn">
        </p>
    </div>
</div>

<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });






    $('#btn').click(function () {


        var btn_a=$('.btn_a').val();
        console.log(btn_a);return false;

        var g_name=$('#g_name').val();
        var g_price=$('#g_price').val();
        var g_prices=$('#g_prices').val();
        var g_time=$('#g_time').val();
        var g_times=$('#g_times').val();

        /**
         * 点击提交
         */
        $.ajax({
            url:"{{url('auction_add')}}"
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
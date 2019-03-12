<meta name="csrf-token" content="{{ csrf_token() }}">
<table border="1" >
    <tr>
        <td>id</td>
        <td>图片</td>
        <td>审核</td>
    </tr>
    @foreach($logo as $v)
        <tr>
            <td class="id"  >{{$v -> s_id}}</td>
            <td>
                <img src="{{$v -> s_logo}}" alt="" style="width:100px">
            </td>
            <td>
                <p class="buss" aid="{{$v -> s_id}}">通过</p>
            </td>
        </tr>
    @endforeach
</table>


<link rel="stylesheet" href="{{env('STATIC_URL')}}/layui/css/layui.css">
<script src="{{env('STATIC_URL')}}/layui/layui.js"></script>
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>

<script type="text/javascript">
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.buss').click(function(){
            var id = $(this).attr('aid');
            $.ajax({
                url:"{{url('main//adminAudit')}}",
                dataType:'json',
                data:"id="+id,
                type:"post",
                success:function(json_info){
                    if(json_info.status == 1000){
                        location.href ="{{'chartshow'}}" ;
                    }
                }
            })
        })
    })

</script>
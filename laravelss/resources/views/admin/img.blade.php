<meta name="csrf-token" content="{{ csrf_token() }}">

<div>
    <img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$result['ticket']}}"  uid="{{$uid}}" />
</div>
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var uid=$('img').attr('uid')






    })
</script>
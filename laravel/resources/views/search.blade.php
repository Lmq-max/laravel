<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<input type="text" id="username">
<input type="button" value="搜索" id="btn">

    <table>

    </table>
</body>
</html>




<script type="text/javascript" src="{{env('STATIC_URL')}}/js/jquery-1.11.2.min.js"></script>
<script>
    $(function(){
        $('#btn').click(function(){
           var username=$('#username').val();
           var str='';
           var y;
            $.ajax({
                url:"{{url('search')}}",
                data:'username='+username,
                dataType:'json',
                type:'post',
                success:function(json_info){
                    if(json_info.status==100){
                        alert(json_info.data)
                    }else{
                        var a=json_info.res;

                        for(var i=0;i<a.length;i++){
                            str+='<tr>\n' +
                                '            <td>'+a[i]['highlight']['brand_describe']+'</td>\n' +
                                '        </tr>';
                        }
                        $('table').html(str);
                    }

                }
            })
        });
    })

</script>
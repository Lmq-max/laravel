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
<table id="lb">
    @foreach($res as $k=>$v)
        <tr>
            <td>{{$v['_source']['brand_name']}}</td>
            <td>{{$v['_source']['brand_url']}}</td>
            <td>{{$v['_source']['brand_logo']}}</td>
            <td>{{$v['_source']['brand_describe']}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
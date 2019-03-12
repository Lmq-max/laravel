<?php
$type=$_GET['type'];
switch($type){
    case 1:
        $response=[
            'name'=>'lisi',
            'age'=>11,
            'email'=>'lmq@qq.com'
        ];
        break;
    case 2:
        $response=[
            'error'=>0,
            'msg'=>'ok',
            'data'=>[
                'name'=>'lisi',
                'age'=>11,
                'email'=>'lmq@qq.com'
            ]
        ];
        break;
}
header('Content-Type:application/json');
die(json_encode($response));


?>

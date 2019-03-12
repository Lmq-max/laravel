<?php
#session_start();
#echo $_SESSION['name'];
#echo time();
#echo '192.168.43.247';
$root_id=$_POST['a'];
$redis=new redis();
$redis->connect('192.168.43.239',6379);
//$redis->lpush('mylist','word','b','c');
//$redis->lpush('mylist','a','z','x');
#var_dump($redis->lrange('mylist',0,-1));
//$a=$redis->rpop('mylist');
//echo $a;
/*$num=2;
$a=$redis->lLen('qwe');
if($a>=$num){
    echo json_encode([
        'msg'=>'活动结束',
        'data'=>6,
        'status'=>13
    ]);
}else{
    $redis->lpush('qwe',$root_id);
    echo json_encode([
        'msg'=>'秒杀成功，请等待处理',
        'data'=>6,
        'status'=>15
    ]);
}*/
$num=$redis->lPush('iii',$root_id);
while(true){
    //判断是否有订单
    if($redis->sIsMember('ab',$root_id)){
        echo json_encode([
            'msg'=>'抢购成功',
            'data'=>6,
            'status'=>1
        ]);
        break;
    }else{
        if($redis->scard('ab')==2){
            echo json_encode([
                'msg'=>'抢购失败',
                'data'=>6,
                'status'=>0
            ]);
            break;
        }else{
            echo json_encode([
                'msg'=>'抢购成功',
                'data'=>6,
                'status'=>1
            ]);
            break;
        }
    }
}
?>

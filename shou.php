<?php
$num=0;
$redis=new redis();
$redis->connect('192.168.43.239',6379);
while(true){
    sleep(1);
    $uid=$redis->rPop('iii');
    if($uid>0){
        //判断是否为第一次点击
        if($redis->sAdd('ab',$uid)){
            echo 'order create for user'.$uid."\r\n";
            $num++;
        }else{
            echo '重复点击'.$uid;
        }
    }else{
        echo 'no uid'."\r\n";
    }
    if($num>=2){
        break;
    }
}
?>
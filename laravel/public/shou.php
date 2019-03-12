<?php
$redis=new \redis();
$redis->connect('192.168.43.239',6379);
$num=0;
while(true){
    sleep(1);
    $uid=$redis->rPop('list');
    if($uid>0){
        if($redis->sAdd('lista',$uid)){
            echo 1;
        }else{
            echo "重复点击";
        }
    }else{
        echo "no uid";
    }
    if($num>=5){
        break;
    }
}
?>
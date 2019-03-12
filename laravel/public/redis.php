<?php
$redis=new \redis();
$redis->connect('192.168.43.239',6379);

$num=$redis->lPush('list','lmq');
//$redis->lPush('list',$a['4']['user_id']);
while(true){
    if($redis->sIsMember('lista','lmq')){
        echo $flag=1;
        break;
    }else{
        if($redis->sCard('lista')==5){
            if($redis->sIsMember('lista','lmq')){
                echo $flag=0;
                break;
            }else{
                echo $flag=1;
                break;
            }
        }
    }
}

?>
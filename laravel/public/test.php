<?php

$redis_obj=new Redis();
$redis_obj->connect('127.0.0.1','6379');
$redis_obj->auth('wty');
$redis_obj->select(2);
//var_dump($redis_obj->set('number',100));
$number=$redis_obj->get('number');
var_dump($number);

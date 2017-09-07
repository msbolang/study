<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './lib/config.php';
echo '<a target="_blank" href="https://github.com/phpredis/phpredis/">https://github.com/phpredis/phpredis/</a><br>';
echo 'string类型操作';
echo '<br>';
$redis->delete("str");
$redis->set("str",'我是str的值');
$val = $redis->get("str");
var_dump($val);
echo '<br>';
$redis->set("str2",2);
$redis->incr("str2",4);//把str2加2
$val2 = $redis->get("str2");
var_dump($val2);

echo '<br>';
echo '<br>';

echo 'redis操作list元素';
echo '<br>';
echo 'list元素 队列 先进先出，一般订单类常用 使用队列';
echo '<br>';
$redis->delete("list1");
$redis->lPush("list1",'A');  //lpush l代表左 左边插入 左边进 右边出 也就是先进先出 比如管道
$redis->lPush("list1",'B');
$redis->lPush("list1",'C');

$rs = $redis->rPop("list1");
$rs2 = $redis->rPop("list1");
$rs3 = $redis->rPop("list1");
$rs4 = $redis->rPop("list1");
var_dump($rs);
var_dump($rs2);
var_dump($rs3);
var_dump($rs4);
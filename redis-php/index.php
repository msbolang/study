<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './lib/config.php';
echo 'redis-php官方参考：<a target="_blank" href="https://github.com/phpredis/phpredis/">https://github.com/phpredis/phpredis/</a><br>';
echo '<hr>';



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



echo '<hr>';
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


echo '<hr>';
echo 'redis set类型操作';
echo '<br>';
$redis->delete("set1");
$redis->sAdd("set1","A");
$redis->sAdd("set1","B");
$redis->sAdd("set1","C");
$redis->sAdd("set1","C");//set操作数据因值只能唯一，所以此值无法set入

$val = $redis->sCard("set1");//统计数量
var_dump($val);
echo '<br>';
$val2 = $redis->sMembers("set1");//返回数组
echo '<pre>';print_r($val2);

echo '<hr>';
echo '哈希类型操作';
echo '<br>';
$redis->delete("driver1");
$redis->hSet("driver1",'name','李波');
$redis->hSet("driver1",'age',35);
$redis->hSet("driver1",'gender',1);
$val = $redis->hGet("driver1","name");
var_dump($val);
echo '<br>';
$val = $redis->hMGet("driver1",array("name","age"));
var_dump($val);

echo '<hr>';
echo 'sort set类型操作';
echo '<br>';
$redis->delete("zset1");
$redis->zAdd("zset1",100,"张三");
$redis->zAdd("zset1",80,"李四");
$redis->zAdd("zset1",60,"王五");
$redis->zAdd("zset1",95,"赵六");
$val = $redis->zRange("zset1",0,-1);//从低到高
echo '<pre>';print_r($val);

$val = $redis->zRevRange("zset1",0,-1);//从高到低 0代表键从0开始 -1代表最后的键
echo '<pre>';print_r($val);




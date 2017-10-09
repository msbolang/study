<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../lib/redisConfig.php';
$tool = new Tool();

if(($userInfo = $tool->getUser($redis))==false) header ("location:index.php");

$content = $tool->P("content");

if(!$content){
    $tool->echoError("提交的内容不能为空",'index');
}

$articleid = $redis->incr('global:articleid');

//普通存储方式
//$redis->set("post:articleid:" . $articleid . "userid:" , $userInfo['userid'] );
//$redis->set("post:articleid:" . $articleid . "release_time:" , time() );
//$redis->set("post:articleid:" . $articleid . "content:" , $content );

//哈希结构存储方式
$redis->hmset("post:articleid:$articleid",array(
    'username'=>$userInfo['username'],
    'userid'=>$userInfo['userid'],
    'content'=>$content,
    'time'=>time()
    ));


//给自己的粉丝推微博
$fans = $redis->smembers('follow:'.$userInfo['userid']);//查出我的粉丝 
$fans[] = $userInfo['userid']; //把自己也加入到推微博的队伍中
foreach($fans as $fansid) {
    $redis->lpush('recivepost:'.$fansid, $articleid); //给我的粉丝推微博
}


header("location:index.php");
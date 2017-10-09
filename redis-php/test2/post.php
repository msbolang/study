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
//新  拉模型
//1 每次发文 维护自己最新的20篇文章表
$redis->zadd("starpost:userid:".$userInfo['userid'],$articleid,$articleid);
if($redis->zcard("starpost:userid:".$userInfo['userid'])>20) {
    $redis->zremrangebyrank("starpost:userid:".$userInfo['userid'],0,0); //如果超过20个则左边开始第0个删除 
 //   Redis Zremrangebyrank 命令用于移除有序集中，指定排名(rank)区间内的所有成员。
}


//把自己的微博ID 放到一个链表里，自己看自己的微博使用
//1000个旧微博放到mysql里面
$redis->lpush("mypost:userid:".$userInfo['userid'],$articleid);//发布一条微博就吧微博ID插入到mypost:userid:用户id里面维护
if($redis->llen('mypost:userid:'.$userInfo['userid'])>10) {
    //如果自己的mypost:userid表里面的微博数量大于100
    $redis->rpoplpush('mypost:userid:'.$userInfo['userid'],'global:store');
    //把微博从mypost:userid表里面右边弹出 然后左边推入到global:store表里面 
    //global:store表复制维护所有人的旧微博
}



//推模型
////给自己的粉丝推微博
//$fans = $redis->smembers('follow:'.$userInfo['userid']);//查出我的粉丝 
//$fans[] = $userInfo['userid']; //把自己也加入到推微博的队伍中
//
//foreach($fans as $fansid) {
//    $redis->lpush('recivepost:'.$fansid, $articleid); //给我的粉丝推微博
//}



header("location:index.php");
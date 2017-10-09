<?php
include '../lib/redisConfig.php';
include 'header.php';

$tool = new Tool();
if(($userInfo = $tool->getUser($redis))==false)
        header("location:index.php");

$_uid = $tool->G("uid");
if(!$_uid) {
    $tool->echoError("非法访问！");
}
$f = $tool->G("f");

$_uname = $redis->get("user:userid:".$_uid.":username:");
if($f == '1'){

    $redis->sadd("following:".$userInfo['userid'], $_uid);//我关注ta
    $redis->sadd("follow:".$_uid, $userInfo['userid']);//我成为了他的粉丝 
}else{
       $redis->srem("following:".$userInfo['userid'],$_uid);//我取消关注ta
       $redis->srem("follow:".$_uid, $userInfo['userid']);//我取消成为了他的粉丝
}
header("location:profile.php?u=".$_uname);

?>

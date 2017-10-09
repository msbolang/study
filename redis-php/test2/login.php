<?php

include '../lib/redisConfig.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tool = new Tool();
$name = $tool->P("username");
$pwd = $tool->P("password");
if (!$name) {
    $tool->echoError("请填写用户名");
}
if (!$pwd) {
    $tool->echoError("请填写密码");
}

$userid = $redis->get("user:username:$name:userid:");
if (!$userid) {
    $tool->echoError("不存在此用户");
}

$userPWD = $redis->get("user:userid:$userid:userpwd:");
if ($userPWD != $pwd) {
    $tool->echoError("用户密码错误");
}

$userName = $redis->get("user:userid:$userid:username:");
if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['username'] = $userName;
$_SESSION['userid'] = $userid;


setCookie('username', $userName, time() + 3600);
setCookie('userid', $userid, time() + 3600);
$runStr = randsecret();
setCookie('auth', $runStr, time() + 3600);
$redis->set("user:userid:".$userid.":auth:",$runStr);
header("location:home.php");

  function randsecret(){
      $str = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
      return substr(str_shuffle($str),0,16); //str_shuffle打乱字符 截取16个字符串
  }
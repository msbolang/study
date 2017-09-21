<?php
include '../lib/redisConfig.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$name = require_info("username");
$pwd = require_info("password");
if(!$name){
    errorInfo("请填写用户名");
}
if(!$pwd){
    errorInfo("请填写密码");
}

$userid = $redis->get("username:$name:userid:");
if(!$userid){
    errorInfo("不存在此用户");
}

$userPWD = $redis->get("userid:$userid:userpwd:");
   if($userPWD!=$pwd){
      errorInfo("用户密码错误");
  }
  
  $userName = $redis->get("userid:$userid:username:");
  session_start();
  $_SESSION['username'] = $userName;
  $_SESSION['userid'] = $userid;
  header("location:home.php");
        

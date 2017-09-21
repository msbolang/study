<?php
/* 用户注册
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../lib/redisConfig.php';


//设计方式 
//set global incr 自增id 作为主键 
//set userid:1:username:libo
//set userid:1:userpasswd:123456
$name = require_info("username");
$pwd =  require_info("password");
$pwd2 = require_info("password2");


if($name && $pwd && $pwd2){
    if($pwd!=$pwd2) errorInfo ("两次密码不一致");
    
    if($redis->get("username:$name:userid:")){
        errorInfo("已存在此用户，请换个用户名注册");
    }
    
   $userid = $redis->incr('global:userid');
   $redis->set("userid:$userid:username:",$name);
   $redis->set("userid:$userid:userpwd:",$pwd);
   $redis->set("username:$name:userid:",$userid);
//   $_COOKIE['username'] = $name;
//   $_COOKIE['userid'] = $userid;
   session_start();
   $_SESSION['username']  = $name;
   $_SESSION['userid'] = $userid;
   header("location:home.php");
   
}else{
    errorInfo("请正确输入用户名和密码");
}





//检查post 的用户名和密码是否为空 
//两次密码是否一致
//用户名是否存在



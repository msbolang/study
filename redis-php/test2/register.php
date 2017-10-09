<?php
/* 用户注册
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../lib/redisConfig.php';
$tool = new Tool();

//设计方式 
//set global incr 自增id 作为主键 
//set userid:1:username:libo
//set userid:1:userpasswd:123456

$name = $tool->P("username");
$pwd =  $tool->P("password");
$pwd2 = $tool->P("password2");


if($name && $pwd && $pwd2){
    if($pwd!=$pwd2) $tool->echoError ("两次密码不一致");
    
    if($redis->get("username:$name:userid:")){
        $tool->echoError("已存在此用户，请换个用户名注册");
    }
    
   $userid = $redis->incr('global:userid');
   $redis->set("user:userid:$userid:username:",$name);
   $redis->set("user:userid:$userid:userpwd:",$pwd);
   $redis->set("user:username:$name:userid:",$userid);

   //维护50个最新用户
   $redis->lpush("newUserLink",$userid);
   $redis->ltrim("newUlerLink",0,49);
   
    if(!isset($_SESSION)){     session_start();    }

   $_SESSION['username']  = $name;
   $_SESSION['userid'] = $userid;
   header("location:home.php");
   
}else{
   $tool->echoError("请正确输入用户名和密码");
}





//检查post 的用户名和密码是否为空 
//两次密码是否一致
//用户名是否存在



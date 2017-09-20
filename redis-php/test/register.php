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

var_dump($name);
var_dump($pwd);
var_dump($pwd2);
if($name && $pwd && $pwd2){
    if($pwd!=$pwd2) errorInfo ("两次密码不一致");
    
   $userid = $redis->incr('global:userid');

   $redis->set("userid:$userid:username:",$name);
   $redis->set("userid:$userid:userpwd:",$pwd);
   $redis->set("username:$name:userid:",$userid);
   
}else{
    errorInfo("请正确输入用户名和密码");
}





//检查post 的用户名和密码是否为空 
//两次密码是否一致
//用户名是否存在



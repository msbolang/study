<?php
include '../lib/redisConfig.php';
include 'header.php';

$tool = new Tool();
if(($userInfo = $tool->getUser($redis))==false)
        header("location:index.php");

$u = $tool->G("u");
if(!$u) {
    $tool->echoError("非法访问！");
}
$_uid = $redis->get("user:username:".$u.":userid:");
if(!$_uid) {
     $tool->echoError("非法用户！");
}
$isFollow = $redis->sIsMember("following:".$userInfo['userid'],$_uid);//查询 u用户
$status = $isFollow?'0':"1";
$info  =  $isFollow?'取消关注':"关注ta";

?>
<h2 class="username"><?=$u?></h2>

<a href="follow.php?uid=<?=$_uid?>&f=<?=$status?>" class="button"><?=$info?></a>

<div class="post">
<a class="username" href="profile.php?u=test">test</a> 
world<br>
<i>11 分钟前 通过 web发布</i>
</div>

<div class="post">
<a class="username" href="profile.php?u=test">test</a>
hello<br>
<i>22 分钟前 通过 web发布</i>
</div>
<?php 
 include 'footer.php';?>
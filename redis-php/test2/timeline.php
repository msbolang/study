<?php 
include '../lib/redisConfig.php';
include 'header.php';
$tool = new Tool();
if(($userInfo = $tool->getUser($redis))==false)
        header("location:index.php");
$newUserList = array();
$newUserList =$redis->sort("newUserLink",array("sore"=>"desc","get"=> "user:userid:*:username:"));

?>
<h2>热点</h2>
<i>最新注册用户(redis中的sort用法)</i><br>

<div>
    <?php foreach ($newUserList as $v){ ?>
    <a class="username" href="profile.php?u=<?=$v?>"><?=$v?></a> 
<?php } ?>
</div>

<br><i>最新的50条微博!</i><br>
<div class="post">
<a class="username" href="profile.php?u=test">test</a>
world<br>
<i>22 分钟前 通过 web发布</i>
</div>

<div class="post">
<a class="username" href="profile.php?u=test">test</a>
hello<br>
<i>22 分钟前 通过 web发布</i>
</div>
<?php 
include 'footer.php';
?>
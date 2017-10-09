<?php
include '../lib/redisConfig.php';
include 'header.php';

$tool = new Tool();
if(($userInfo = $tool->getUser($redis))==false)
        header("location:index.php");

          
$gz_num = $redis->scard("following:".$userInfo['userid']);  
$fs_num = $redis->scard("follow:".$userInfo['userid']);  

//截取推送过来的微博， 只要50个
 $redis->ltrim('recivepost:'.$userInfo['userid'],0,49); //从左边截取
 //普通关联查询文章内容 缺点是一个个字段查
// $newPoster = $redis->sort('recivepost:'.$userInfo['userid'],array(
//     'sort'=>"desc",
//     'get'=>"post:articleid:*content:" 
//     ));

 //哈希结构数据查询开始
 //先查询推送表里面的所有文章ID 
 $newPoster = $redis->sort('recivepost:'.$userInfo['userid'],array(
     'sort'=>"desc"
     ));
 
 
 
 
 
?>
<div id="postform">
<form method="POST" action="post.php">
<?=$userInfo['username']?>, 有啥感想?
<br>
<table>
<tr><td><textarea cols="70" rows="3" name="content"></textarea></td></tr>
<tr><td align="right"><input type="submit" name="doit" value="commit"></td></tr>
</table>

</form>
<div id="homeinfobox">
<?=$fs_num?> 粉丝<br>
<?=$gz_num?> 关注<br>
</div>
</div>

<!--循环文章ID 查询哈希结构的文章数据-->
<?php if(!empty($newPoster)){ 
    foreach ($newPoster as  $value) {
        $p = $redis->hmget("post:articleid:$value",array("username","userid","time","content"));
        ?>
    
<div class="post">
    
<a class="username" href="profile.php?u=<?=$p['username']?>"><?=$p['username']?></a> <?=$p['content']?><br>
<i><?php echo Tool::_formatime($p['time']);?> 通过 web发布</i>
</div>



<?php } } ?>



<?php
include 'footer.php';
?>
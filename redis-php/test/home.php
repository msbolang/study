<?php
include '../lib/redisConfig.php';
include 'header.php';
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['userid'])){
    $name = $_SESSION['username'];
    $userId = $_SESSION['userid'];
}else{
  
  header("location:index.php");
}

?>
<div id="postform">
<form method="POST" action="post.php">
<?=$name?>, 有啥感想?
<br>
<table>
<tr><td><textarea cols="70" rows="3" name="status"></textarea></td></tr>
<tr><td align="right"><input type="submit" name="doit" value="Update"></td></tr>
</table>
</form>
<div id="homeinfobox">
0 粉丝<br>
0 关注<br>
</div>
</div>
<div class="post">
<a class="username" href="profile.php?u=test">test</a> hello<br>
<i>11 分钟前 通过 web发布</i>
</div>

<?php
include 'footer.php';
?>
<?php
//定时任务每隔几秒执行 把redis里面的旧数据写入到mysql里面
//redisToMysql.php
include '../lib/redisConfig.php';


$pdo = new PDO('mysql:host=127.0.0.1;dbname=redis_to_mysql','root','123');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,FALSE);//不检查数据类型



   $sql = 'INSERT INTO `redis_to_mysql`.`article` (`id`,`articleid`,`userid`,`username`,`content`,`time`) VALUES';
     
   $i = 0;
   var_dump($redis->llen('global:store'));
   while($redis->llen('global:store') && $i<2 ) {
       $i++;
       $postid = $redis->rpop('global:store');
       $post = $redis->hmget('post:articleid:'.$postid,array('userid','username','time','content'));
       $sql .=" (null,".$postid.",'".$post['userid']."','".$post['username']."','".$post['content']."','".$post['time']."'),";
  
   }
   if($i == 0){
       echo 'no job';exit;
   }
      $sql = substr($sql,0,strlen($sql)-1); //删除最后的逗号
echo $sql;
if($pdo->exec($sql)){ 
        echo "插入成功！"; 
        echo $pdo->lastinsertid();
}
     



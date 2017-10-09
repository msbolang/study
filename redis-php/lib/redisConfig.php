<?php

  $redis = new \Redis();
  $redis->connect("127.0.0.1",6379);
  $redis->auth('123');  //认证
  include 'tool.php';

  /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */





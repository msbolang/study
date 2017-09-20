<?php
  $redis = new \Redis();
  $redis->connect("127.0.0.1",6379);
  /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  function require_info($name) {
      if(isset($_POST[$name]) && !empty($_POST[$name])){
          return $_POST[$name];
      }else{
          return false;
      }
  }
  
  function errorInfo($info){
      if($info){
        echo $info;
      }
      exit;
  }


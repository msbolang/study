<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

  if(!isset($_SESSION)){     session_start();    }
    unset($_SESSION['username']);
    unset($_SESSION['userid']);
    
    setcookie('username','',-1);
    setcookie('userid','',-1);
    setcookie('auth','',-1);
    
header("location:index.php");
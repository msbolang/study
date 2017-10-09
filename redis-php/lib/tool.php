<?php

/* 
 * 我的工具 2017-09-22 23.53 李波 php工程师 qq:965556835
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Tool{
        
    /**
     * 
     * @param type $param
     * @return boolean 
     */
    public function G($param) {
      if(isset($_GET[$param]) && !empty($_GET[$param])){
          return $_GET[$param];
      }else{
          return false;
      }
    }
    
    /**
     * 
     * @param type $name
     * @return boolean
     */
    public function P($name) {
      if(isset($_POST[$name]) && !empty($_POST[$name])){
          return $_POST[$name];
      }else{
          return false;
      }
  }
  /**
   * 
   * @param type $info
   */
  public function echoError($info,$route=''){
      if($info){
        echo $info;
      }
      if($route) {
       echo "<form style='display:none;' id='error_form' name='error_form' method='post' action='./error.php'>
              <input name='error_info' type='text' value='{$info}'/>
              <input name='route' type='text' value='{$route}'/>
            </form>
            <script type='text/javascript'>function error_form_submit(){document.error_form.submit()}error_form_submit();</script>";
      }
      exit;
  }
  
  public function getUser($redis) {
      
      $_arr = array();
      if(!isset($_SESSION)){
             session_start();
        }
      if(isset($_SESSION['userid']) && isset($_SESSION['username'])) {
          $_arr['username'] = $_SESSION['username'];
          $_arr['userid'] = $_SESSION['userid'];
          
          if(!isset($_COOKIE['auth'])){
             header("location:logout.php");
              exit;
          }
          $auth = $redis->get("user:userid:".$_arr['userid'].":auth:");
          if($auth!=$_COOKIE['auth']) {

              header("location:logout.php");
              exit;
          }
          
          
          return $_arr;
      }
      return false;
  }
  
  /**
   * 格式化时间
   */
  public static function _formatime($time){
 
      if(!$time){return '';};
      $sec = time() - $time;
      if($sec>=86400){
          return floor($sec/86400).'天';
      }else if($sec >= 3600){
          return floor($sec/3600).'小时';
      }else if($sec >= 60){
          return floor($sec/60).'分钟';
      }else{
          return $sec . '秒';
      }
  }

  
}
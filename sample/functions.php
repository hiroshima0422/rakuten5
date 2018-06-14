<?php


//SESSIONチェック＆リジェネレイト
function chk_ssid(){
  if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
    exit("Login Error.");
  }else{
    session_regenerate_id(true);
    $_SESSION["chk_ssid"]=session_id();
  }
}
?>

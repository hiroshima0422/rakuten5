<?php

# checkInput()関数を読み込みます。
require_once dirname(__FILE__).'/../lib/checkInput.php';


//require_once './error_fun.php';

# POSTされたデータをチェックします。
$_POST = checkInput($_POST);

# クリックジャッキング対策（クリックジャッキングとは？）をします。
header('X-FRAME-OPTIONS: SAMEORIGIN');

# セッションを開始します。
session_start();
header('Expires:'); 
header('Cache-Control:');
header('Pragma:');

//0.外部ファイル読み込み
include("functions.php");

//var_dump($_POST);


//フラグ初期化
//kanri_ﬂg
//ユーザー未登録　　0 
//ユーザー登録済み　1 
$kanri_flg = isset($_SESSION['kanri_flg']) ? $_SESSION['kanri_flg'] : 0;
//life_flg
//使用中　　　　　　0
//使用しなくなった　1
$life_flg = isset($_SESSION['life_flg']) ? $_SESSION['life_flg'] : 1;

//if($kanri_flg === 1 && $life_flg === 0){
if($life_flg === 0){
  header("Location: okini.php"); 
  //exit(); 
}else{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>新規登録</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>
<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <h1><a href="index.php">Rakuten Web Service SDK</a></h1>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php 
					
					if($kanri_flg == 1){ 
					
					?>
                        <li>
                            <a href="">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                アイテムを追加
                            </a>
                        </li>
                       
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="gravatar">
                                    <img src="" alt="" class="img-circle">
                                </span>
                               <?php echo $name ?>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="">マイページ</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <form action="logout.php" method="post" class="form-horizontal">
                  
                      <button type="submit" name="logout" class="btn btn-default">ログアウト</button></form>
                                </li>
                            </ul>
                        </li>
                    <?php 
					
					}else{
					
					?>
                        <li><form action="register" method="post" class="form-horizontal">
                  
                      <button type="submit" name="register" class="btn btn-default">登録</button>
                    
                </form></li>
                        <li><form action="login.php" method="post" class="form-horizontal form_padding">
                  
                      <button type="submit" name="login" class="btn btn-default">ログイン</button></form></li>
                   <?php 
					
					} 
					
					?>
                </ul>
            </div>
        </div>
    </nav>
</header>

       

        <div class="container">
            <div class="row">
    <div class="col-xs-offset-3 col-xs-6">
        <div class="panel panel-default">
            <div class="panel-heading">新規登録</div>
            <div class="panel-body">
            <form action="register_act.php" method="post" class="form-horizontal">
                  <!-- form-groupが1行（row）を表す -->
                  <div class="form-group">
                    <label class="col-xs-2 control-label">名前</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" name="name">
                    </div>
                  </div>
                
                  <!-- 1行 -->
                  <div class="form-group">
                    <label class="col-xs-2 control-label">ID</label>
                    <div class="col-xs-10">
                  <input type="text" class="form-control"  name="lid">
                    </div>
                  </div>
                  
                  <!-- 1行 -->
                  <div class="form-group">
                    <label class="col-xs-2 control-label">パスワード</label>
                    <div class="col-xs-10">
                  <input type="password" class="form-control" name="lpw">
                    </div>
                  </div>
                
                  <!-- 1行 -->
                  <div class="form-group">
                    <div class="col-xs-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">登録</button>
                    </div>
                  </div>
                </form>
            
                
            </div>
        </div>
    </div>
</div>
        </div>

        
    </body>
</html>

<?php
	exit();
}
?>
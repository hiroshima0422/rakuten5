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

$name = isset($_POST['name']) ? $_POST['name'] : NULL;

$lid = isset($_POST['lid']) ? $_POST['lid'] : NULL;
$lpw = isset($_POST['lpw']) ? $_POST['lpw'] : NULL;
//フラグ初期化
//kanri_ﬂg
//ユーザー未登録　　0 
//ユーザー登録済み　1 
$kanri_flg = isset($_SESSION['kanri_flg']) ? $_SESSION['kanri_flg'] : 0;
//life_flg
//使用中　　　　　　0
//使用しなくなった　1
$life_flg = isset($_SESSION['life_flg']) ? $_SESSION['life_flg'] : 1;

//1.  DB接続します
//$pdo = db_con();
require_once __DIR__ . '../../../conf/database_conf.php';
							
//var_dump($botan);							  
							# MySQLデータベースに接続します。
							  $db = new PDO($dsn, $dbUser, $dbPass);
							  



/*//2. データ登録SQL作成
$stmt = $db->prepare("SELECT * FROM gs_user_table WHERE lid=:lid AND lpw=:lpw");
$stmt->bindValue(':lid', $lid);
$stmt->bindValue(':lpw', $lpw);
$res = $stmt->execute();
var_dump($res);

//3. SQL実行時にエラーがある場合
if($res==false){
  queryError($stmt);
}

//4. 抽出データ数を取得
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
$val = $stmt->fetch(); //1レコードだけ取得する方法
var_dump($val);
var_dump($val["lid"]);*/
//5. 該当レコードがあればSESSIONに値を代入
//if( $val["id"] != "" ){
  $sql = 'INSERT gs_user_table(id,name,lid,lpw,kanri_flg,life_flg) VALUES (NULL,:name,:lid,:lpw,:kanri_flg,:life_flg)';

$prepare = $db->prepare($sql);

								  $prepare->bindValue(':name', $name, PDO::PARAM_STR);
								  $prepare->bindValue(':lid', $lid, PDO::PARAM_STR);
								  $prepare->bindValue(':lpw', $lpw, PDO::PARAM_STR);
								  $prepare->bindValue(':kanri_flg', 1, PDO::PARAM_STR);
								  $prepare->bindValue(':life_flg', 0, PDO::PARAM_STR);
								  
								  
								  
$st = $prepare->execute();
//var_dump($st);
if( $st == true){
	  $_SESSION["chk_ssid"]  = session_id();
	  $_SESSION["kanri_flg"] = 1;
	  $_SESSION["life_flg"] = 0;
	  $_SESSION["name"]      = $name;
	  header("Location: okini.php");
  
  
}else{
  //logout処理を経由して全画面へ
  header("Location: register.php");
}

exit();
?>


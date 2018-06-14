<?php

require_once dirname(__FILE__).'/../autoload.php';

require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/helper.php';

//require_once '/func.php';
//var_dump($_POST);
$id = "";
if(isset($_POST)==true)
{
	//どのボタンを押したかチェック
	for($i=0;$i<100;$i++)
		{
			if(isset($_POST['btn_'.$i])==true)
			{
				$id = $i;
/*					  	print '<br>';
        print '$botan:'.$botan;
        print '<br>';
*/
				break;
			}		
		}
}

//var_dump($botan);
//$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
//$ac_code = isset($_POST['ac_code']) ? $_POST['ac_code'] : 1;


?>




<?php 

//*************************************
//お気に入り
//2. DB接続します

//var_dump($id);
require_once __DIR__ . '../../../conf/database_conf.php';
					
					  
					# MySQLデータベースに接続します。
					  $db = new PDO($dsn, $dbUser, $dbPass);
					  
$stmt = $db->prepare("DELETE FROM gs_bm_table WHERE id=:id");
$stmt->bindValue(':id', $id);
$status = $stmt->execute();
			  


$sql='SELECT * FROM gs_bm_table';
	$prepare = $db->prepare($sql);
	$result = $prepare->execute();					  
					  
					  
					  

	
	//$prepare = null;


//３．データ表示
$view="";
if($result==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $prepare->errorInfo();
  exit("ErrorQuery:".$error[2]); //配列index[2]にエラーコメントあり 

}else{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Rakuten Web Service SDK</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="style.css" type="text/css">
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
                <h1><a href="">Rakuten Web Service SDK お気に入り一覧</a></h1>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php 
					
					if($kanri_flg == 1){ 
					
					?>
                        <li>
                            <a href="../realtime-chat/index">お気に入りチャットルーム</a>
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
                        <li><form action="register.php" method="post" class="form-horizontal">
                  
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

<div id="itemarea">
<form action="delete.php" method="post">
<ul id="itemlist">
<?php	
	
	
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $re = $prepare->fetch(PDO::FETCH_ASSOC)){ 
    //$view  .= '<p>';           
	//$view  .= $result["indate"] ."：". $result["name"] ;           
	//$view .= '</p>'; 
	//var_dump($result);
?>	
	<li class="item">

<a href="<?php echo h($re['affiliateurl']) ?>" class="itemname" title="<?php echo h($re['book_name']) ?>">
<?php echo h(mb_strimwidth($re['book_name'], 0, 80, '...', 'UTF-8')) ?></a>

<ul>
<?php if (!empty($re['imageurl'])): ?>
<li class="image"><img src="<?php echo h($re['imageurl']) ?>"></li>
<?php endif; ?>

<li class="price"><?php echo h(number_format($re['itemprice'])) ?>円</li>
<li class="description"><?php echo h($re['book_coment']) ?></li>
<li class="">

<input type="submit" name="btn_<?=$re["id"]?>" value="お気に入り削除"></li>
</ul>
</form>

<?php
  }




}			

 ?>













</body>
</html>

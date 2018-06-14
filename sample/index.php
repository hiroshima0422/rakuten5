<?php

require_once dirname(__FILE__).'/../autoload.php';

require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/helper.php';

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

require_once dirname(__FILE__).'/functions.php';

//フラグ初期化
//kanri_ﬂg
//ユーザー未登録　　0 
//ユーザー登録済み　1 
$kanri_flg = isset($_SESSION['kanri_flg']) ? $_SESSION['kanri_flg'] : 0;
//life_flg
//使用中　　　　　　0
//使用しなくなった　1
$life_flg = isset($_SESSION['life_flg']) ? $_SESSION['life_flg'] : 1;

//$_SESSION['kanri_flg']=1;
//$_SESSION['life_flg']=0;
$_SESSION['kanri_flg']=0;
$_SESSION['life_flg']=1;
//$kanri_flg = isset($_SESSION['kanri_flg']) ? $_SESSION['kanri_flg'] : 1;

		
$response = null;
$keyword  = "";
$page     = 1;
if (isset($_GET['keyword'])) {
    $keyword   = $_GET['keyword'];
    $page      = isset($_GET['page']) ? $_GET['page'] : 1;

    // Clientインスタンスを生成 Make client instance
    $rwsclient = new RakutenRws_Client();
    // アプリIDをセット Set Application ID
    $rwsclient->setApplicationId(1031677992385383126);
    // アフィリエイトIDをセット (任意) Set Affiliate ID (Optional)
    $rwsclient->setAffiliateId(RAKUTEN_APP_AFFILITE_ID);

    // プロキシの設定が必要な場合は、ここで設定します。
    // If you want to set proxy, please set here.
    // $rwsclient->setProxy('proxy');

    // 楽天市場商品検索API2 で商品を検索します
    // Search by IchibaItemSearch (http://webservice.rakuten.co.jp/api/ichibaitemsearch/)
    $response = $rwsclient->execute('IchibaItemSearch', array(
        'keyword' => $keyword,
        'page'    => $page,
        'hits'    => 9
    ));
}

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
                <h1><a href="index.php">Rakuten Web Service SDK</a></h1>
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

<div class="search-form">

<form action="index.php" method="GET">
<input id="keyword" class="keyword" name="keyword" type="text" value="<?php echo h($keyword) ?>">
<input type="submit" class="search-button" value="検索">
</form>
</div>



<?php if ($response && $response->isOk()): ?>

<div class="pager"><?php echo $pager = pager(
    (int)$page,
    (int)$response['pageCount'],
    '?keyword=%s&amp;page=%d',
    $keyword
) ?></div>

<div id="itemarea">
<form action="okini.php" method="post">
<ul id="itemlist">
<?php
 $i = 0;
 $ites = array();
foreach ($response as $item): 
	$ites[$i]['itemName'] = $item['itemName'];
	$ites[$i]['imageUrl'] = $item['smallImageUrls'][0]['imageUrl'];
	$ites[$i]['itemPrice'] = $item['itemPrice'];
	$ites[$i]['itemCaption'] = $item['itemCaption'];

if ($i == 1){
	//var_dump($item['itemName']);
	//var_dump($item['itemUrl']);
	//$item->name = $rws_item['Item']['itemName'];
                //$item->url = $rws_item['Item']['itemUrl'];
}
$i += 1;

?>
<li class="item">

<a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" title="<?php echo h($item['itemName']) ?>">
<?php echo h(mb_strimwidth($item['itemName'], 0, 80, '...', 'UTF-8')) ?></a>

<ul>
<?php if (!empty($item['smallImageUrls'][0]['imageUrl'])): ?>
<li class="image"><img src="<?php echo h($item['smallImageUrls'][0]['imageUrl']) ?>"></li>
<?php endif; ?>
<li class=""><input type="submit" name="btn_<?php echo $i;?>" value="お気に入りボタン"></li>

<li class="price"><?php echo h(number_format($item['itemPrice'])) ?>円</li>
<li class="description"><?php echo h($item['itemCaption']) ?></li>
</ul>

</li>
<?php endforeach; 
//var_dump($ites);
?>
</ul>
<input type="hidden" name="keyword" value="<?php echo $keyword;?>">
<input type="hidden" name="page" value="<?php echo $page;?>">

</form>
</div>
<div class="pager"><?php echo $pager ?></div>
<?php endif; ?>

<?php

if($life_flg == 0){ 
		//*************************************
		//お気に入り
		//2. DB接続します
		
		
		require_once __DIR__ . '../../../conf/database_conf.php';
							
							  
							# MySQLデータベースに接続します。
							  $db = new PDO($dsn, $dbUser, $dbPass);
		 
		
		//***************************
		//お気に入りデータを呼び出し
		
			
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
		
		
		
		<div id="itemarea">
        <h2>お気に入り</h2>
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
}
 ?>


</body>
</html>

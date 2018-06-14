<?php
//$_POST = checkInput($_POST);
var_dump($_POST);


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Rakuten Web Service SDK - Sample</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<header>
<h1><a href="index.php">Rakuten Web Service SDK</a></h1>
</header>

<nav class="search-form">

<form action="index.php" method="GET">
<input id="keyword" class="keyword" name="keyword" type="text" value="<?php echo h($keyword) ?>">
<input type="submit" class="search-button" value="検索">
</form>
</nav>

<?php  ?>
<div class="notice">
ブックマークへ追加しました
</div>
<?php  ?>

<?php  ?>

<div class="pager"><?php  ?></div>

<div id="itemarea">
<form action="" method="">
<ul id="itemlist">
<?php
 $i = 0;
 $ites = array();
foreach ($response as $item): 
	$ites[$i]['itemName'] = $item['itemName'];
	$ites[$i]['imageUrl'] = $item['smallImageUrls'][0]['imageUrl'];
	$ites[$i]['itemCaption'] = $item['itemCaption'];
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
<li class=""><button class="button" type="submit"id="btn_<?php echo $i;?>">お気に入りボタン</button>
</li>
<li class="price"><?php echo h(number_format($item['itemPrice'])) ?>円</li>
<li class="description"><?php echo h($item['itemCaption']) ?></li>
</ul>

</li>
<?php endforeach; ?>
</ul>
</form>
</div>
<div class="pager"><?php echo $pager ?></div>
<?php ?>

</body>
</html>

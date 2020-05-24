<?php
session_start();
require('../db.php');

// if(!isset($_SESSION['join'])){
// 	header('Location:index.php');
// }

if(!empty($_POST)){
	$statement = $db->prepare('INSERT INTO members SET name=?,email=?,password=?,created=NOW()');
	$statement->execute(array(
		$_SESSION['join']['name'],
		$_SESSION['join']['email'],
		$_SESSION['join']['password']
		// $_SESSION['join']['image']
	));
	unset($_SESSION['join']);
	header('Location:kannryou.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員登録</title>

	<link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<div id="wrap">
<div id="head">
<h1>会員登録</h1>
</div>

<div id="content">
<h2>確認</h2>
<form action="" method="post">
	<input type="hidden" name="action" value="submit" />
	<dl>
		<dt>名前</dt>
		<dd>
		<?php print(htmlspecialchars($_SESSION['join']['name'],ENT_QUOTES));?>
        </dd>
		<dt>メールアドレス</dt>
		<dd>
		<?php print(htmlspecialchars($_SESSION['join']['email'],ENT_QUOTES));?>
        </dd>
		<dt>パスワード</dt>
		<dd>
		【表示されません】
		</dd>
		
	</dl>
	<div><a class="button" href="index.php?action=rewrite">&laquo;&nbsp;変更</a> |<input class="button" type="submit" value="登録する" /></div>
</form>
</div>

</div>
</body>
</html>
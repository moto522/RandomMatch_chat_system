<?php
session_start();
require('../db.php');

if(!empty($_POST)){
	if($_POST['name']===''){
		// print('名前が入力されていません');
		$error['name']='blank';
	}
	if($_POST['email']===''){
		// print('名前が入力されていません');
		$error['email']='blank';
	}
	if(strlen($_POST['password'])<4){
		$error['password']='length';
	}
	if($_POST['password']===''){
		// print('名前が入力されていません');
		$error['password']='blank';
    }

	//重複チェック
	if(empty($error)){
		$member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
		$member->execute(array($_POST['email']));
		$record = $member->fetch();
		if($record['cnt']>0){
			$error['email']='duplicate';
		}

    }
    if(empty($error)){
		$_SESSION['join']=$_POST;
		header('Location:check.php');
		exit();
	}

}
if($_REQUEST['action']=='rewrite'){
	$_POST=$_SESSION['join'];
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>新規登録</title>

	<link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<div id="wrap">
<div id="head">
<h1>新規登録</h1>
</div>

<div id="content">
<form action="" method="post" enctype="multipart/form-data">
	<dl>
		<dt>名前<span class="required"> </span></dt>
		<dd>
        	<input id="text1" type="text" name="name" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['name'],ENT_QUOTES));?>" />
			<?php if($error['name']==='blank'): ?>
			<p class="error">名前を入力してください</p>
			<?php endif;?>
		</dd>
		<dt>メールアドレス<span class="required"> </span></dt>
		<dd>
        	<input id="text1" type="text" name="email" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['email'],ENT_QUOTES));?>" />
			<?php if($error['email']==='blank'): ?>
			<p class="error">メールアドレスを入力してください</p>
			<?php endif;?>
			<?php if($error['email']==='duplicate'): ?>
			<p class="error">登録済みのメールアドレス</p>
			<?php endif;?>
		<dt>パスワード<span class="required"> </span></dt>
		<dd>
        	<input id="text1" type="password" name="password" size="10" maxlength="20" value="<?php print(htmlspecialchars($_POST['password'],ENT_QUOTES));?>" />
			<?php if($error['password']==='blank'): ?>
			<p class="error">パスワードを入力してください</p>
			<?php endif;?>
			<?php if($error['password']==='length'): ?>
			<p class="error">パスワードが少ない</p>
			<?php endif;?>
        </dd>
	</dl>
	<div><input class="button" type="submit" value="入力内容を確認する" /></div>
</form>
</div>
</body>
</html>

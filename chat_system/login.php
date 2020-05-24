<?php
session_start();
require('db.php');

if($_COOKIE['email']!==''){
  $email=$_COOKIE['email'];
}

if(!empty($_POST)){
  $email=$_POST['email'];
  
  if($_POST['email'] !=='' && $_POST['password']!==''){
    $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      $_POST['password']
    ));
    // ////////
    // $login->debugDumpParams();
    // var_dump($login->errorInfo());
    // exit();
    // ////////
    $member = $login->fetch();
    if($member){
      $_SESSION['id']=$member['id'];
      $_SESSION['time'] = time();

      if($_POST['save']==='on'){
        setcookie('email',$_POST['email'],time()+60*60*24*14);
      }

      header('Location:index.php');
      exit();
    }else{
      $error['login']='failed';
    }
  }else{
    $error['login']='blank';
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<title>ログインする</title>
</head>

<body>
<div id="wrap">
  <div id="head">
    <h1>Random chat system</h1>
  </div>
  <div id="content">
    <div id="lead">
      <h2>ログイン</h2>
      <p>&raquo;<a href="join/">新規登録</a></p>
    </div>
    <form action="" method="post">
      <dl>
        <dt>メールアドレス</dt>
        <dd>
          <input id="text1" type="text" name="email" size="35" maxlength="255" value="<?php print(htmlspecialchars($email,ENT_QUOTES));?>" />
          <?php if($error['login']==='blank'):?>
          <p class="error">エラー</p>
          <?php endif;?>
        </dd>
        <dt>パスワード</dt>
        <dd>
          <input id="text1" type="password" name="password" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['password'],ENT_QUOTES));?>" />
          <?php if($error['login']==='failed'):?>
          <p class="error">ログインに失敗</p>
          <?php endif;?>
        </dd>
        <dt>ログイン情報の記録</dt>
        <dd>
          <input id="save" type="checkbox" name="save" value="on">
          <label for="save">自動ログイン</label>
        </dd>
      </dl>
      <div>
      <input class="button" type="submit" value="ログインする" />
        <!-- <p><a href="index.php">ログイン</a></p> -->
      </div>
    </form>
  </div>
</div>
</body>
</html>

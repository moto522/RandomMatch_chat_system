<?php
session_start();
require('db.php');
if(isset($_SESSION['id'])&& $_SESSION['time']+3600>time()){
    $_SESSION['time']=time();
    $members = $db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();
}else{
    header('Location:login.php');
    exit();
}

if(!empty($_POST)){

    if($_POST['message']!==''){
        $chatmembers=$db->prepare('SELECT * FROM members WHERE id=?');
        $chatmembers->execute(array($_SESSION['id']));
        $chatmember=$chatmembers->fetch();
        
  
      $message = $db->prepare('INSERT INTO posts SET I=?,you=?,message=?,created=NOW()');
      $message->execute(array(
        $_SESSION['id'],
        $chatmember['you_id'],
        $_POST['message'],
      ));
      header('Location:talkroom.php');
      exit();
    }
  }

    $posts = $db->prepare('SELECT * FROM posts WHERE (I=? AND you=?)OR(I=? AND you=?)');
    // $posts->execute(array($_SESSION['id'],$_SESSION['you_id'],$_SESSION['you_id'],$_SESSION['id']));
    $posts->execute(array($member['id'],$member['you_id'],$member['you_id'],$member['id']));

  print('Talk room');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style2.css" />
    <title>Talk room</title>
</head>
<body>
    <form action="" method="post">
        <textarea class="text" name="message" cols="50" rows="5"><?php print(htmlspecialchars($message,ENT_QUOTES));?></textarea><br>
        <input class="button" type="submit" value="送信" />
    <form>
    <p></p>
    <div><a class="button" href="index.php">mypageに戻る</a></div>
    <?php foreach($posts as $post):?>
    <?php
    
    if($post['I']===$_SESSION['id']){
        $ccoms=$db->prepare('SELECT * FROM members WHERE id=?');
        $ccoms->execute(array($member['id']));
        $ccom=$ccoms->fetch();
        $chat=$ccom['name'];
    }else{
        $ccoms=$db->prepare('SELECT * FROM members WHERE id=?');
        $ccoms->execute(array($member['you_id']));
        $ccom=$ccoms->fetch();
        $chat=$ccom['name'];
    }
    ?>
    <p class="talk"><?php print($chat);?> : <?php print(htmlspecialchars($post['message'],ENT_QUOTES));?></p>
    <?php endforeach;?>
</body>
</html>
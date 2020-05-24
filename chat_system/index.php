
<?php
session_start();
require('db.php');

if(isset($_SESSION['id'])&& $_SESSION['time']+3600>time()){
  $_SESSION['time']=time();
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member=$members->fetch();
//   var_dump($member);
}else{
  header('Location:login.php');
  exit();
}
$count=0;
$kid=0;
$modoru='';
if(!empty($_POST)){

    $members2 = $db->prepare('SELECT * FROM members WHERE id=?');
    $members2->execute(array($_SESSION['id']));
    $member2=$members2->fetch();
    if($member2['room_on']==0){

        // $mlists=$db->prepare('SELECT * FROM members ORDER BY modified desc');
        $mlists = $db->prepare('SELECT * FROM members WHERE match_on_off=1 AND id!=? ORDER BY modified asc');
        // $count = $db->query('SELECT COUNT(*) FROM members WHERE match_on_off=1 AND ORDER BY modified asc');

        $mlists->execute(array($_SESSION['id']));
        // $mlists->execute(array());

        while($mlist = $mlists->fetch()){
            print($mlist['name'] . "\n");
            $count=$count+1;
            $kid=$mlist['id'];
        }
        $members = $db->prepare('UPDATE members SET match_on_off=1 WHERE id=?');
        $members->execute(array($_SESSION['id']));
        print("kid:".$kid."\n");
        // print($count);
        if($count>0){
            $_SESSION['you_id']=$kid;
            $you_chat=$db->prepare('UPDATE members SET room_on=1 ,you_id=? WHERE id=?');
            $you_chat->execute(array($_SESSION['id'],$kid));
            $my_chat=$db->prepare('UPDATE members SET match_on_off=0 ,you_id=? WHERE id=?');
            $my_chat->execute(array($kid,$_SESSION['id']));
            header('Location:talkroom.php');
            exit();
        }else{
            print('相手がいません');
        }

       }else{
        $kousinns=$db->prepare('UPDATE members SET match_on_off=0,room_on=0 WHERE id=?');
        $kousinns->execute(array($_SESSION['id']));
        header('Location:talkroom.php');
        exit();
    }


    

}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <title>my page</title>
</head>
<body>
<p><?php print(htmlspecialchars($member['name'],ENT_QUOTES));?>さんのページ</p>
<a href=index.php><?php print($modoru)?></a>
<!-- <div><input type="submit" value="接続" /></div> -->
<form action="" method="post">
    <!-- <p><a href="talkroom.php">接続</a></p> -->
    <input class="button" type="submit" name="action" value="接続" />
</form>
<p></p>
<div><a class="button" href="logout.php">ログアウト</a></div>
</body>
</html>
<?php
try{
    $db = new PDO('mysql:dbname=chat;host=127.0.0.1;charset=utf8','root','');
}catch(PDOException $e){
    print('エラー'.$e->getMessage());
}
?>
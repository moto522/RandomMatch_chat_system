<?php
session_start();
require("db.php");
$members = $db->prepare('UPDATE members SET you_id=0 WHERE id=?');
$members->execute(array($_SESSION['id']));

$_SESSION = array();
if(ini_set('session.use_cookies')){
    $params=session_get_cookie_params();
    setcookie(session_name().'',time()-42000,$params['path'],$params['domain'],$params['secure'],$params['httponly']);
}
session_destroy();
setcookie('email','',time()-3600);

header('Location:login.php');
exit();
?>
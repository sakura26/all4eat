<?php 
include 'config.php';

//TODO: input filter login_mail login_passwd
$user = user_login($_POST['login_mail'], $_POST['login_passwd']);
if ($user!=null){
    $_SESSION["user"] = json_encode($user);
    page_goback();
}
else{
    echo '{ "status":"error", "desc":"login failed"}'; //TODO: remove me to avoid id bruteforce
    page_goback();
}
?>

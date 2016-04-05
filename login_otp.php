<?php 
include 'config.php';

$user = user_login_otp($_GET['email'], $_GET['token']);
if ($user!=null){
    $_SESSION["user"] = json_encode($user);
    //echo $_SESSION["user"];
    page_goto("http://www.librabb.it/littlerabbit/book.php?id=1");  //TODO: move to main page
}
else{
    echo '{ "status":"error", "desc":"login failed"}'; //TODO: remove me to avoid id bruteforce
    //page_goto("http://www.librabb.it/littlerabbit/book.php?id=1");  //TODO: move to main page
}

?>

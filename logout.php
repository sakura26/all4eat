<?php 
include 'config.php';

//TODO: update db leave time
error_log( date('[Y-m-d H:i e] '). "INFO: login: user ".$user["email"]." logout" . PHP_EOL, 3, LOGFILE_API);
$_SESSION["user"] = null;
page_goback();
?>

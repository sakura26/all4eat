<?php 
include 'config.php';

//TODO: filter input
//get email
if (isset($user)){  //登入使用者優先
  $email = $user["email"];
  $nickname = $user["nickname"];
  $cellphone = $user["cellphone"];
}
else if (isset($_GET['email'])){
  $email = $_GET['email'];
  $nickname = $_GET['nickname'];
  if (!isset($nickname) || $nickname==null || trim($nickname)==""){
	  $nickname=$email;
  }
  $cellphone = $_GET['cellphone'];
  if (!isset($cellphone)){
	  $cellphone = "";
  }
  //add user & login
  $user = user_add($email, null, $nickname, $cellphone);
  if ($user!=null){
  	$_SESSION["user"] = json_encode($user);
  }
  else{
    error_log( date('[Y-m-d H:i e] '). "ERROR: event_join: failed to add user, goback." . PHP_EOL, 3, LOGFILE_API);
    page_goback();
  }
}
else{
  //ERROR: no email name given!
  error_log( date('[Y-m-d H:i e] '). "NOTICE: event_join: no email, goback." . PHP_EOL, 3, LOGFILE_API);
  page_goback();
}

$job = $_GET['job'];
$description = $_GET["description"];
$event_id = $_GET["event_id"];
if (!isset($job) || !isset($event_id)){
	//oops
	error_log( date('[Y-m-d H:i e] '). "NOTICE: event_join: no job/event_id, goback." . PHP_EOL, 3, LOGFILE_API);
	page_goback();
}

if ( event_join($event_id, $job, $description, $user) ){
	error_log( date('[Y-m-d H:i e] '). "NOTICE: event_join: success" . PHP_EOL, 3, LOGFILE_API);
}
else{
	error_log( date('[Y-m-d H:i e] '). "NOTICE: event_join: no job/event_id, goback." . PHP_EOL, 3, LOGFILE_API);
}
page_goback();

?>
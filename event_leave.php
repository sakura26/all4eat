<?php 
include 'config.php';

//TODO: filter input
if (!isset($_GET["event_id"]) || !isset($_GET["job"])){
  page_goback();
}
$event_id=$_GET["event_id"];
$job=$_GET["job"];
if (isset($_GET["dummy"])){
	event_leave_nonuser($event_id, $job, $_GET["dummy"]);
}
else{
	if (isset($user))
		event_leave($event_id, $job, $user);
}
//error_log( date('[Y-m-d H:i e] '). "NOTICE: event_leave: no job/event_id, goback." . PHP_EOL, 3, LOGFILE_API);
page_goback();

?>
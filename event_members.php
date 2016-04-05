<?php 
include 'config.php';

//TODO: filter input
$event = event_get($_GET["id"]);
if ($event==null)
	die(0);
echo $event["json_members"];
?>

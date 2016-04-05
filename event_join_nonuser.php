<?php 
include 'config.php';

//TODO: filter input
if (!isset($_GET['nickname']) || !isset($_GET['job']))
  page_goback();
$nickname = $_GET['nickname'];
$job = $_GET['job'];
$description = $_GET["description"];
$event_id = $_GET["event_id"];

event_join_nonuser($event_id, $job, $description, $nickname);
page_goback();

?>
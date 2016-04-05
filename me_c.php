<?php 
include 'config.php';

//TODO: filter input
//get email
if (!isset($user))
  page_goto("index.php");
$nickname = $_POST["nickname"];
$passwd = $_POST["passwd"];
$phone = $_POST["phone"];
$country = $_POST["country"];
$city = $_POST["city"];
$zip = $_POST["zip"];
$address = $_POST["address"];
$skill_tags = $_POST["skill_tags"];
$supply_tags = $_POST["supply_tags"];
$description = $_POST["description"];

if ( user_upd($user["id"], $passwd, $nickname, $phone, $address, $city, $country, $zip, $description, $skill_tags, $supply_tags) ){
	error_log( date('[Y-m-d H:i e] '). "NOTICE: me_c: success" . PHP_EOL, 3, LOGFILE_API);
}
else{
	error_log( date('[Y-m-d H:i e] '). "NOTICE: me_c: failed." . PHP_EOL, 3, LOGFILE_API);
}
$user = user_get($user["id"]);
$_SESSION["user"] = json_encode($user);
page_goback();

?>
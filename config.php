<?php
include 'secret.php';

//static configs
$site_title = "All 4 eat 飯飯之交";
$site_domain = "all4eat.anotherdream.tw";

//define ( "LOGFILE_TRANSITION" , "transition.log" );
define ( "LOGFILE_API" , "api.log" );

define ( "MAIL_ADMIN" , "s2@anotherdream.tw" );//service

$default_jobs = "主食,副食,點心,飲料,清潔,耗材,設備,空間,分享,娛樂,勞務,其他";

ini_set('session.cookie_lifetime', 60*60*24);

//init
session_start();
//set all default user/cart data
if (isset($_SESSION["user"])){  
  $user = json_decode($_SESSION["user"], true);
}

//time
function dt_now() {
	return date('Y-m-d H:i.s', time());
}

//db
function db_get() {
	$conn = new mysqli(DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME);
	if ($conn->connect_error) 
	    die("Connection failed: " . $conn->connect_error); //TODO: goto error page
	$conn->query(" SET NAMES UTF8;");
	return $conn;
}

//strings
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//pages
function page_goback() {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  die();
}
function page_goto($page) {
  header('Location: ' . $page);
  die();
}

//obj operation
/*
//---------------------general obj---------------------
define ( "OBJ" , "user" );
function obj_get($id) {
	$conn = db_get();
	$obj = null;
	$stmt = $conn->prepare("SELECT * FROM obj WHERE id=? AND deleted_at IS null;");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!($obj = $result->fetch_assoc())) 
	    return null;
	$conn->close();
	return $obj;
}
function obj_add($obj) {
	//validate email format
	//if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	//  error_log( date('[Y-m-d H:i e] '). "NOTICE: user_add: bad email format " .$email. PHP_EOL, 3, LOGFILE_API);
	//  return null;
	//}
	$conn = db_get();
	//do insert
	$stmt = $conn->prepare("INSERT INTO obj (..., created_at) VALUES (..., ?);");
	$stmt->bind_param("s", ..., dt_now());
	$stmt->execute();
	$conn->close();

	//comfirm insert
	$obj = obj_get($stmt->insert_id);
	if ($obj!=null){
		//error_log( date('[Y-m-d H:i e] '). "INFO: user_add: user ".$email." added." . PHP_EOL, 3, LOGFILE_API);
	}
	else{
		//error_log( date('[Y-m-d H:i e] '). "ERROR: user_add: user ".$email." add fail." . PHP_EOL, 3, LOGFILE_API);
	}
	return $obj;
}
function obj_upd($obj) {
	$conn = db_get();
	//do update
	$stmt = $conn->prepare("UPDATE obj SET ...=?, updated_at=NOW() WHERE id=?;");
    $stmt->bind_param("i", ..., $obj["id"]);
    $stmt->execute();
    //error_log( date('[Y-m-d H:i e] '). "NOTICE: user_upd: account ".$email." updated." . PHP_EOL, 3, LOGFILE_API);
    $conn->close();
	return true;
}
function obj_del($id) {
	$conn = db_get();
	//do update
    $stmt = $conn->prepare("UPDATE user SET deleted_at=NOW() WHERE id=? AND deleted_at IS null;");
    $stmt->bind_param("s", $id);
    $stmt->execute(); 
    //error_log( date('[Y-m-d H:i e] '). "NOTICE: user_del: account ".$email." disabled." . PHP_EOL, 3, LOGFILE_API);
    $conn->close();
    //notify_srvadmin("user ".$email." deleted", "INFO");
	return true;
}*/
//---------------------event---------------------
function event_get($id) {
	$conn = db_get();
	$event = null;
	$stmt = $conn->prepare("SELECT * FROM event WHERE id=? AND deleted_at IS null;");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!($event = $result->fetch_assoc())) 
	    return null;
	$conn->close();
	return $event;
}
function event_add($event) {
	//validate email format
	//if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	//  error_log( date('[Y-m-d H:i e] '). "NOTICE: user_add: bad email format " .$email. PHP_EOL, 3, LOGFILE_API);
	//  return null;
	//}| 
	//id, title, owner_id, manager_ids, json_members, subject, start_at, address, phone, member_min, member_max, prize, tags, job_must_have, job_wanted, created_at, updated_at, deleted_at 
/*	$conn = db_get();
	//do insert
	$stmt = $conn->prepare("INSERT INTO event (title, owner_id, manager_ids, json_members, subject, start_at, address, phone, ".
		"member_min, member_max, prize, tags, job_must_have, job_wanted, created_at) VALUES (..., ?);");
	$stmt->bind_param("s", $event["title"], $event["owner_id"], $event["manager_ids"], $event["title"], $event["title"], $event["title"], $event["title"], $event["title"], dt_now());
	$stmt->execute();
	$conn->close();

	//comfirm insert
	$event = event_get($stmt->insert_id);
	if ($event!=null){
		//error_log( date('[Y-m-d H:i e] '). "INFO: user_add: user ".$email." added." . PHP_EOL, 3, LOGFILE_API);
	}
	else{
		//error_log( date('[Y-m-d H:i e] '). "ERROR: user_add: user ".$email." add fail." . PHP_EOL, 3, LOGFILE_API);
	}
	return $event;*/
}
function event_upd($event) {
/*	$conn = db_get();
	//do update
	$stmt = $conn->prepare("UPDATE event SET ...=?, updated_at=NOW() WHERE id=?;");
    $stmt->bind_param("i", ..., $event["id"]);
    $stmt->execute();
    //error_log( date('[Y-m-d H:i e] '). "NOTICE: user_upd: account ".$email." updated." . PHP_EOL, 3, LOGFILE_API);
    $conn->close();
	return true;*/
}
function event_del($id) {
	$conn = db_get();
	//do update
    $stmt = $conn->prepare("UPDATE user SET deleted_at=NOW() WHERE id=? AND deleted_at IS null;");
    $stmt->bind_param("s", $id);
    $stmt->execute(); 
    //error_log( date('[Y-m-d H:i e] '). "NOTICE: user_del: account ".$email." disabled." . PHP_EOL, 3, LOGFILE_API);
    $conn->close();
    //notify_srvadmin("user ".$email." deleted", "INFO");
	return true;
}
function event_join($event_id, $job, $description, $user){
	$event = event_get($event_id);
	$members = json_decode($event["json_members"],true);
	//do some check like jobs limit

	//cheate string json_members
	$value["job"]=$job;
	$value["user_id"]=$user["id"];
	$value["user_nickname"]=$user["nickname"];
	$value["description"]=$description;
	$members[]=$value;
	$json_members = json_encode($members);

	$conn = db_get();
	//do update
    $stmt = $conn->prepare("UPDATE event SET json_members=? WHERE id=? AND deleted_at IS null;");
    $stmt->bind_param("si", $json_members, $event_id);
    $stmt->execute(); 
    error_log( date('[Y-m-d H:i e] '). "NOTICE: event_join: user ".$user["id"]." joined event ". $event_id . PHP_EOL, 3, LOGFILE_API);
    $conn->close();
    //TODO: send notify to user
	return true;
}
function event_join_nonuser($event_id, $job, $description, $nickname){
	$event = event_get($event_id);
	$members = json_decode($event["json_members"],true);
	//do some check like jobs limit

	//cheate string json_members
	$value["job"]=$job;
	$value["user_id"]=-1;
	$value["user_nickname"]=$nickname;
	$value["description"]=$description;
	$members[]=$value;
	$json_members = json_encode($members);

	$conn = db_get();
	//do update
    $stmt = $conn->prepare("UPDATE event SET json_members=? WHERE id=? AND deleted_at IS null;");
    $stmt->bind_param("si", $json_members, $event_id);
    $stmt->execute(); 
    error_log( date('[Y-m-d H:i e] '). "NOTICE: event_join_nonuser: non-user ".$nickname." joined event ". $event_id . PHP_EOL, 3, LOGFILE_API);
    $conn->close();
    //TODO: send notify to user
	return true;
}
function event_leave($event_id, $job, $user){
	$event = event_get($event_id);
	$members = json_decode($event["json_members"],true);
	//do some check like jobs limit

	//cheate string json_members
	//error_log( date('[Y-m-d H:i e] '). "DEBUG: event_leave: user ".$user["id"]." joined event ". $event_id . PHP_EOL, 3, LOGFILE_API);
	$removed = false;
	for($i=0;$i<count($members);$i++){
		if ($members[$i]["job"]==$job && $members[$i]["user_id"]==$user["id"]){
			unset($members[$i]);
			$removed = true;
			break;
		}
	}
	$n=null;
	foreach($members as $v)
		$n[] = $v;
	$json_members = json_encode($n);

	$conn = db_get();
	//do update
    $stmt = $conn->prepare("UPDATE event SET json_members=? WHERE id=? AND deleted_at IS null;");
    $stmt->bind_param("si", $json_members, $event_id);
    $stmt->execute(); 
    error_log( date('[Y-m-d H:i e] '). "NOTICE: event_leave: user ".$user["id"]." leaved job ".$job." of event ".$event["id"]. $event_id . PHP_EOL, 3, LOGFILE_API);
    $conn->close();
    //TODO: send notify to user
	return true;
}
function event_leave_nonuser($event_id, $job, $nickname){
	$event = event_get($event_id);
	$members = json_decode($event["json_members"],true);
	//do some check like jobs limit

	//cheate string json_members
	//error_log( date('[Y-m-d H:i e] '). "DEBUG: event_leave: user ".$user["id"]." joined event ". $event_id . PHP_EOL, 3, LOGFILE_API);
	$removed = false;
	//remove dummy people
	for($i=0;$i<count($members);$i++){
		if ($members[$i]["job"]==$job && $members[$i]["user_id"]==-1){
			unset($members[$i]);
			$removed = true;
			break;
		}
	}
	$n=null;
	foreach($members as $v)
		$n[] = $v;
	$json_members = json_encode($n);

	$conn = db_get();
	//do update
    $stmt = $conn->prepare("UPDATE event SET json_members=? WHERE id=? AND deleted_at IS null;");
    $stmt->bind_param("si", $json_members, $event_id);
    $stmt->execute(); 
    error_log( date('[Y-m-d H:i e] '). "NOTICE: event_leave_nonuser: non-user ".$nickname." leaved job ".$job." of event ".$event["id"]. $event_id . PHP_EOL, 3, LOGFILE_API);
    $conn->close();
    //TODO: send notify to user
	return true;
}
function event_getupdates($id){
	$event = event_get($id);
	if ($event==null || $event["updates"]==null || trim($event["updates"])==""){
		return null;
	}
	return json_decode($event["updates"],true);
}

//---------------------user---------------------
//id, encrypted_password, authentication_token, otp_token, email, nickname, phone, address, city, country, zip, 
//description, skill_tags, supply_tags, created_at, updated_at, deleted_at
function user_get($id) {
	$conn = db_get();
	$user = null;
	if (is_numeric($id)){
		//looking for id
		$stmt = $conn->prepare("SELECT * FROM user WHERE id=? AND deleted_at IS null;");
		$stmt->bind_param("i", $id);
	}
	else{
		//looking for email
		$stmt = $conn->prepare("SELECT * FROM user WHERE email=? AND deleted_at IS null;");
		$stmt->bind_param("s", $id);
	}
	$stmt->execute();
	$result = $stmt->get_result();
	if (!($user = $result->fetch_assoc())) 
	    return null;
	//error_log( date('[Y-m-d H:i e] '). "DEBUG: user_get: " .$id. PHP_EOL, 3, LOGFILE_API);
	$conn->close();
	return $user;
}
function user_add($email, $passwd=null, $nickname=null, $phone=null, $address=null, $city=null, $country=null, $zip=null, $description=null, $skill_tags=null, $supply_tags=null) {
	//validate email format
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  error_log( date('[Y-m-d H:i e] '). "NOTICE: user_add: bad email format " .$email. PHP_EOL, 3, LOGFILE_API);
	  return null;
	}
	//TODO: password強度測試
	if ($passwd==null)
		$passwd = generateRandomString(6);
	//check is duplicate
	if (user_get($email) != null) {
	  error_log( date('[Y-m-d H:i e] '). "NOTICE: user_add: duplicate email " .$email. PHP_EOL, 3, LOGFILE_API);
	  return null;
	}
	$conn = db_get();
	$authentication_token = generateRandomString(10);
	if ($nickname==null || trim($nickname)=="")
		$nickname="NoName";
	$otp_token=null;
	//do insert
	//如果authentication_token有資訊，代表該帳號尚未enable，不然應該為null
	//TODO: make sure authentication_token is not dup
	$stmt = $conn->prepare("INSERT INTO user (email, authentication_token, encrypted_password, otp_token, nickname, phone, ".
		"address, city, country, zip, description, skill_tags, supply_tags, created_at) VALUES (?, ?, MD5(?), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
	$stmt->bind_param("ssssssssssssss", $email, $authentication_token, $salt_pass = PASSWD_SALT.$passwd, $otp_token, $nickname, $phone, 
		$address, $city, $country, $zip, $description, $skill_tags, $supply_tags, dt_now());
	$stmt->execute();
	$conn->close();

	//comfirm insert
	$user = user_get($email);
	if ($user!=null){
		error_log( date('[Y-m-d H:i e] '). "INFO: user_add: user ".$email." added." . PHP_EOL, 3, LOGFILE_API);
		//send email
		if (!user_add_email($email, $passwd, $authentication_token)){
			//TODO: notify admin email is failed
		}
	}
	else
		error_log( date('[Y-m-d H:i e] '). "ERROR: user_add: user ".$email." add fail." . PHP_EOL, 3, LOGFILE_API);
	return $user;
}
function user_add_email($email, $passwd, $authentication_token) {
	//send email
	//TODO: OTP
	$to = $email; //收件者
	$subject = "All4eat 註冊確認信 registration comform"; //信件標題
	$msg = "您好，感謝您的註冊，您的帳號是「".$email."」，密碼是「".$passwd."」。\n".
		   "您可以通過登陸系統管理您的活動預約。\n".
	       "[我們不會直接儲存您的密碼，若是您忘記密碼，除了可以線上重設外，也可以透過我們的單次密碼(OTP)方式登入]\n\n".//TODO
	       "請點選此 http://librabb.it/all4eat/useractive.php?token=".$authentication_token." 啟用您的帳號，或是手動輸入驗證碼「".$authentication_token."」\n";//信件內容
	$headers = "From: ".SERVICE_ADMIN; //寄件者

	if(mail("$to", "$subject", "$msg", "$headers")):
	 //echo "信件已經發送成功。";//寄信成功就會顯示的提示訊息
	  error_log( date('[Y-m-d H:i e] '). "INFO: user_add_email: registration comform mail sended ". $email . PHP_EOL, 3, LOGFILE_API);
	else:
	 //echo "信件發送失敗！";//寄信失敗顯示的錯誤訊息
	  error_log( date('[Y-m-d H:i e] '). "ERROR: user_add_email: registration comform mail fail! ". $email . PHP_EOL, 3, LOGFILE_API);
	  return false;
	endif;
	return true;
}
function user_upd($email, $passwd=null, $nickname="NoName", $phone=null, $address=null, $city=null, $country=null, $zip=null, $description=null, $skill_tags=null, $supply_tags=null){
	$conn = db_get();
	//do update
	if ($passwd==null || trim($passwd)==""){
		if (is_numeric($email))
	    	$stmt = $conn->prepare("UPDATE user SET nickname=?, phone=?, address=?, city=?, country=?, zip=?, description=?, skill_tags=?, supply_tags=?, updated_at=NOW() WHERE id=?;");
	    else
	    	$stmt = $conn->prepare("UPDATE user SET nickname=?, phone=?, address=?, city=?, country=?, zip=?, description=?, skill_tags=?, supply_tags=?, updated_at=NOW() WHERE email=?;");
	    $stmt->bind_param("ssssssssss", $nickname, $phone, $address, $city, $country, $zip, $description, $skill_tags, $supply_tags, $email);
	}
	else{
		if (is_numeric($email))
	    	$stmt = $conn->prepare("UPDATE user SET encrypted_password=?, nickname=?, phone=?, address=?, city=?, country=?, zip=?, description=?, skill_tags=?, supply_tags=?, updated_at=NOW() WHERE id=?;");
	    else
	    	$stmt = $conn->prepare("UPDATE user SET encrypted_password=?, nickname=?, phone=?, address=?, city=?, country=?, zip=?, description=?, skill_tags=?, supply_tags=?, updated_at=NOW() WHERE email=?;");
	    $stmt->bind_param("sssssssssss", $salt_pass = PASSWD_SALT.$passwd, $nickname, $phone, $address, $city, $country, $zip, $description, $skill_tags, $supply_tags, $email);
	}
    $stmt->execute();
    error_log( date('[Y-m-d H:i e] '). "NOTICE: user_upd: account ".$email." updated." . PHP_EOL, 3, LOGFILE_API);
    $conn->close();
	return true;
}
function user_del($email) {
	$conn = db_get();
	//do update
	if (is_numeric($email))
    	$stmt = $conn->prepare("UPDATE user SET deleted_at=NOW() WHERE id=? AND deleted_at IS null;");
    else
    	$stmt = $conn->prepare("UPDATE user SET deleted_at=NOW() WHERE email=? AND deleted_at IS null;");
    $stmt->bind_param("s", $email);
    $stmt->execute(); //TODO: is really disabled?
    error_log( date('[Y-m-d H:i e] '). "NOTICE: user_del: account ".$email." disabled." . PHP_EOL, 3, LOGFILE_API);
    $conn->close();
    notify_srvadmin("user ".$email." deleted", "INFO");
	return true;
}
function user_active($authentication_token) {
	$enabled = false;
	$email = null;
	$user = null;
	$conn = db_get();

	//looking for account
	$stmt = $conn->prepare("SELECT * FROM user WHERE authentication_token=?;");
	$stmt->bind_param("s", $authentication_token);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($user = $result->fetch_assoc()) {
	  //find the account, enable it. (clear the authentication_token field)
	  $email = $user["id"];
	  $stmt = $conn->prepare("UPDATE user SET authentication_token=null, updated_at=NOW() WHERE authentication_token=?;");
	  $stmt->bind_param("s", $authentication_token);
	  $stmt->execute();
	  $enabled = true;
	  error_log( date('[Y-m-d H:i e] '). "NOTICE: user_active: account ".$email." enabled." . PHP_EOL, 3, $log_file_api);
	}
	$conn->close();
    notify_srvadmin("user ".$user["email"]."(".$user["id"].") actived", "INFO");
	return $user;
}
function user_login($email, $passwd) {
	//validate email format
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
	  return null;
	
	$conn = db_get();
	$user = null;
	$stmt = $conn->prepare("SELECT * FROM user WHERE email=? AND encrypted_password=MD5(?) AND deleted_at IS null;");
	$stmt->bind_param("ss", $email, $salt_pass = PASSWD_SALT.$passwd);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!($user = $result->fetch_assoc())) {
		if ($user == null){ //try otp
			$user = user_login_otp($email, $passwd);
			if ($user == null){ //try otp
				error_log( date('[Y-m-d H:i e] '). "WARNING: user_login: user " .$email ." login fail.". PHP_EOL, 3, LOGFILE_API);
			    return null;
			}
		}
	}
	error_log( date('[Y-m-d H:i e] '). "INFO: user_login: user " .$email ."logined". PHP_EOL, 3, LOGFILE_API);
	$conn->close();

	return $user;
}
function user_login_otp($email, $passwd) {
	//validate email format
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
	  return null;
	$conn = db_get();
	$user = null;
	$stmt = $conn->prepare("SELECT * FROM user WHERE email=? AND otp_token=? AND deleted_at IS null;"); //TODO: otp timeout
	$stmt->bind_param("ss", $email, $passwd);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!($user = $result->fetch_assoc())) {
		error_log( date('[Y-m-d H:i e] '). "WARNING: user_login_otp: user " .$email ." login fail.". PHP_EOL, 3, LOGFILE_API);
	    return null;
	}
	//else
	//	error_log( date('[Y-m-d H:i e] '). "DEBUG: user ok". PHP_EOL, 3, LOGFILE_API);
	//clear OTP
	//TODO: update login time
	$stmt = $conn->prepare("UPDATE user SET otp_token=null WHERE email=? AND deleted_at IS null;");//, updated_at=NOW()
    $stmt->bind_param("s", $email);
    $stmt->execute();
	error_log( date('[Y-m-d H:i e] '). "INFO: user_login_otp: user " .$email ." logined". PHP_EOL, 3, LOGFILE_API);
	$conn->close();
	//if ($user==null)
	//	error_log( date('[Y-m-d H:i e] '). "WTF: null". PHP_EOL, 3, LOGFILE_API);
	return $user;
}
function user_otp_new($email) {
	//validate email format
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
	  return false;
	$conn = db_get();
	$otp = generateRandomString(6);
	$stmt = $conn->prepare("UPDATE user SET otp_token=? WHERE email=? AND deleted_at IS null;");
	$stmt->bind_param("ss", $otp, $email);
	$stmt->execute();
	$update_count = $stmt->affected_rows;
	$conn->close();
	if ($update_count==0) //no one updated
		return false;
	
	//send email
	$to = $email; //收件者
	$subject = "all4eat 單次登入密碼函 OneTime Password"; //信件標題
	$msg = "您好，感謝您的使用，這是您的單次密碼「".$otp."」，或您可以點此連結登入。\n".
	       " http://www.librabb.it/all4eat/login_otp.php?email=".$email."&token=".$otp."\n\n".
	       "*若您未曾要求啟用單次密碼，請忽略這封郵件";//信件內容
	$headers = "From: ".SERVICE_ADMIN; //寄件者

	if(mail("$to", "$subject", "$msg", "$headers")):
	  error_log( date('[Y-m-d H:i e] '). "INFO: user_otp_new: otp mail sended for ". $email . PHP_EOL, 3, LOGFILE_API);
	else:
	  error_log( date('[Y-m-d H:i e] '). "ERROR: user_otp_new: otp mail fail! ". $email . PHP_EOL, 3, LOGFILE_API);
	endif;

	return true;
}

//---------------------error handeling---------------------
function notify_sysadmin($omsg, $level="ERROR"){ 
	$to = SYSTEM_ADMIN; //收件者
	$subject = "all4eat sysadmin ".$level." noitfy"; //信件標題
	$msg = date('[Y-m-d H:i e] '). $level.": ".$omsg. PHP_EOL;
	$headers = "From: ".SYSTEM_ADMIN; //寄件者
	//TODO: cellphone SMS

	if(mail("$to", "$subject", "$msg", "$headers")):
	  error_log( date('[Y-m-d H:i e] '). "INFO: notify_sysadmin: ". $omsg . PHP_EOL, 3, LOGFILE_API);
	else:
	  error_log( date('[Y-m-d H:i e] '). "ERROR: notify_sysadmin: mail fail! ". $omsg . PHP_EOL, 3, LOGFILE_API);
	  return false;
	endif;
	return true;
}

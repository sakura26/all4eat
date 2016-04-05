<?php 
include 'config.php';


//TODO: clear params
user_add($_GET['email'], $_GET['passwd'], $_GET['nickname'], $_GET['cellphone'], $_GET['shipping_address'], /*$_GET['shipping_country'] TODO: other counrty */"TW" , $_GET['shipping_receiver'], $_GET['shipping_zip'], $_GET['description']);
page_goback(); //TODO: success or not?

?>

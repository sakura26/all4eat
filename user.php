<?php 
include 'config.php';

//TODO: clear parameters

//overwrite $user
$user = user_get($_GET['id']);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="librabb.it">
    <meta name="author" content="anotherdream">
    <link rel="icon" href="../../favicon.ico">
    <title>檢視帳戶</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-table.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css">
    <style>
      body {
        padding-top: 50px;
        padding-bottom: 20px;
      }
    </style>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" id="navbar_title" href="#">檢視帳戶</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <div id="login_block"><?php if (!isset($user)){ ?>
            <form id="login_form" class="navbar-form navbar-right" action="login.php" method="POST">
              <div class="form-group">
                <input type="text" id="login_mail" name="login_mail" placeholder="Email" class="form-control">
              </div>
              <div class="form-group">
                <input type="password" id="login_passwd" name="login_passwd" placeholder="Password" class="form-control">
              </div>
              <button type="submit" id="login_btn" class="btn btn-success">Sign in</button>
            </form>｜
            <form id="login_form" class="navbar-form navbar-right" action="otp_request.php" method="POST">
              <div class="form-group">
                <input type="text" id="login_mail" name="login_mail" placeholder="Email" class="form-control">
              </div>
              <button type="submit" id="login_btn" class="btn btn-success">給我單次密碼</button>
            </form>
          <?php } 
          else{ echo "Welcome ".$user["nickname"]."!\n"; ?>
            <a href="me.php" class="btn btn-info" role="button" style="width: 250px;">我的帳戶</a>｜
            <a href="logout.php" class="btn btn-info" role="button" style="width: 250px;">登出</a>
          <?php } ?>
            <!--<form target="paypal" action="<?php echo $paypal_api_url; ?>" method="post" class="navbar-form navbar-right">
              <input type="hidden" name="cmd" value="_cart">
              <input type="hidden" name="business" value="<?php echo $paypal_business_account; ?>">
              <input type="hidden" name="display" value="1">
              <button type="submit" class="btn btn-primary btn-lg" href="#" role="button" style="width: 200px;" id="donate_btn">檢視購物車</button>
              <img alt="" border="0" src="https://www.paypalobjects.com/zh_TW/i/scr/pixel.gif" width="1" height="1">
            </form>-->
            <a href="cart.php" class="btn btn-info" role="button" style="width: 250px;">購物車</a>
          </div>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container inline-block">
        <div class="row">
          <div class="col-md-12">
            <p><h1><?php echo $user["email"]; ?></h1></p>
            <p>
            <!-- TODO: modify password, modify user data -->
            <?php if ($user["authentication_token"]==null || $user["authentication_token"]=="") echo 已啟用; else echo 尚未啟用; ?><br>
            暱稱：<?php echo $user["nickname"]; ?><br>
            手機號碼：<?php echo $user["cellphone"]; ?><br>
            收件國家：<?php echo $user["shipping_country"]; ?><br>
            收件地址：<?php echo $user["shipping_address"]; ?><br>
            郵遞區號：<?php echo $user["shipping_zip"]; ?><br>
            收件者：<?php echo $user["cellphone"]; ?><br>
            自我介紹：<?php echo $user["description"]; ?><br>
            建立時間：<?php echo $user["created_at"]; ?><br></p>
            
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <hr>

      <footer>
        <p>Librabb.it 2015       聯絡我們 | 異常通報 | 舉報濫用</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="js/bootstrap-table.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script>
        /*function updateBtn() {
          switch($( "#select_btn" ).val()) {
              case "a day":
                  $( "#donate_btn" ).text( "Support a day now! ("+Math.round(c_aday)+"$)" );
                  break;
              case "a visit":
                  $( "#donate_btn" ).text( "Support a visit now! ("+Math.round(c_avisit)+"$)" );
                  break;
              case "a month":
                  $( "#donate_btn" ).text( "Support a month now! ("+Math.round(c_amonth)+"$)" );
                  break;
              default:
                  console.log("not catch?!"+$( "#select_btn" ).val());
          } 
        }*/
    </script>
  </body>
</html>
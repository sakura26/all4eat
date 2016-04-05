<?php 
include 'config.php';

//TODO: clear parameters


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
    <title>我的帳戶</title>
    
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
          <a class="navbar-brand" id="navbar_title" href="#"><?php echo $site_title; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <div id="login_block">
            <!-- <a href="event_new.php" class="btn btn-info" role="button" style="width: 100px;">發起新活動</a> -->
            <?php if (!isset($user)){ ?>
            <form id="login_form" class="navbar-form navbar-right" action="login.php" method="POST">
              <div class="form-group">
                <input type="text" id="login_mail" name="login_mail" placeholder="Email" class="form-control">
              </div>
              <div class="form-group">
                <input type="password" id="login_passwd" name="login_passwd" placeholder="Password" class="form-control">
              </div>
              <button type="submit" id="login_btn" class="btn btn-success">Sign in</button>
            </form>｜<a href="otp_request.php">忘記密碼？</a>
          <?php } 
          else{ echo "Welcome ".$user["nickname"]."!\n"; ?>
            <a href="me.php" class="btn btn-info" role="button" style="width: 250px;">我的帳戶</a>｜
            <a href="logout.php" class="btn btn-info" role="button" style="width: 250px;">登出</a>
          <?php } ?>
          </div>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container inline-block">
        <div class="row">
          <div class="col-md-12">
            <form id="update_form" class="navbar-form navbar-right" action="me_c.php" method="POST">
            <p><h1><?php echo $user["email"]; ?></h1></p>
            <p>
            <!-- TODO: modify password, modify user data -->
            <?php if ($user["authentication_token"]==null || $user["authentication_token"]=="") echo "已啟用"; else echo "尚未啟用"; ?><br>
            暱稱：<input type="text" id="nickname" name="nickname" value="<?php echo $user["nickname"]; ?>"><br>
            設定新密碼：<input type="text" id="passwd" name="passwd"><br>
            手機號碼：<input type="text" id="phone" name="phone" value="<?php echo $user["phone"]; ?>"><br>
            所在國家：<input type="text" id="country" name="country" value="<?php echo $user["country"]; ?>"><br>
            所在城市：<input type="text" id="city" name="city" value="<?php echo $user["city"]; ?>"><br>
            郵遞區號：<input type="text" id="zip" name="zip" value="<?php echo $user["zip"]; ?>"><br>
            所在地點：<input type="text" id="address" name="address" value="<?php echo $user["address"]; ?>"><br>
            擅長技能：<input type="text" id="skill_tags" name="skill_tags" value="<?php echo $user["skill_tags"]; ?>"><br>
            資源提供：<input type="text" id="supply_tags" name="supply_tags" value="<?php echo $user["supply_tags"]; ?>"><br>
            自我介紹：<input type="text" id="description" name="description" value="<?php echo $user["description"]; ?>"><br>
            建立時間：<?php echo $user["created_at"]; ?><br></p>
            <?php //print_r($user); ?>
            <button type="submit" id="update_btn" class="btn btn-success">Update</button>
            </form>
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
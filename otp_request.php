<?php 
include 'config.php';

//TODO: input filter
if (isset($_POST["login_mail"])){
	user_otp_new($_POST["login_mail"]);
	page_goto("index.php");
}
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
    <title>申請一次性密碼</title>
    
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
          
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container inline-block">
        <div class="row">
          <div class="col-md-12">
            <form id="update_form" class="navbar-form navbar-right" action="otp_request.php" method="POST">
            <p><h1>忘記密碼、懶得記密碼？</h1></p>
            <p>
            輸入你的Email, 我們會寄一封單次使用的密碼給您
            <input type="text" id="login_mail" name="login_mail">
            <button type="submit" id="update_btn" class="btn btn-success">Request one-time password</button>
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
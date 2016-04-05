<?php 
include 'config.php';

//TODO: filter input
$event = event_get($_GET["id"]);
$owner = user_get($event["owner_id"]);
$jobmusthave = preg_split ( "/,+/" , $event["job_must_have"]); //逗號分格
$jobwanted = preg_split ( "/,+/" , $event["job_wanted"]);
$members = json_decode($event["json_members"], true);
$updates = event_getupdates($_GET["id"]);
$default_jobs_a = preg_split( "/,+/", $default_jobs);
if (!isset($event["pics"]) || $event["pics"]==null || trim($event["pics"])=="" )
  $main_pics = null;
else
  $main_pics = preg_split( "/,+/", $event["pics"]);
$start_at = strtotime($event["start_at"]);
$end_at = strtotime($event["end_at"]);
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
    <title><?php echo $site_title; ?></title>
    
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
            <p><center><h1><?php echo $event["title"]; ?></h1></center></p>
          </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-md-3">
            <div>
              <p><h3>＝屬性＝</h3><a href="https://www.google.com/calendar/render?action=TEMPLATE&text=<?php echo $event["title"]; ?>&dates=<?php echo date('Ymd',$start_at)."T".date('His',$start_at)."Z/".date('Ymd',$end_at)."T".date('His',$end_at); ?>Z&details=For+details,+link+here:+http%3A%2f%2fwww.librabb.it%2fall4eat%2fevent.php%3Fid%3D<?php echo $event["id"]; ?>&location=<?php echo $event["address"]; ?>&sf=true&output=xml" class="btn btn-info" role="button" style="width: 250px;">加入Google行事曆</a></p>
              <ul>
                <li>主題：<?php echo $event["subject"]; ?></li>
                <li>開始：<?php echo $event["start_at"]; ?></li>
                <li>結束：<?php echo $event["end_at"]; ?></li>
                <li>地點：<?php echo $event["address"]; ?></li>
                <li>電話：<?php echo $event["phone"]; ?></li>
                <li>人數：<?php echo $event["member_min"]."~".$event["member_max"]; ?></li>
                <li>費用：<?php echo $event["prize"]; ?></li>
                <li>主辦：<a href="user.php?id=<?php echo $owner["id"]; ?>"><?php echo $owner["nickname"]; ?></a></li>
                <li>標籤：<?php echo $event["tags"]; ?></li>
              </ul>

              <p><h3>＝隊伍組成＝</h3> *為必要組成</p>
              <ul>
                <li>*關主：<a href="user.php?id=<?php echo $owner["id"]; ?>"><?php echo $owner["nickname"]; ?></a></li>
                <?php 
                $pcount=1;  //已經印多少職缺出來
                foreach($jobmusthave as $job){  //印出必要任務
                  if ($job == null || trim($job)=="")
                    continue;
                  //find title & joined
                  $match = false;
                  foreach($members as $key => $value){
                    if(!isset($value["marked"]) && $value["job"]==$job){
                      if ($value["user_id"]!=-1){
                        echo "<li>".$value["job"]."：<a href=\"user.php?id=".$value["user_id"]."\">".$value["user_nickname"]."</a>";
                        echo " <a href='event_leave.php?event_id=".$event["id"]."&&job=".$value["job"]."'>[-]</a>";
                      }
                      else{
                        echo "<li>".$value["job"]."：".$value["user_nickname"];
                        echo " <a href='event_leave.php?dummy=".$value["user_nickname"]."&event_id=".$event["id"]."&&job=".$value["job"]."'>[-]</a>";
                      }
                      if (isset($value["description"]) && $value["description"]!=null && trim($value["description"])!="" ){
                        echo "<br>".$value["description"];
                      }
                      echo "</li>\n";
                      $members[$key]["marked"]=true;
                      $match=true;
                      break;
                    }
                  }
                  if (!$match)
                    echo "<li>".$job."：<a href=\"javascript: $('#job').val('".$job."'); $(document).scrollTop( $('#join_now').offset().top ); void(0)\">[＋]</a></li>\n";
                  $pcount++;
                }
                foreach($jobwanted as $job){   //印出想要任務
                  if ($job == null || trim($job)=="")
                    continue;
                  //find title & joined
                  $match = false;
                  foreach($members as $key => $value){
                    if(!isset($value["marked"]) && $value["job"]==$job){
                      if ($value["user_id"]!=-1){
                        echo "<li>".$value["job"]."：<a href=\"user.php?id=".$value["user_id"]."\">".$value["user_nickname"]."</a>";
                        echo " <a href='event_leave.php?event_id=".$event["id"]."&&job=".$value["job"]."'>[-]</a>";
                      }
                      else{
                        echo "<li>".$value["job"]."：".$value["user_nickname"];
                        echo " <a href='event_leave.php?dummy=".$value["user_nickname"]."&event_id=".$event["id"]."&&job=".$value["job"]."'>[-]</a>";
                      }
                      if (isset($value["description"]) && $value["description"]!=null && trim($value["description"])!="" ){
                        echo "<br>".$value["description"];
                      }
                      echo "</li>\n";
                      $members[$key]["marked"]=true;
                      $match=true;
                      break;
                    }
                  }
                  if (!$match)
                    echo "<li>".$job."：<a href=\"javascript: $('#job').val('".$job."'); $(document).scrollTop( $('#join_now').offset().top ); void(0)\">[＋]</a></li>\n";
                  $pcount++;
                }
                foreach($members as $value){  //印出剩下有報名的
                  if(!isset($value["marked"])){
                    if ($value["user_id"]!=-1){
                      echo "<li>".$value["job"]."：<a href=\"user.php?id=".$value["user_id"]."\">".$value["user_nickname"]."</a>";
                      echo " <a href='event_leave.php?event_id=".$event["id"]."&&job=".$value["job"]."'>[-]</a>";
                    }
                    else{
                      echo "<li>".$value["job"]."：".$value["user_nickname"];
                      echo " <a href='event_leave.php?dummy=".$value["user_nickname"]."&event_id=".$event["id"]."&&job=".$value["job"]."'>[-]</a>";
                    }
                    if (isset($value["description"]) && $value["description"]!=null && trim($value["description"])!="" ){
                      echo "<br>".$value["description"];
                    }
                    echo "</li>\n";
                    $value["marked"]=true;
                  }
                }  ?>
              </ul>

              <p><h3>＝加入隊伍＝</h3><a id="join_now"></a></p>
              <form action="event_join_nonuser.php" method="GET">
              <input type="text" id="nickname" name="nickname" placeholder="暱稱必填" class="form-control"><br>
              任務：<select id="job" name="job">
                <?php foreach($default_jobs_a as $value){
                  echo "<option value=\"".$value."\">".$value."</option>\n";
                } ?>
              </select>
              <input type="text" id="description" name="description" placeholder="描述一下" class="form-control"><br>
              <input type="hidden" id="event_id" name="event_id" value="<?php echo $event["id"]; ?>"><br>
              <button type=\"submit\" id=\"event_join_btn\" class=\"btn btn-success\">Join now!</button>
              </form>
            </div>
          </div>


          <div class="col-md-9">
            <div id="main_desc">
              <h2>簡介：</h2><br>
              <?php echo $event["description"]; ?>
            </div>
            <?php if (isset($updates) && $updates!=null) { ?>
            <div id="updates">
              <h2>更新：</h2><br>
              <?php foreach($updates as $key => $value){
                echo "<div>";
                echo $key."：".$value;
                echo "</div>";
              } ?>
            </div>
            <?php } ?>
            <div id="members">
              <h2>目前隊伍組成：</h2><br>
              <table data-toggle="table" data-url="event_members.php?id=<?php echo $event["id"]; ?>" data-height="299" data-sort-name="name" data-sort-order="desc">
               <thead>
                   <tr>
                       <th data-field="job" data-align="right" data-sortable="true">職業</th>
                       <th data-field="user_nickname" data-align="center" data-sortable="true">暱稱</th>
                       <th data-field="description" data-sortable="true">帶來些什麼？</th>
                   </tr>
               </thead>
              </table>
            </div>
            <div id="maps">
              <h2>地圖：</h2><br>
              <iframe width="600" height="450" frameborder="0" style="border:0"
src="https://www.google.com/maps/embed/v1/place?q=<?php echo $event["address"]; ?>&key=AIzaSyCqmbzf3UKLc1UEs_-9k5099A9GPsWE2gc" allowfullscreen></iframe>
            </div>
            <div id="main_pics">
              <h2>照片：</h2><br>
              <?php foreach($main_pics as $value){
                echo "<img src='".$value."' width='600' />";
              } ?>
            </div>
            <div id="user_pics">
              <h2>活動花絮：</h2><br>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <hr>

      <footer>
        <p><?php echo $site_title; ?> 2015       聯絡我們 | 異常通報 | 舉報濫用</p>
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
  </body>
</html>
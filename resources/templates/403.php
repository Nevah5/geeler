<?php
  session_start();
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
  include("../resources/scripts/autologin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/404/style.css">
  <link rel="icon" href="/resources/icons/logo.png">
  <title>403 - geeler.net</title>
</head>
<body>
  <?php
    $sites = ["/home/", "/login/", "/register/"];
    $shortest = 100;
    $closest = "";

    foreach($sites as $site){
      $lev = levenshtein($_SERVER['REQUEST_URI'], $site);
      if($lev <= $shortest){
        $closest = $site;
        $shortest = $lev;
      }
    }
  ?>
  <a href="/" class="logo"><span>geeler</span></a>
  <div class="error"><div class="content">
    <span>403 - ${403.errormessage}</span>
  </div></div>
  ${footer}
</body>
</html>
<?php
mysqli_close($con);
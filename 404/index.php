<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - geeler.net</title>
</head>
<body>
  <span>geeler</span>
  <h1>404</h1>
  <?php
    $sites = ["/home/", "/login/", "/register/"];
    $shortest = 100;
    $closest = "";

    foreach($sites as $site){
      $lev = levenshtein($_SERVER[REQUEST_URI], $site);
      if($lev <= $shortest){
        $closest = $site;
        $shortest = $lev;
      }
    }
    echo "<p>Did you mean: " . "<a href=\"$closest\">geeler.net".$closest."</a>?</p>" . PHP_EOL;
  ?>
</body>
</html>
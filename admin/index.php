<?php
  session_start();
  ob_start();
  ob_flush();
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'f!ch#zen0!ac9#5Acr=7', "ubibudud_geeler");
  include("../../resources/scripts/autologin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="robots" content="noindex">
  <meta name="googlebot" content="noindex">
  <meta name="googlebot-news" content="noindex">
  <meta name="description" content="${home.meta.desc}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/login/style.css">
  <link rel="icon" href="/resources/icons/logo.png">
  <title>Admin Page - geeler.net</title>
</head>
<body>
  <a href="/" class="logo"><span>geeler</span></a>
  <form action="index.php" method="POST">
    <div class="content">
      <?php
      if(!$_SESSION["admin_access"]){
      ?>
      <h2>Admin Login</h2>
      <div class="wrapper">
        <div class="box">
          <div class="grid">
            <label for="pw">Admin Password</label>
            <div>
              <i id="pw"></i>
              <input type="password" name="pw" id="pw">
            </div>
          </div>
          <?php
          if(isset($_POST["submit"])){
            $rightpw = '$2y$10$LIJkZUDo1vZnaMR4tQiwIep9VNhnjbh5h4PR7BMyrAP6o9fa8uJzK';

            if(password_verify($_POST["pw"], $rightpw)){
              $_SESSION["admin_access"] = true;
              header("Location: ./");
            }else{
              echo "<span id=\"error\">This password is not correct!</span>";
            }
          }
          ?>
          <label for="submit" id="submitbtn">Check</label>
          <input type="submit" name="submit" id="submit">
        </div>
      </div>
      <?php
      }else{
      ?>
      <h2>Admin Panel</h2>
      <div class="wrapper">
        <div class="box">
          <a href="./cms/">CMS System</a>
        </div>
        <style>
          .box{
            display: flex;
            justify-content: center !important;
            align-items: center !important;
          }
          .box a{
            color: white !important;
            text-decoration: none !important;
            background-color: #144A8F;
            border-radius: .5em;
            padding: 5px 10px;
          }
        </style>
      </div>
      <?php
      }
      ?>
    </div>
  </form>
  <!--
           __..--''``---....___   _..._    __
 /// //_.-'    .-/";  `        ``<._  ``.''_ `. / // /
///_.-' _..--.'_    \                    `( ) ) // //
/ (_..-' // (< _     ;_..__               ; `' / ///
 / // // //  `-._,_)' // / ``--...____..-' /// / //
Site made by Noah Geeler
  -->
</body>
</html>
<?php
  mysqli_close($con);
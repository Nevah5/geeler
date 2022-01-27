<?php
  session_start();
  ob_start();
  ob_flush();
  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
  include("./resources/scripts/autologin.php");
  include("./resources/scripts/mailing.php");
  if(!$_SESSION["login"]){
    header("Location: ../");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="robots" content="noindex">
  <meta name="googlebot" content="noindex">
  <meta name="googlebot-news" content="noindex">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://geeler.net/">
  <meta property="og:title" content="geeler.net">
  <meta property="og:description" content="${home.meta.desc}">
  <meta property="og:image" content="https://geeler.net/resources/pictures/preview/site.png">
  <meta name="twitter:card" content="summary">
  <meta property="twitter:url" content="https://geeler.net">
  <meta property="twitter:title" content="geeler.net">
  <meta property="twitter:description" content="${meta.desc}">
  <meta property="twitter:image" content="https://geeler.net/resources/pictures/preview/site.png">
  <meta name="author" content="Noah Geeler">
  <meta name="description" content="${home.meta.desc}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/resources/icons/logo.png">
  <title>${account.title}</title>
</head>
<body>
  <div class="site">
    <div class="navbar">
      <div class="wrap"><a href="/" class="logo">geeler</a></div>
      <nav>
        <span>Settings</span>
        <a href="?profile">Profile</a>
        <a href="./">Account</a>
        <a href="?security">Security</a>
      </nav>
      <a href="./logout/" id="logout">Logout</a>
    </div>
    <div class="content">
      <?php
        if(isset($_GET["profile"])){
      ?>
      <div class="headerbg"></div>
      <div class="banner"></div>
      <div class="pfp" id="border"></div>
      <div class="pfp" style="background-image: url('/resources/icons/user.png');"></div>
      <div class="username"><h2><?= $_SESSION["username"] ?></h2></div>
      <div class="message">
        <h3>This site is not done yet.</h3>
        <span>I will add more features soon, when I got time and more energy, so please be patient.</span>
      </div>
      <?php
        }else if(isset($_GET["security"])){
          $uID = $_SESSION["userID"];
          $userData = mysqli_query($con, "SELECT 2FA FROM users WHERE ID='$uID'");
          $userData = mysqli_fetch_array($userData);
          if($_GET["tfa"] == "true"){
            mysqli_query($con, "UPDATE users SET 2FA=1 WHERE ID='$uID'");
            header("Location: ./?security");
          }else if($_GET["tfa"] == "false"){
            mysqli_query($con, "UPDATE users SET 2FA=0 WHERE ID='$uID'");
            header("Location: ./?security");
          }
          if($userData["2FA"]){
            $twoFAlink = "tfa=false";
            $onoff = "on";
          }else{
            $twoFAlink = "tfa=true";
            $onoff = "off";
          }
      ?>
      <form action="./?security" method="post">
        <div class="toggle">
          <h4>2FA</h4>
          <a id="<?= $onoff ?>" href="?security&<?= $twoFAlink ?>"><div id="dot"></div></a>
        </div>

        <h2>Change Password</h2>
        <label for="pw">Current Password</label>
        <input type="password" name="password" id="pw">
        <label for="newpw">New Password</label>
        <input type="password" name="password" id="newpw">
        <label for="reppw">Repeat Password</label>
        <input type="password" name="password" id="reppw">
        <label for="submit" id="submitbtn">Change</label>
        <input type="submit" id="submit">
      </form>
      <?php
        }else{
      ?>
      <div class="box">
        <div id="pfp" style="background-image: url('/resources/icons/user.png');"></div>
        <div class="align" id="changeimage"><span id="changeimage">Change Image</span></div>
        <div id="userinfo">
          <h2>Username: <span><?= $_SESSION["username"] ?></span></h2>
          <h2>Email: <span><?= $_SESSION["email"] ?></span></h2>
          <?php
            $uID = $_SESSION["userID"];
            $sql = "SELECT * FROM users
              WHERE users.ID='$uID'
            ";
            $userData = mysqli_fetch_array(mysqli_query($con, $sql));
          ?>
          <h2>Joined: <span><?= $userData["joined"] ?></span></h2>
          <?php
            $sql = "SELECT * FROM ads WHERE userFK='$uID'";
            $dbEmailAds = mysqli_num_rows(mysqli_query($con, $sql));
            $onoff = $dbEmailAds >= 1 ? "on" : "off";
            $link = $dbEmailAds >= 1 ? "?getupdatesperemail=false" : "?getupdatesperemail=true";

            if($_GET["getupdatesperemail"] == "true"){
              mysqli_query($con, "INSERT INTO ads VALUES (NULL, '$uID', DEFAULT)");
              header("Location: ./");
            }else if($_GET["getupdatesperemail"] == "false"){
              mysqli_query($con, "DELETE FROM ads WHERE userFK='$uID'");
              header("Location: ./");
            }
          ?>
          <div class="toggle">
            <h4>Get recent updates and news per email:</h4>
            <a id="<?= $onoff ?>" href="<?= $link ?>"><div id="dot"></div></a>
          </div>
        </div>
        <div class="align" id="banner"><span>Banner:</span></div>
        <div id="bannerpreview" style="background-image: url('/resources/pictures/backgrounds/triangles.svg');"></div>
        <div id="changebanner"><span id="changebanner">Change Banner</span><span id="reset">Reset Banner</span></div>
        <div id="accountactions">
          <a href="./logout/" id="logout">Logout</a>
          <a href="./delete/" id="delete">Delete Account</a>
        </div>
      </div>
      <?php
        }
      ?>
    </div>
  </div>
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
<?php
  session_start();
  ob_start();
  ob_flush();
  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'f!ch#zen0!ac9#5Acr=7', "ubibudud_geeler");
  include("../resources/scripts/autologin.php");
  include("../resources/scripts/mailing.php");
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
        <span>${account.nav.settings}</span>
        <a href="?profile">${account.nav.profile}</a>
        <a href="./">${account.nav.account}</a>
        <a href="?security">${account.nav.security}</a>
      </nav>
      <a href="./logout/" id="logout">${account.logout}</a>
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
        <h3>${account.sitenotdone}</h3>
        <span>${account.sitenotdone.text}</span>
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
      <form action="./index.php?security" method="post">
        <div class="toggle">
          <h4>2FA</h4>
          <a id="<?= $onoff ?>" href="?security&<?= $twoFAlink ?>"><div id="dot"></div></a>
        </div>

        <h2>${account.security.password.change}</h2>
        <label for="pw">${account.security.password.current}</label>
        <input type="password" name="password" id="pw">
        <label for="newpw">${account.security.password.new}</label>
        <input type="password" name="newpassword" id="newpw">
        <label for="reppw">${account.security.password.repeat}</label>
        <input type="password" name="reppassword" id="reppw">
        <label for="submit" id="submitbtn">${account.security.password.submit}</label>
        <input type="submit" id="submit" name="submit">
        <?php
          if(isset($_POST["submit"])){
            $uID = $_SESSION["userID"];
            $email = $_SESSION["email"];
            $query = mysqli_query($con, "SELECT * FROM passwords WHERE userFK='$uID'");
            $currentPasswordHash = mysqli_fetch_array($query)["password"];
            if(empty($_POST["password"]) || empty($_POST["newpassword"]) || empty($_POST["reppassword"])){
              echo "<span id=\"error\">All fields have to be specified.</span>";
            }else if($_POST["newpassword"] != $_POST["reppassword"]){
              echo "<span id=\"error\">The new passwords do not match!</span>";
            }else if(!password_verify($_POST["password"], $currentPasswordHash)){
              echo "<span id=\"error\">Your current password is incorrect.</span>";
            }else{
              //change pw
              $pw = password_hash($_POST["newpassword"], PASSWORD_DEFAULT);
              $query = mysqli_query($con, "UPDATE passwords SET password='$pw' WHERE userFK='$uID'");
              if(!mysqli_error($con)){
                $sendMail = new sendMail;
                $sendMail->pwreset_success($email, $con);
                header("Location: ./logout/");
              }
            }
          }
        ?>
      </form>
      <?php
        }else{
      ?>
      <div class="box">
        <div id="pfp" style="background-image: url('/resources/icons/user.png');"></div>
        <div class="align" id="changeimage"><span id="changeimage">Change Image</span></div>
        <div id="userinfo">
          <h2>${account.account.username} <span><?= $_SESSION["username"] ?></span></h2>
          <h2>${account.account.email} <span><?= $_SESSION["email"] ?></span></h2>
          <?php
            $uID = $_SESSION["userID"];
            $sql = "SELECT * FROM users
              WHERE users.ID='$uID'
            ";
            $userData = mysqli_fetch_array(mysqli_query($con, $sql));
          ?>
          <h2>${account.account.joined} <span><?= $userData["joined"] ?></span></h2>
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
            <h4>${account.account.getupdates}</h4>
            <a id="<?= $onoff ?>" href="<?= $link ?>"><div id="dot"></div></a>
          </div>
        </div>
        <div class="align" id="banner"><span>${account.account.banner}</span></div>
        <div id="bannerpreview" style="background-image: url('/resources/pictures/backgrounds/triangles.svg');"></div>
        <div id="changebanner">
          <span id="changebanner">${account.account.banner.change}</span>
          <span id="reset">${account.account.banner.reset}</span>
        </div>
        <div id="accountactions">
          <a href="./logout/" id="logout">${account.logout}</a>
          <a href="./delete/" id="delete">${account.delete}</a>
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
<?php
  session_start();
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
  include("../media/scripts/autologin.php");
  if(!isset($_SESSION["2FA_sent"])){
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
  <meta property="og:image" content="https://geeler.net/media/preview/site.png">
  <meta name="twitter:card" content="summary">
  <meta property="twitter:url" content="https://geeler.net">
  <meta property="twitter:title" content="geeler.net">
  <meta property="twitter:description" content="${home.meta.desc}">
  <meta property="twitter:image" content="https://geeler.net/media/preview/site.png">
  <meta name="author" content="Noah Geeler">
  <meta name="description" content="${home.meta.desc}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <link rel="icon" href="/media/icons/logo.png">
  <title>${login.title.2fa}</title>
</head>
<body>
  <a href="/" class="logo"><span>geeler</span></a>
  <form action="index.php" method="POST">
    <div class="content">
      <h2>${login.section.title.2fa}</h2>
      <div class="wrapper">
        <div class="box">
          <?php
            if(isset($_SESSION["2FA_wait"])){
              echo "<div class=\"verification\">
                <span id=\"title\">${login.2fa.message.title}</span>
                <span>${login.2fa.message.wait}</span>
              </div>";
              unset($_SESSION["2FA_wait"]);
            }else if(isset($_SESSION["2FA_resent"])){
              echo "<div class=\"verification\" id=\"success\">
                <span id=\"title\">${login.2fa.message.title}</span>
                <span>${login.2fa.message.resent}</span>
              </div>";
              unset($_SESSION["2FA_resent"]);
            }else if(isset($_SESSION["2FA_sent"])){
              echo "
              <div class=\"verification\" id=\"success\">
                <span id=\"title\">${login.2fa.message.title}</span>
                <span>${login.2fa.message.sent}</span>
              </div>";
            }
          ?>
          <div class="grid">
            <label for="2fa">${login.2fa}</label>
            <div>
              <i id="pw"></i>
              <input type="text" name="2fa" id="2fa">
            </div>
          </div>
          <?php
            //validate code
            if(isset($_POST["submit"])){
              $uID = $_SESSION["2FA_userID"];
              $code = strtolower($_POST["2fa"]);
              $sql = "SELECT * FROM 2FA WHERE userFK='$uID' AND code='$code' AND valid > NOW() ORDER BY valid DESC LIMIT 1";
              $query = mysqli_query($con, $sql);
              if(mysqli_num_rows($query) != 1){
                echo "<span id=\"error\">${login.2fa.error.code.invalid}</span>";
              }else{
                //code is valid
                $_SESSION["login"] = true;
                $_SESSION["userID"] = $_SESSION["2FA_userID"];
                $_SESSION["email"] = $_SESSION["2FA_email"];
                $_SESSION["username"] = $_SESSION["2FA_username"];
                unset($_SESSION["2FA_username"]);
                unset($_SESSION["2FA_email"]);
                unset($_SESSION["2FA_userID"]);
                unset($_SESSION["2FA_sent"]);
                header("Location: ../../");
              }
            }
          ?>
          <a href="./resend/">${login.2fa.resend}</a>
          <label for="submit" id="submitbtn">${login.submit.2fa}</label>
          <input type="submit" name="submit" id="submit">
          <?php
            $email = explode("@", $_SESSION["2FA_email"]);
            $domain = $email[1];
            $obfuscate = str_split($email[0]);
            $obfuscate = $obfuscate[0] . "*****" . $obfuscate[count($obfuscate) - 1];
            $email = $obfuscate . "@" . $domain;
            echo "<p>${login.2fa.sentto}<p>";
          ?>
        </div>
      </div>
    </div>
  </form>
  ${footer}
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
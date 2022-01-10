<?php
  session_start();
  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
  include("../autologin.php");
  if(isset($_SESSION["login"])){
    header("Location: ../../");
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
  <title>${login.title.forgotpassword}</title>
</head>
<body>
  <a href="/" class="logo"><span>geeler</span></a>
  <form action="index.php" method="POST">
    <div class="content">
      <h2>${login.section.title.forgotpassword}</h2>
      <div class="wrapper">
        <div class="box">
          <?php
            $error = true;
            if(!isset($_SESSION["pwreset"])){
              if(isset($_SESSION["pwreset_wait"])){
                echo "<div class=\"verification\">
                  <span id=\"title\">${login.passwordreset.message.title}</span>
                  <span>${login.passwordreset.message.wait}</span>
                </div>";
                unset($_SESSION["pwreset_wait"]);
              }else if(isset($_SESSION["pwreset_sent"])){
                echo "
                <div class=\"verification\" id=\"success\">
                  <span id=\"title\">${login.passwordreset.message.title}</span>
                  <span>${login.passwordreset.message.sent}</span>
                </div>";
              }
          ?>
          <div class="grid">
            <label for="email">${login.forgotpassword.email}</label>
            <div>
              <i id="email"></i>
              <input type="text" name="email" id="email">
            </div>
          </div>
          <?php
              if(empty($_POST["email"]) && isset($_POST["submit"])){
                echo "<span id='error'>${login.forgotpassword.email.empty}</span>";
              }else if(isset($_POST["submit"])){
                //test email in db
                $email = $_POST["email"];
                $sql = "SELECT * FROM users WHERE email='$email'";
                $query = mysqli_query($con, $sql);
                print_r($query);
                if(mysqli_num_rows($query) != 1){
                  echo "<span id=\"error\">${login.forgotpassword.email.notexists}</span>";
                }else{
                  $_SESSION["pwreset"] = true;
                  $_SESSION["pwreset_email"] = $email;
                  header("Location: ../../mailing/");
                }
              }
          ?>
          <label for="submit" id="submitbtn">${login.forgotpassword.submit.send}</label>
          <?php
            }else if(isset($_SESSION["pwreset"])){
              $pw = $_POST["pw"];
              $pwrep = $_POST["pwrep"];
          ?>
          <div class="grid">
            <label for="pw">${login.forgotpassword.pw}</label>
            <div>
              <i id="pw"></i>
              <input type="text" name="pw" id="pw">
            </div>
          </div>
          <?php
            if(empty($pw) && isset($_POST["submit"])){
              echo "<span id=\"error\">${register.error.emptypassword}</span>";
            }else{
              $error = false;
            }
          ?>
          <div class="grid">
            <label for="pwrep">${login.forgotpassword.pwrep}</label>
            <div>
              <i id="pwrep"></i>
              <input type="text" name="pwrep" id="pwrep">
            </div>
          </div>
          <?php
              if($pw !== $pwrep && !$error && isset($_POST["submit"])){
                echo "<span id=\"error\">${register.error.passwordnotmatch}</span>";
              }else if(isset($_POST["submit"]) && !$error){
                //change pw for user
                $uID = $_SESSION["pwreset_userID"];
                $pw = password_hash($pw, PASSWORD_DEFAULT);
                // mysqli_query($con, "UPDATE passwords SET password='$pw' WHERE userFK='$uID'");
                echo "success";
                //send success email
              }
          ?>
          <label for="submit" id="submitbtn">${login.forgotpassword.submit}</label>
          <?php
            }
          ?>
          <input type="submit" name="submit" id="submit">
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
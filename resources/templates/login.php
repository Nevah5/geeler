<?php
  session_start();
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
  include("../resources/scripts/autologin.php");
  include("../resources/scripts/mailing.php");

  if(isset($_GET["verify"])){
    $userID = $_GET["verify"];
    $sql = "SELECT * FROM users JOIN verify ON users.ID = verify.userFK WHERE users.ID='$userID' AND generated < NOW() - INTERVAL 3 MINUTE";
    $query = mysqli_query($con, $sql);
    if(mysqli_num_rows($query) == 1){
      $data = mysqli_fetch_array($query);
      $sendMail = new sendMail;
      $sendMail->verify($data["token"], $data["email"], $data["username"], false);
      $resendVerifyMail = true;
    }else{
      $resendVerifyMailWait = true;
    }
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
  <meta property="twitter:description" content="${home.meta.desc}">
  <meta property="twitter:image" content="https://geeler.net/resources/pictures/preview/site.png">
  <meta name="author" content="Noah Geeler">
  <meta name="description" content="${home.meta.desc}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/resources/icons/logo.png">
  <title>${login.title}</title>
</head>
<body>
  <a href="/" class="logo"><span>geeler</span></a>
  <form action="index.php" method="POST">
    <div class="content">
      <h2>${login.section.title}</h2>
      <div class="wrapper">
        <div class="box">
          <?php
            if($resendVerifyMail){
              echo "<div class=\"verification\" id=\"success\">
                <span id=\"title\">${login.verification.success.title}</span>
                <span>${login.verification.resend.success}</span>
              </div>";
            }
            if($resendVerifyMailWait){
              echo "<div class=\"verification\" id=\"success\">
                <span id=\"title\">${login.verification.error.title}</span>
                <span>${login.verification.resend.wait}</span>
              </div>";
            }
            if($_SESSION["pwreset_success"]){
              echo "<div class=\"verification\" id=\"success\">
                <span id=\"title\">${login.passwordreset.success.title}</span>
                <span>${login.passwordreset.success.text}</span>
              </div>";
              unset($_SESSION["pwreset_success"]);
            }
            if(isset($_SESSION["verifiederror"])){if($_SESSION["verifiederror"] == "error_token_not_set"){
                echo "<div class=\"verification\">
                  <span id=\"title\">${login.verification.error.title}</span>
                  <span>${login.verification.error.tokennotset}</span>
                </div>";
              }else{
                echo "<div class=\"verification\">
                  <span id=\"title\">${login.verification.error.title}</span>
                  <span>${login.verification.error.tokeninvalid}</span>
                </div>";
              }
              unset($_SESSION["verifiederror"]);
            }else if(isset($_SESSION["verified"])){
              echo "
              <div class=\"verification\" id=\"success\">
                <span id=\"title\">${register_success.success}</span>
                <span>${login.verification.success}</span>
              </div>";
            }
          ?>
          <div class="grid">
            <label for="email">${login.email}</label>
            <div>
              <i id="email"></i>
              <input type="text" name="email" id="email" value="<?php echo !$_SESSION["verified"] ? $_POST["email"] : $_SESSION["email"] ?>">
            </div>
          </div>
          <?php
            if($_POST["submit"] && !$_SESSION["login"]){
              $userexists = false;
              if(empty($_POST["email"])){
                echo "<span>${login.error.noemail}</span>" . PHP_EOL;
              }else{
                $email = $_POST["email"];
                if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE email='$email'")) != 1){
                  echo "<span>${login.error.notexists}</span>" . PHP_EOL;
                }else{
                  $userexists = true;
                }
              }
            }
          ?>
          <div class="grid" id="mtop">
            <label for="password">${login.password}</label>
            <div>
              <i id="pw"></i>
              <input type="password" name="password" id="password">
            </div>
          </div>
          <?php
            if($_POST["submit"] && !$_SESSION["login"]){
              $login = false;
              if(empty($_POST["password"]) && $userexists){
                echo "<span>${login.error.nopassword}</span>" . PHP_EOL;
              }else if($userexists){
                $pw = mysqli_fetch_array(mysqli_query($con, "SELECT password FROM users JOIN passwords ON users.ID = passwords.userFK WHERE email='$email' LIMIT 1"))["password"];
                if(!password_verify($_POST["password"], $pw)){
                  echo "<span>${login.error.passwordwrong}</span>" . PHP_EOL;
                }else{
                  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM users JOIN verify ON users.ID = verify.userFK WHERE email='$email'")) != 0){ 
                    $userData = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE email='$email'"));
                    echo "<span>${login.account.verify.first}</span>";
                    $uID = $userData['ID'];
                    echo "<a href=\"?verify=$uID\">${login.account.verify.resend}</a>";
                  }else{
                    $login = true;
                  }
                }
              }
            }else if($_SESSION["login"]){
              header("Location: ../");
            }
          ?>
          <a href="./forgotpassword/">${login.password.forgot}</a>
          <div class="check">
            <input type="checkbox" id="stayloggedin" name="stayloggedin">
            <label for="stayloggedin" id="chkbx"><div id="tik"></div></label>
            <label for="stayloggedin">${login.stayloggedin}</label>
          </div>
          <?php
            if($_POST["submit"] && !$_SESSION["login"]){
              if($login){
                $uID = mysqli_fetch_array(mysqli_query($con, "SELECT ID FROM users WHERE email='$email'"))["ID"];
                if(isset($_POST["stayloggedin"])){
                  $token = bin2hex(random_bytes(8));
                  $secret = bin2hex(random_bytes(8));
                  $cookie = $uID . ":" . $secret . ":" . hash_hmac('sha256', $uID . ":" . $token, $secret);
                  setcookie("stayloggedin", $cookie, time()+60*60*24*30, "/");
                  mysqli_query($con, "INSERT INTO cookie VALUES (NULL, '$uID', '$token', '$secret', DEFAULT)");
                }
                $userData = mysqli_fetch_array(mysqli_query($con, "SELECT username, ID FROM users WHERE email='$email' LIMIT 1"));
                if(mysqli_fetch_array(mysqli_query($con, "SELECT 2FA FROM users WHERE ID='$uID'"))["2FA"] == true){
                  //user has 2FA enabled
                  //values for login after 2FA code validation
                  $_SESSION["2FA_email"] = $email;
                  $_SESSION["2FA_username"] = $userData["username"];
                  $_SESSION["2FA_userID"] = $uID;
                  //send mail
                  $sendMail = new sendMail;
                  $sendMail->twoFA($uID, $email, $userData["username"], $con);
                }else{
                  //user login
                  $_SESSION["login"] = true;
                  $_SESSION["email"] = $email;
                  $uID = $userData["ID"];
                  $_SESSION["username"] = $userData["username"];
                  $_SESSION["userID"] = $uID;
                  header("Location: /");
                }
              }
            }
          ?>
          <label for="submit" id="submitbtn">${login.submit}</label>
          <input type="submit" name="submit" id="submit">
          <p>${login.accountregister}</p>
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
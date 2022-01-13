<?php
  session_start();
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
  include("../login/autologin.php");
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
  <link rel="stylesheet" href="../login/style.css">
  <link rel="icon" href="/media/icons/logo.png">
  <title>${register.title}</title>
</head>
<body>
  <a href="/" class="logo"><span>geeler</span></a>
  <form action="index.php" method="POST">
    <div class="content">
      <h2>${register.section.title}</h2>
      <div class="wrapper">
        <div class="box">
          <div class="grid">
            <label for="email">${register.email}<sup>*</sup></label>
            <div>
              <i id="email"></i>
              <input type="text" name="email" id="email" value="<?= $_POST["email"] ?>">
            </div>
          </div>
          <?php
            if($_POST["submit"] && !$_SESSION["login"]){
              $emailexists = true;
              $emailvalid = false;
              if(empty($_POST["email"])){
                echo "<span>${register.error.noemail}</span>" . PHP_EOL;
              }else{
                $email = $_POST["email"];
                if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE email='$email'")) == 1){
                  echo "<span>${register.error.emailexists}</span>" . PHP_EOL;
                }else{
                  $emailexists = false;
                  if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $emailvalid = true;
                  }else{
                    echo "<span>${register.error.emailinvalid}</span>";
                  }
                }
              }
            }
          ?>
          <div class="grid">
            <label for="repemail">${register.repeatemail}<sup>*</sup></label>
            <div>
              <i id="emailrep"></i>
              <input type="text" name="repemail" id="repemail" value="<?= $_POST["repemail"] ?>">
            </div>
          </div>
          <?php
            if($_POST["submit"] && !$_SESSION["login"]){
              $emailmatch = false;
              if(!$emailexists && $emailvalid){
                if(!empty($_POST["repemail"])){
                  if($_POST["email"] == $_POST["repemail"]){
                    $emailmatch = true;
                  }else{
                    echo "<span>${register.error.emailmatch}</span>";
                  }
                }else{
                  echo "<span>${register.error.repeatemailempty}</span>";
                }
              }
            }
          ?>
          <div class="grid">
            <label for="username">${register.username}<sup>*</sup></label>
            <div>
              <i id="user"></i>
              <input type="text" name="username" id="username" value="<?= $_POST["username"] ?>">
            </div>
          </div>
          <?php
            if($_POST["submit"] && !$_SESSION["login"]){
              $usernamevalid = false;
              $usernameexists = true;
              $username = $_POST["username"];
              if($emailmatch){
                if(!empty($_POST["username"])){
                  if(strlen($username) >= 3 && strlen($username) <= 32){
                    $usernamevalid = true;
                  }else{
                    echo "<span>${register.error.usernameinvalid}</span>";
                  }
                  if($usernamevalid){
                    $username = $_POST["username"];
                    if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE username='$username'")) == 1){
                      echo "<span>${register.error.userexists}</span>";
                    }else{
                      $usernameexists = false;
                    }
                  }
                }else{
                  echo "<span>${register.error.emptyusername}</span>";
                }
              }
            }
          ?>
          <div class="grid">
            <label for="password">${register.password}<sup>*</sup></label>
            <div>
              <i id="pw"></i>
              <input type="password" name="password" id="password">
            </div>
          </div>
          <?php
            if($_POST["submit"] && !$_SESSION["login"]){
              if(!$usernameexists){
                if(empty($_POST["password"])){
                  echo "<span>${register.error.emptypassword}</span>";
                }
              }
            }
          ?>
          <div class="grid">
            <label for="repeatpassword">${register.repeatpassword}<sup>*</sup></label>
            <div>
              <i id="pwrep"></i>
              <input type="password" name="repeatpassword" id="repeatpassword">
            </div>
          </div>
          <?php
            if($_POST["submit"] && !$_SESSION["login"]){
              if(!empty($_POST["password"])){
                if($_POST["password"] != $_POST["repeatpassword"]){
                  echo "<span>${register.error.passwordnotmatch}</span>";
                }
              }
            }else if($_SESSION["login"]){
              header("Location: /");
            }
          ?>
          <div class="check">
            <input type="checkbox" id="acceptsecurity" name="acceptsecurity">
            <label for="acceptsecurity" id="chkbx"><div id="tik"></div></label>
            <label for="acceptsecurity">${home.contact.form.acceptsecurity}<sup>*</sup></label>
          </div>
          <?php
            if($_POST["submit"] && !$_POST["password"] != $_POST["repeatpassword"]){
              if(!isset($_POST["acceptsecurity"])){
                echo "<span>${home.contact.form.acceptsecurity.required}</span>";
              }
            }
          ?>
          <div class="check">
            <input type="checkbox" id="acceptads" name="acceptads">
            <label for="acceptads" id="chkbx"><div id="tik"></div></label>
            <label for="acceptads">${register.accept.email}</label>
          </div>
          <span id="required"><sup>*</sup>${register.required}</span>
          <label for="submit" id="submitbtn">${register.submit}</label>
          <input type="submit" name="submit" id="submit">
          <?php
            if($_POST["submit"]){
              if(
                $emailvalid &&
                !$emailexists &&
                $usernamevalid &&
                !$usernameexists &&
                !empty($_POST["password"]) &&
                $_POST["password"] == $_POST["repeatpassword"] &&
                isset($_POST["acceptsecurity"])
              ){
                register_user($username, $email, $_POST["password"], $_POST["acceptads"]);
              }
            }
          ?>
          <p>${register.accountlogin}</p>
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
  function register_user($u, $e, $p, $ads){
    global $con;

    $userID = uniqid();
    $verifyToken = substr(bin2hex(random_bytes(96)), 0, 128);
    $pw = password_hash($p, PASSWORD_DEFAULT);

    mysqli_query($con, "INSERT INTO users VALUES ('$userID', '$u', '$e', DEFAULT, DEFAULT)");
    mysqli_query($con, "INSERT INTO verify VALUES (NULL, '$userID', '$verifyToken', DEFAULT)");
    mysqli_query($con, "INSERT INTO passwords VALUES (NULL, '$userID', '$pw')");

    if($ads){
      mysqli_query($con, "INSERT INTO ads VALUES (NULL, '$userID', DEFAULT)");
    }

    if(!mysqli_error($con)){
      $_SESSION["registersuccess"] = true;
      $_SESSION["registeremail"] = $e;
      $_SESSION["verifyToken"] = $verifyToken;
      header("Location: ../mailing/?verify");
    }
  }
  mysqli_close($con);

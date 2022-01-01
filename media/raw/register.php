<?php
  session_start();
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
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
  <meta property="og:description" content="${meta.desc}">
  <meta property="og:image" content="https://geeler.net/media/preview/site.png">
  <meta name="twitter:card" content="summary">
  <meta property="twitter:url" content="https://geeler.net">
  <meta property="twitter:title" content="geeler.net">
  <meta property="twitter:description" content="${home.meta.desc}">
  <meta property="twitter:image" content="https://geeler.net/media/preview/site.png">
  <meta name="author" content="Noah Geeler">
  <meta name="description" content="${meta.desc}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../login/style.css">
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
            <label for="email">${register.email}</label>
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
            <label for="repemail">${register.repeatemail}</label>
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
            <label for="username">${register.username}</label>
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
                  if(strlen($username) >= 3 && strlen($username) <= 32 && preg_match('/([A-Z]*[a-z]*[0-9]*)\s{0}/', $username)){
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
            <label for="password">${register.password}</label>
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
            <label for="repeatpassword">${register.repeatpassword}</label>
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
            mysqli_close($con);
          ?>
          <div class="check">
            <input type="checkbox" id="acceptsecurity" name="acceptsecurity">
            <label for="acceptsecurity" id="chkbx"><div id="tik"></div></label>
            <label for="acceptsecurity">${home.contact.form.acceptsecurity}</label>
          </div>
          <div class="check">
            <input type="checkbox" id="acceptads" name="acceptads">
            <label for="acceptads" id="chkbx"><div id="tik"></div></label>
            <label for="acceptads">${register.accept.email}</label>
          </div>
          <label for="submit" id="submitbtn">${register.submit}</label>
          <input type="submit" name="submit" id="submit">
          <?php
            if($_POST["submit"]){
              if(
                $emailvalid &&
                $emailexists &&
                $usernamevalid &&
                !$usernameexists &&
                !empty($_POST["password"]) &&
                $_POST["password"] == $_POST["repeatpassword"]
              ){
                //insert account into db
              }
            }
          ?>
          <p>${register.accountlogin}</p>
        </div>
      </div>
    </div>
  </form>
  <div class="footer">
    <nav>
      <div>
        <h1>${home.navbar.home}</h1>
        <a href="#general">About Me</a>
        <a href="#hobby">My hobby</a>
        <a href="#motivation">Motivation</a>
        <a href="#whyme">Why me?</a>
      </div>
      <div>
        <h1>${home.navbar.contact}</h1>
        <a href="tel:+41789500085">${home.contact.phone}</a>
        <a href="email:contact@geeler.net">${home.contact.email}</a>
      </div>
      <div>
        <h1>${home.navbar.donate}</h1>
        <a href="https://www.paypal.com/donate/?hosted_button_id=AP8EUCER58QRA" target="_blank">PayPal</a>
        <a href="https://www.buymeacoffee.com/nevah5" target="_blank">Buy me a coffee</a>
      </div>
      <div>
        <h1>${footer.stuff.title}</h1>
        <a href="/tos/">${footer.stuff.tos}</a>
        <a href="/privacy">${footer.stuff.privacy}</a>
        <a href="/guidelines/">${footer.stuff.guidelines}</a>
        <a href="/acknownledgements/">${footer.stuff.acknownledgements}</a>
        <a href="/copyright/">${footer.stuff.licence}</a>
      </div>
    </nav>
    <div class="wrapper">
      <a href="https://github.com/Nevah5" target="_blank"></a>
      <a href="https://reddit.com/u/Nevah5" target="_blank"></a>
      <a href="https://steamcommunity.com/id/nevah5/" target="_blank"></a>
      <a href="https://twitter.com/Neevaah5" target="_blank"></a>
      <a href="https://stackoverflow.com/users/16029189/nevah5" target="_blank"></a>
    </div>
    <div class="foot">
      <div class="spacer"></div>
      <div class="row">
        <h1>geeler</h1>
        <?php
          if(!$_SESSION["login"]){
        ?>
        <a href="/login/" class="login">${register.user.login}</a>
        <?php
          }else{
        ?>
        <a class="user" href="/logout/">
          <div class="image" style="background-image: url('/media/icons/user.png');"></div>
          <span class="account"><?= $_SESSION["username"] ?></span>
        </a>
        <?php
          }
        ?>
      </div>
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
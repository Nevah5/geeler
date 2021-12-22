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
  <meta property="og:description" content="My name is Noah Geeler, I'm an apprentice as an aplication developer in Zürich.">
  <meta property="og:image" content="https://geeler.net/media/preview/site.png">
  <meta name="twitter:card" content="summary">
  <meta property="twitter:url" content="https://geeler.net">
  <meta property="twitter:title" content="geeler.net">
  <meta property="twitter:description" content="My name is Noah Geeler, I'm an apprentice as an aplication developer in Zürich.">
  <meta property="twitter:image" content="https://geeler.net/media/preview/site.png">
  <meta name="author" content="Noah Geeler">
  <meta name="description" content="My name is Noah Geeler, I'm an apprentice as an aplication developer in Zürich.">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Login - geeler.net</title>
</head>
<body>
  <a href="/" class="logo"><span>geeler</span></a>
  <form action="index.php" method="POST">
    <div class="content">
      <h2>Login</h2>
      <div class="wrapper">
        <div class="box">
          <div class="grid">
            <label for="email">Email</label>
            <div>
              <i id="email"></i>
              <input type="text" name="email" id="email" value="<?= $_POST["email"] ?>">
            </div>
          </div>
          <?php
            if($_POST["submit"] && !$_SESSION["login"]){
              $userexists = false;
              if(empty($_POST["email"])){
                echo "<span>Please specify an email adress.</span>" . PHP_EOL;
              }else{
                $email = $_POST["email"];
                if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE email='$email'")) != 1){
                  echo "<span>This user does not exist!</span>" . PHP_EOL;
                }else{
                  $userexists = true;
                }
              }
            }
          ?>
          <div class="grid" id="mtop">
            <label for="password">Password</label>
            <div>
              <i id="pw"></i>
              <input type="password" name="password" id="password">
            </div>
          </div>
          <?php
            if($_POST["submit"] && !$_SESSION["login"]){
              if(empty($_POST["password"]) && $userexists){
                echo "<span>Please specify a password!</span>" . PHP_EOL;
              }else if($userexists){
                $pw = mysqli_fetch_array(mysqli_query($con, "SELECT password FROM users JOIN passwords ON users.ID = passwords.userFK WHERE email='$email' LIMIT 1"))["password"];
                if(!password_verify($_POST["password"], $pw)){
                  echo "<span>The password doesn't match!</span>" . PHP_EOL;
                }else{
                  //user login
                  $_SESSION["login"] = true;
                  $_SESSION["email"] = $email;
                  $username = mysqli_fetch_array(mysqli_query($con, "SELECT username FROM users WHERE email='$email' LIMIT 1"))["username"];
                  $_SESSION["username"] = $username;
                  header("Location: /");
                }
              }
            }else if($_SESSION["login"]){
              header("Location: /");
            }
            mysqli_close($con);
          ?>
          <label for="submit" id="submitbtn">Login</label>
          <input type="submit" name="submit" id="submit">
        </div>
      </div>
    </div>
  </form>
  <div class="footer">
    <nav>
      <div>
        <h1>Home</h1>
        <a href="#general">About Me</a>
        <a href="#hobby">My hobby</a>
        <a href="#motivation">Motivation</a>
        <a href="#whyme">Why me?</a>
      </div>
      <div>
        <h1>Contact</h1>
        <a href="tel:+41789500085">Phone</a>
        <a href="email:contact@geeler.net">Email</a>
      </div>
      <div>
        <h1>Donate</h1>
        <a href="https://www.paypal.com/donate/?hosted_button_id=AP8EUCER58QRA" target="_blank">PayPal</a>
        <a href="https://www.buymeacoffee.com/nevah5" target="_blank">Buy me a coffee</a>
      </div>
      <div>
        <h1>Stuff</h1>
        <a href="/tos/">Terms of service</a>
        <a href="/privacy">Privacy</a>
        <a href="/guidelines/">Guidelines</a>
        <a href="/acknownledgements/">Acknownledgements</a>
        <a href="/copyright/">Licence</a>
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
        <a href="/login/" class="login">Login</a>
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
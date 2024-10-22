<?php
  session_start();
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'f!ch#zen0!ac9#5Acr=7', "ubibudud_geeler");
  include("../resources/scripts/autologin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/style.css">
  <link rel="icon" href="/resources/icons/logo.png">
  <title>403 - geeler.net</title>
</head>
<body>
  <a href="/" class="logo"><span>geeler</span></a>
  <div class="error"><div class="content">
    <span>This site is not done yet!</span><br>
    <span>Please have patience...</span><br>
    <span>-</span><br>
    <span style="font-size: 2.5rem;">Planned Release:</span>
    <span style="font-size: 1.7rem;">01.02.2022 - 15.02.2022</span>
  </div></div>
  <div class="footer">
    <nav>
      <div>
        <h1>Home</h1>
        <a href="/#general">About Me</a>
        <a href="/#hobby">My hobby</a>
        <a href="/#motivation">Motivation</a>
        <a href="/#whyme">Why me?</a>
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
        <h1><a href="/">geeler</a></h1>
        <span>© 2022 - geeler.net</span>
        <?php
          if(!$_SESSION["login"]){
        ?>
        <a href="/login/" class="login">Login</a>
        <?php
          }else{
        ?>
        <a class="user" href="/logout/">
          <div class="image" style="background-image: url('/resources/icons/user.png');"></div>
          <span class="account"><?= $_SESSION["username"] ?></span>
        </a>
        <?php
          }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
<?php
mysqli_close($con);
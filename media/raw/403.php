<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/404/style.css">
  <title>403 - geeler.net</title>
</head>
<body>
  <?php
    $sites = ["/home/", "/login/", "/register/"];
    $shortest = 100;
    $closest = "";

    foreach($sites as $site){
      $lev = levenshtein($_SERVER['REQUEST_URI'], $site);
      if($lev <= $shortest){
        $closest = $site;
        $shortest = $lev;
      }
    }
  ?>
  <a href="/" class="logo"><span>geeler</span></a>
  <div class="error"><div class="content">
    <span>403 - ${403.errormessage}</span>
  </div></div>
  <div class="footer">
    <nav>
      <div>
        <h1>${home.navbar.home}</h1>
        <a href="#general">${home.about.title}</a>
        <a href="#hobby">${home.about.hobby.title}</a>
        <a href="#motivation">${home.about.motivation.title}</a>
        <a href="#whyme">${home.about.whyme.title}</a>
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
        <a href="/login/" class="login">${home.user.login}</a>
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
</body>
</html>
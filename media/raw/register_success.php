<?php
  session_start();
  if(!$_SESSION["registersuccess"] || $_SESSION["login"]){
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
  <link rel="stylesheet" href="../../login/style.css">
  <title>${register_success.title}</title>
</head>
<body>
  <a href="/" class="logo"><span>geeler</span></a>
  <form action="index.php" method="POST">
    <div class="content">
      <h2>${register_success.section.title}</h2>
      <div class="wrapper">
        <div class="box" id="successbox">
          <?php
            $email = explode("@", $_SESSION["registeremail"]);
            $domain = $email[1];
            $obfuscate = str_split($email[0]);
            $obfuscate = $obfuscate[0] . "*****" . $obfuscate[count($obfuscate) - 1];
            $email = $obfuscate . "@" . $domain;
          ?>
          <h3>${register_success.success}</h3>
          <p id="success">${register_success.info}</p>
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
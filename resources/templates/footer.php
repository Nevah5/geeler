<div class="footer">
  <nav>
    <div>
      <h1>${home.navbar.home}</h1>
      <a href="/#general">About Me</a>
      <a href="/#hobby">My hobby</a>
      <a href="/#motivation">Motivation</a>
      <a href="/#whyme">Why me?</a>
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
    <a href="https://www.linkedin.com/in/noah-geeler-820b4b22b/" target="_blank"></a>
  </div>
  <div class="foot">
    <div class="spacer"></div>
    <div class="row">
      <h1><a href="/">geeler</a></h1>
      <span>© 2022 - geeler.net</span>
      <?php
        if(!$_SESSION["login"]){
      ?>
      <a href="/login/" class="login">${register.user.login}</a>
      <?php
        }else{
      ?>
      <a class="user" href="/account/">
        <div class="image" style="background-image: url('/resources/icons/user.png');"></div>
        <span class="account"><?= $_SESSION["username"] ?></span>
      </a>
      <?php
        }
      ?>
    </div>
  </div>
</div>
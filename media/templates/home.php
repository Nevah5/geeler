<?php
  session_start();
  ob_start();
  ob_flush();
  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
  include("./login/autologin.php");
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
  <meta property="twitter:description" content="${meta.desc}">
  <meta property="twitter:image" content="https://geeler.net/media/preview/site.png">
  <meta name="author" content="Noah Geeler">
  <meta name="description" content="${home.meta.desc}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/media/icons/logo.png">
  <title>${home.title}</title>
</head>
<body>
  <nav id="home"></nav>
  <div class="home">
    <nav class="navbar">
      <span class="logo">geeler</span>
      <input type="checkbox" id="navbartoggle" class="navbar-toggle">
      <ul class="navigation">
        <h4>${home.navbar.title}</h4>
        <label for="navbartoggle" class="close">
          <div></div>
          <div></div>
        </label>
        <a href="#home">
          <li>${home.navbar.home}</li>
        </a>
        <a href="#about">
          <li>${home.navbar.about}</li>
        </a>
        <a href="#projects">
          <li>${home.navbar.projects}</li>
        </a>
        <a href="#contact">
          <li>${home.navbar.contact}</li>
        </a>
        <a href="#donate">
          <li>${home.navbar.donate}</li>
        </a>
        <div class="center align_end">
          <div class="grid">
            <?php
              if(!$_SESSION["login"]){
            ?>
            <a href="/login/"><span>${home.user.login}</span></a>
            <a href="/register/"><span>${home.user.register}</span></a>
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
      </ul>
      <label for="navbartoggle" class="navtoggle">
        <div></div>
        <div></div>
        <div></div>
      </label>
      <?php
        if(!isset($_SESSION["login"])){
      ?>
      <ul class="user">
        <a href="/login/">${home.user.login}</a>
        <a href="/register/">${home.user.register}</a>
      </ul>
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
    </nav>
    <div class="wrapper">
      <div class="text_left">
        <h1>${home.home.title}</h1>
        <h2>${home.home.subtitle1}</h2>
        <h2>${home.home.subtitle2}</h2>
        <h2>${home.home.subtitle3}</h2>
      </div>
      <div class="chevronscroll">
        <div class="chevron"></div>
        <div class="chevron"></div>
        <div class="chevron"></div>
        <div class="chevron"></div>
        <div class="chevron"></div>
      </div>
    </div>
    <img src="/media/backgrounds/triangles.svg" alt="backdrop" class="backdrop">
  </div>
  <div class="about" id="about">
    <h1>${home.about.title}</h1>
    <div class="section" id="general">
      <div class="center">
        <div class="img"></div>
      </div>
      <div class="text">
        <h1>${home.about.general.title}</h1>
        <p>${home.about.general.text}</p>
      </div>
    </div>
    <div class="section" id="hobby">
      <div class="center">
        <div class="img"></div>
      </div>
      <div class="text">
        <h1>${home.about.hobby.title}</h1>
        <p>${home.about.hobby.text}</p>
      </div>
    </div>
    <div class="section" id="motivation">
      <div class="center">
        <div class="img"></div>
      </div>
      <div class="text">
        <h1>${home.about.motivation.title}</h1>
        <p>${home.about.motivation.text}</p>
      </div>
    </div>
    <div id="whyme">
      <div class="text">
        <h1>${home.about.whyme.title}</h1>
        <p>${home.about.whyme.text}</p>
      </div>
    </div>
  </div>
  <div class="projects" id="projects">
    <div class="contents">
      <h1>${home.project.title}</h1>
      <div class="wrapper">
        <div class="project" id="nevah5com">
          <div class="overlay"></div>
          <div class="line"><div class="slider"></div></div>
          <div class="head">
            <h2>nevah5.com</h2>
            <div class="tags">
              <span id="php"></span>
              <span id="css"></span>
              <span id="html"></span>
            </div>
          </div>
          <div class="text">
            <p>
              This project is currently my biggest one. Sadly, I dont have time to work on it. I will try to finish it
              soon. It's about collecting cards, trading them and opening boxes. I've mainly focused on the backend
              part, that's why the site doesn't look well.
            </p>
            <div class="anchors">
              <a href="https://nevah5.com">Visit Beta Version &#10095;</a>
              <a href="/media/pictures/nevah5.com.jpg" target="_blank">Image &#10095;</a>
            </div>
            <div class="type">
              <div id="unfinished"></div>
              <div id="inprogress"></div>
              <div id="private"></div>
              <div id="copyright"></div>
            </div>
          </div>
        </div>
        <div class="project" id="geelernetv2">
          <div class="overlay"></div>
          <div class="line"><div class="slider"></div></div>
          <div class="head">
            <h2>geeler.net V2</h2>
            <div class="tags">
              <span id="php"></span>
              <span id="css"></span>
              <span id="html"></span>
            </div>
          </div>
          <div class="text">
            <p>
              This project was made before I have started my apprenticeship. I'm very proud of the finished project,
              but not the code. It is horrible. If I would have enough time, I would redo the whole project, maybe I
              will do that for a final project at the end of the first year of my apprenticeship.
            </p>
            <div class="anchors">
              <a href="/media/pictures/geeler.net.png" target="_blank">Image &#10095;</a>
            </div>
            <div class="type">
              <div id="unfinished"></div>
              <div id="private"></div>
            </div>
          </div>
        </div>
        <div class="project" id="discoin">
          <div class="overlay"></div>
          <div class="line"><div class="slider"></div></div>
          <div class="head">
            <h2>Discoin</h2>
            <div class="tags">
              <span id="php"></span>
            </div>
          </div>
          <div class="text">
            <p>
              I have made this project with a friend at work as a holiday project. It can display any currency's price,
              we intended bitcoin, in discord. We used 2 APIs, one to style the discord webhook with a nice graph, the
              other one to get the price. I would be happy if you want to checkout our project on github.
            </p>
            <div class="anchors">
              <a href="https://github.com/nevah5/discoin">Visit GitHub &#10095;</a>
              <a href="/media/pictures/discoin.png" target="_blank">Image &#10095;</a>
            </div>
            <div class="type">
              <div id="teamwork"></div>
              <div id="opensource"></div>
            </div>
          </div>
        </div>
        <div class="project" id="checkmkdocker">
          <div class="overlay"></div>
          <div class="line"><div class="slider"></div></div>
          <div class="head">
            <h2>Checkmk Node Container</h2>
            <div class="tags">
              <span id="docker"></span>
            </div>
          </div>
          <div class="text">
            <p>
              This small project was my first Docker Container, that I have made. It was used to monitor the host
              system and a database with Checkmk.
            </p>
            <div class="anchors">
              <a href="https://github.com/Nevah5/DockerMonitoring">Visit GitHub &#10095;</a>
              <a href="https://github.com/Nevah5/DockerMonitoring/raw/images/1.png" target="_blank">Image &#10095;</a>
            </div>
            <div class="type">
              <div id="opensource"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="contact" id="contact">
    <h1>${home.contact.title}</h1>
    <div class="details">
      <div class="detail">
        <h3>${home.contact.email.emoji}</h3>
        <a href="mailto:noah@geeler.net" target="_blank">contact@geeler.net</a>
      </div>
      <div class="detail">
        <h3>${home.contact.phone.emoji}</h3>
        <a href="tel:+41789500087" target="_blank">+41 78 950 00 87</a>
      </div>
    </div>
    <div class="message">
      <div class="wrapper">
        <div class="exclamation"><h3>⚠️</h3></div>
        <p>${home.contact.message}</p>
      </div>
    </div>
    <div class="wrapper" id="form">
      <h3 id="contactform">${home.contact.form.title}</h3>
      <form class="form" action="?contact#contactform" method="POST">
        <label for="sender">${home.contact.form.email}</label>
        <input type="text" id="sender" name="sender" maxlength="320" value="<?= $_POST["sender"] ?>">
        <?php
          if(isset($_POST["submit"])){
            $emailvalid = false;
            if(!isset($_POST["sender"])){
              echo "<span id=\"error\">${login.error.noemail}</span>";
            }else{
              if(!filter_var($_POST["sender"], FILTER_VALIDATE_EMAIL)){
                echo "<span id=\"error\">${register.error.emailinvalid}</span>";
              }else{
                $emailvalid = true;
              }
            }
          }
        ?>
        <div>
          <label for="message">${home.contact.form.message}</label>
        </div>
        <textarea type="text" id="message" name="message"><?= $_POST["message"] ?></textarea>
        <?php
          if(isset($_POST["submit"])){
            $messagevalid = false;
            $txtlen = false;
            if(!empty($_POST["message"])){
              $messagevalid = true;
              if(strlen($_POST["message"]) > 75){
                $txtlen = true;
              }else{
                echo "<span id=\"error\">${home.contact.form.message.short}</span>";
              }
            }else{
              echo "<span id=\"error\">${home.contact.message.empty}</span>";
            }
          }
        ?>
        <div>
          <input type="checkbox" id="acceptdb" name="acceptdb">
          <label for="acceptdb" id="chkbx"><div id="tik"></div></label>
          <label for="acceptdb">${home.contact.form.acceptdb}</label>
        </div>
        <?php
          if(isset($_POST["submit"])){
            if(!isset($_POST["acceptdb"])){
              echo "<span id=\"error\">${home.contact.form.acceptdb.required}</span>";
            }
          }
        ?>
        <div>
          <input type="checkbox" id="acceptsecurity" name="acceptsecurity">
          <label for="acceptsecurity" id="chkbx"><div id="tik"></div></label>
          <label for="acceptsecurity">${home.contact.form.acceptsecurity}</label>
        </div>
        <?php
          if(isset($_POST["submit"])){
            if(!isset($_POST["acceptsecurity"])){
              echo "<span id=\"error\">${home.contact.form.acceptsecurity.required}</span>";
            }
          }
        ?>
        <div>
          <label for="submitbtn" id="submit">${home.contact.form.submit}</label>
        </div>
        <input type="submit" id="submitbtn" name="submit">
        <?php
          if(isset($_POST["submit"])){
            if(
              $emailvalid &&
              $messagevalid &&
              $txtlen &&
              isset($_POST["acceptdb"]) &&
              isset($_POST["acceptsecurity"])
            ){
              $IP = $_SERVER['REMOTE_ADDR'];
              $query = mysqli_query($con, "SELECT * FROM contact WHERE DATE_ADD(NOW(), INTERVAL 1 DAY) > sent AND IP='$IP'");
              $numRequests = mysqli_num_rows($query);

              if($numRequests < 2){
                $_SESSION["contactmessage"] = htmlspecialchars_decode($_POST["message"]);
                $_SESSION["contactemail"] = $_POST["sender"];
                $_SESSION["contact"] = true;
                //mesage insert into db in: "/mailing/index.php"
                header("Location: ./mailing/");
              }else{
                echo "<span id=\"error\" style=\"margin-top: 10px; font-size: 1.5rem;\">${home.contact.form.spam}</span>";
              }
            }
          }
        ?>
      </form>
    </div>
  </div>
  <div class="donate" id="donate">
    <div class="contents">
      <h1>${home.donate.title}</h1>
      <a href="https://www.paypal.com/donate/?hosted_button_id=AP8EUCER58QRA" class="paypal" target="_blank">Donate</a>
      <h4>${home.donate.or}</h4>
      <a class="buymeacoffee" href="https://www.buymeacoffee.com/nevah5" target="_blank"></a>
    </div>
  </div>
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
<?php
  session_start();
  ob_start();
  ob_flush();
  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'f!ch#zen0!ac9#5Acr=7', "ubibudud_geeler");
  include("./resources/scripts/autologin.php");
  include("./resources/scripts/mailing.php");
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
  <meta property="twitter:description" content="${meta.desc}">
  <meta property="twitter:image" content="https://geeler.net/resources/pictures/preview/site.png">
  <meta name="author" content="Noah Geeler">
  <meta name="description" content="${home.meta.desc}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/resources/icons/logo.png">
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
            <a class="user" href="/account/">
              <div class="image" style="background-image: url('/resources/icons/user.png');"></div>
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
      <a class="user" href="/account/">
        <div class="image" style="background-image: url('/resources/icons/user.png');"></div>
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
    <img src="/resources/pictures/backgrounds/triangles.svg" alt="backdrop" class="backdrop">
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
        <div class="project" id="geelernetv2">
          <div class="overlay"></div>
          <div class="line">
            <div class="slider"></div>
          </div>
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
              This website here is this project. I have worked on it for 9-11 weeks, during my first year in my
              apprenticeship. I'm very proud of it, but I could have made it even better. The original idea was a forum,
              a better version of my final project in 10th class. But it became a website about me with a useless login
              system.
            </p>
            <div class="anchors">
              <a href="/resources/pictures/geeler.net.png" target="_blank">Image &#10095;</a>
            </div>
            <div class="type">
              <div id="unfinished"></div>
              <div id="private"></div>
            </div>
          </div>
        </div>
        <div class="project" id="discoin">
          <div class="overlay"></div>
          <div class="line">
            <div class="slider"></div>
          </div>
          <div class="head">
            <h2>Discoin</h2>
            <div class="tags">
              <span id="discord"></span>
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
              <a href="/resources/pictures/discoin.png" target="_blank">Image &#10095;</a>
            </div>
            <div class="type">
              <div id="teamwork"></div>
              <div id="opensource"></div>
            </div>
          </div>
        </div>
        <div class="project" id="checkmkdocker">
          <div class="overlay"></div>
          <div class="line">
            <div class="slider"></div>
          </div>
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
        <div class="project" id="ictmod294">
          <div class="overlay"></div>
          <div class="line">
            <div class="slider"></div>
          </div>
          <div class="head">
            <h2>ICT ÜK 294 & 295</h2>
            <div class="tags">
              <span id="html"></span>
              <span id="css"></span>
              <span id="js"></span>
              <span id="node"></span>
            </div>
          </div>
          <div class="text">
            <p>
              I have made this webapplication in the ICT ÜK 294. It displays, fetches and updates tasks from an API (API
              made in ÜK 295).
            </p>
            <div class="anchors">
              <a href="/projects/m294-m295">Checkout Project &#10095;</a>
              <a href="/resources/pictures/ictmodule294.png" target="_blank">Image &#10095;</a>
            </div>
            <div class="type">
              <div id="private"></div>
            </div>
          </div>
        </div>
        <div class="project" id="wordlebot">
          <div class="overlay"></div>
          <div class="line">
            <div class="slider"></div>
          </div>
          <div class="head">
            <h2>Discord Wordle</h2>
            <div class="tags">
              <span id="js"></span>
              <span id="node"></span>
              <span id="discord"></span>
            </div>
          </div>
          <div class="text">
            <p>
              I have made this project in my freetime, because I wanted to make something with Node.js and Discord.
              Since
              Wordle is currently in a hype and I also really like it, I decided to make a bot with it.
            </p>
            <div class="anchors">
              <a href="https://github.com/Nevah5/wordlebot">Visit GitHub &#10095;</a>
              <a href="/resources/pictures/wordlebot.png" target="_blank">Image &#10095;</a>
            </div>
            <div class="type">
              <div id="opensource"></div>
              <div id="unfinished"></div>
              <div id="inprogress"></div>
            </div>
          </div>
        </div>
        <div class="project" id="tictactoeai">
          <div class="overlay"></div>
          <div class="line">
            <div class="slider"></div>
          </div>
          <div class="head">
            <h2>TicTacToe AI</h2>
            <div class="tags">
              <span id="html"></span>
              <span id="css"></span>
              <span id="js"></span>
            </div>
          </div>
          <div class="text">
            <p>
              This week was made at work again, like <a href="#discoin">Discoin</a>. The idea was to create TicTacToe as
              a web-application
              and make an AI, that plays against the user.
            </p>
            <div class="anchors">
              <a href="/projects/tictactoeai">Checkout Project &#10095;</a>
              <a href="https://github.com/Nevah5/tictactoeai">Visit GitHub &#10095;</a>
              <a href="/resources/pictures/tictactoeai.png" target="_blank">Image &#10095;</a>
            </div>
            <div class="type">
              <div id="opensource"></div>
              <div id="teamwork"></div>
            </div>
          </div>
        </div>
        <div class="project" id="notensystem">
          <div class="overlay"></div>
          <div class="line">
            <div class="slider"></div>
          </div>
          <div class="head">
            <h2>Geeler.net Notensystem</h2>
            <div class="tags">
              <span id="vue"></span>
              <span id="express"></span>
              <span id="node"></span>
            </div>
          </div>
          <div class="text">
            <p>
              This project was for my final project in the first year of my apprenticeship. It is a Grade Managment
              System with a great overview on your performance.
            </p>
            <div class="anchors">
              <a href="https://notensystem.geeler.net">Checkout Project &#10095;</a>
              <a href="/resources/pictures/notensystem.png" target="_blank">Image &#10095;</a>
            </div>
            <div class="type">
              <div id="private"></div>
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
        <div class="exclamation">
          <h3>⚠️</h3>
        </div>
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
          <label for="acceptdb" id="chkbx">
            <div id="tik"></div>
          </label>
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
          <label for="acceptsecurity" id="chkbx">
            <div id="tik"></div>
          </label>
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
                $message = htmlspecialchars_decode($_POST["message"]);
                $email = $_POST["sender"];
                $sendMail = new sendMail;
                $sendMail->contact($email, $message, $con);
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
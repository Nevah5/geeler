<?php
  session_start();
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
  <title>geeler.net</title>
</head>
<body>
  <nav id="home"></nav>
  <div class="home">
    <nav class="navbar">
      <span class="logo">geeler</span>
      <input type="checkbox" id="navbartoggle" class="navbar-toggle">
      <ul class="navigation">
        <h4>Navigation</h4>
        <label for="navbartoggle" class="close">
          <div></div>
          <div></div>
        </label>
        <a href="#home">
          <li>Home</li>
        </a>
        <a href="#about">
          <li>About</li>
        </a>
        <a href="#projects">
          <li>Projects</li>
        </a>
        <a href="#contact">
          <li>Contact</li>
        </a>
        <a href="#donate">
          <li>Donate</li>
        </a>
        <div class="center align_end">
          <div class="grid">
            <?php
              if(!$_SESSION["login"]){
            ?>
            <a href="/login/"><span>Login</span></a>
            <a href="/register/"><span>Register</span></a>
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
        if(!$_SESSION["login"]){
      ?>
      <ul class="user">
        <a href="/login/">Login</a>
        <a href="/register/">Register</a>
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
        <h1>Noah Geeler</h1>
        <h2>Apprentice Application Developer</h2>
        <h2>Hobby Programmer</h2>
        <h2>Layer 8</h2>
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
    <h1>About me</h1>
    <div class="section" id="general">
      <div class="center">
        <div class="img"></div>
      </div>
      <div class="text">
        <h1>General</h1>
        <p>
          Hi, I'm Noah Geeler. I'm 16 years old and doing an apprenticeship as an application developer in Zurich
          (Switzerland). I really like cats of any size and squirrels, because of their jumping skills, they're both
          my favourite animals.<br>
          My strengths are PHP and maybe CSS, because I've worked with them for a longer time and haven't focused on
          anything else. My weakness is French, because I really don't like the language.<br>
          When family members and friends describe me, they say that I'm always on time, clever and sometimes a nerd.
        </p>
      </div>
    </div>
    <div class="section" id="hobby">
      <div class="center">
        <div class="img"></div>
      </div>
      <div class="text">
        <h1>My hobby</h1>
        <p>
          I mainly work on private projects, such as this website.<br>
          I've also done my biggest project as one. You can learn more about it <a href="#nevah5com">here</a>.<br>
          Apart from programming or making websites, I also play Valorant, a tactical shooter game, with my friends.
          The aim of the game is it to plant a bomb/defuse the bomb. You always play in a team of 5. I would say that
          the most important thing of this game is the communication. If you ignore your team leader's commands, you
          will probably die quickly and loose the round. In most cases, I see myself as this leader, because I think
          about special tactics to execute or optimizing our teamplay.
        </p>
      </div>
    </div>
    <div class="section" id="motivation">
      <div class="center">
        <div class="img"></div>
      </div>
      <div class="text">
        <h1>Motivation</h1>
        <p>
          When I know, what I'm contributing to the project and at the end can say or see what I have done, then I'm
          really motivated to help and support it. My motivation to finish a project pushes me forwards until I almost
          see the finished product shimmering in front of my eyes. My goals are always to learn something new and
          interesting. Also, I want to get on the limits of something, trying, succeeding, and failing. Those are the
          most important things, that I really appreciate, that's also partially why I have chosen this job.
        </p>
      </div>
    </div>
    <div id="whyme">
      <div class="text">
        <h1>Why me?</h1>
        <p>
          So maybe you have already taken a picture of me, but why should you pick exactly me? Well, let me tell you.
          If I'd have to pick an animal that mostly describes me with its characteristics, I will say a cat,
          because it uses its energy the most efficient, in this case for hunting. They're also always looking forwards
          into the future, like me.<br>
          If you now want a young, productive, and interested man, that always knows what his tasks are, thinking in
          advance and caring about his team, then I'm the perfect candidate.
        </p>
      </div>
    </div>
  </div>
  <div class="projects" id="projects">
    <div class="contents">
      <h1>Projects</h1>
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
    <h1>Contact</h1>
    <div class="details">
      <div class="detail">
        <h3>✉️ Email</h3>
        <a href="mailto:noah@geeler.net" target="_blank">contact@geeler.net</a>
      </div>
      <div class="detail">
        <h3>📞 Phone</h3>
        <a href="tel:+41789500087" target="_blank">+41 78 950 00 87</a>
      </div>
    </div>
    <div class="message">
      <div class="wrapper">
        <div class="exclamation"><h3>⚠️</h3></div>
        <p>If you try to reach me on the specified email above, I might not respond quickly. I'd recommend using the form below, that automatically sends an email, with your message to my private inbox.</p>
      </div>
    </div>
    <div class="wrapper" id="form">
      <h3>Send me a message</h3>
      <form class="form">
        <label for="sender">Your Email</label>
        <input type="text" id="sender" name="sender" maxlength="320">
        <div>
          <label for="message">Your Message</label>
        </div>
        <textarea type="text" id="message" name="message"></textarea>
        <div>
          <input type="checkbox" id="acceptdb" name="acceptdb">
          <label for="acceptdb" id="chkbx"><div id="tik"></div></label>
          <label for="acceptdb">You are aware that I store your message with your given email adress and your IP Adress in my database. I will use them for private or checking purposes only.</label>
        </div>
        <div>
          <input type="checkbox" id="acceptsecurity" name="acceptsecurity">
          <label for="acceptsecurity" id="chkbx"><div id="tik"></div></label>
          <label for="acceptsecurity">You have read the <a href="/privacy/" target="_blank">Privacy</a> agreement and accept it.</label>
        </div>
        <div>
          <label for="submitbtn" id="submit">Submit</label>
        </div>
        <input type="submit" id="submitbtn">
      </form>
    </div>
  </div>
  <div class="donate" id="donate">
    <div class="contents">
      <h1>Donate to support me</h1>
      <a href="https://www.paypal.com/donate/?hosted_button_id=AP8EUCER58QRA" class="paypal" target="_blank">Donate</a>
      <h4>or</h4>
      <a class="buymeacoffee" href="https://www.buymeacoffee.com/nevah5" target="_blank"></a>
    </div>
  </div>
  <div class="footer">
    <nav>
      <div>
        <h1>About</h1>
        <a href="#general">About Me</a>
        <a href="#hobby">My hobby</a>
        <a href="#motivation">Motivation</a>
        <a href="#whyme">Why me?</a>
      </div>
      <div>
        <h1>Contact</h1>
        <a href="tel:+41789500085">Telefon</a>
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
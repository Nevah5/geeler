<?php
  session_start();
  if(!$_SESSION["login"] || $_SESSION["username"] != "admin"){
    header("Location: ../");
  }

  echo "<a href='compile.php?input=home.php&lang=en&output=index.php'>Home Index [EN]</a>";
  echo "<a href='compile.php?input=login.php&lang=en&output=login/index.php'>Login Index [EN]</a>";
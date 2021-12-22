<?php
  session_start();
  if(!$_SESSION["login"] || $_SESSION["username"] != "admin"){
    header("Location: ../");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compile Sites</title>
</head>
<body>
  <a href='compile.php?input=home.php&lang=en&output=index.php'>Home Index [EN]</a><br>
  <a href='compile.php?input=home.php&lang=de&output=index.php'>Home Index [DE]</a>
  <br><br><br>
  <a href='compile.php?input=login.php&lang=en&output=login/index.php'>Login Index [EN]</a><br>
  <a href='compile.php?input=login.php&lang=de&output=login/index.php'>Login Index [DE]</a>
</body>
</html>
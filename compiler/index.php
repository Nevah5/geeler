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
  <div>
    <div>
      <a href="/">HOME</a>
      <a href='compile.php?input=home.php&lang=en&output=index.php'>Home Index [EN]</a>
      <a href='compile.php?input=home.php&lang=de&output=index.php'>Home Index [DE]</a>
    </div>
    <div>
      <a href="/login/">LOGIN</a>
      <a href='compile.php?input=login.php&lang=en&output=login/index.php'>Login Index [EN]</a>
      <a href='compile.php?input=login.php&lang=de&output=login/index.php'>Login Index [DE]</a>
    </div>
  </div>
</body>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Alata&family=Concert+One&family=Russo+One&display=swap');
  body{
    margin: 0;
    padding: 0;
    height: 100vh;
  }
  body > div{
    height: 100%;
    width: 100%;
  }
  div{
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
  }
  div > div{
    flex-direction: column;
    gap: 10px;
  }
  a{
    display: block;
    width: fit-content;
    padding: 5px 10px;
    color: white;
    background-color: #144A8F;
    border-radius: .5em;
    text-decoration: none;
    font-family: Alata;
  }
</style>
</html>
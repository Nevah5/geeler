<?php
//this site is for login with cookies
if(isset($_COOKIE["stayloggedin"]) && !$_SESSION["login"]){
  $cookie = explode(":", $_COOKIE["stayloggedin"]);
  $uID = $cookie[0];
  $secret = $cookie[1];
  $hash = $cookie[2];
  //get user cookie info
  $query = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM cookie WHERE userFK='$uID' AND cookie.secret='$secret'"));
  $token = $query["token"];
  if(hash_hmac('sha256', $uID . ":" . $token, $secret) == $hash){
    //login
    $_SESSION["login"] = true;
    $userData = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE ID='$uID'"));
    $_SESSION["userID"] = $uID;
    $_SESSION["email"] = $userData["email"];
    $_SESSION["username"] = $userData["username"];
  }
}
<?php
session_start();
$con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");

if(!isset($_GET["token"])){
  $_SESSION["verifiederror"] = "error_token_not_set";
  header("Location: ../login/");
}else{
  $token = $_GET["token"];
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM verify WHERE token='$token'")) == 0){
    $_SESSION["verifiederror"] = "error_token";
    header("Location: ../login/");
  }else{
    $query = mysqli_query($con, "SELECT email FROM verify JOIN users on verify.userFK = users.ID WHERE token='$token'");
    $email = mysqli_fetch_array($query)["email"];
    mysqli_query($con, "DELETE FROM verify WHERE token='$token'");
    $_SESSION["verified"] = true;
    $_SESSION["email"] = $email;
    header("Location: ../login/");
  }
}
mysqli_close($con);
<?php
  session_start();
  ob_start();
  ob_flush();
  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);
  $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");
  include("../../resources/scripts/autologin.php");
  include("../../resources/scripts/mailing.php");
  if(!$_SESSION["login"]){
    header("Location: ../");
  }
  if(!isset($_GET["success"]) || !isset($_GET["token"])){
    //send deletion mail
    $sendMail = new sendMail;
    $sendMail->deleteAccount($_SESSION["email"], $con);
  }else if(isset($_GET["success"])){
    echo "A confirmation Email has been sent. Please check your inbox.";
  }else if(isset($_GET["token"])){
    $token = $_GET["token"];
    $sql = "SELECT * FROM deleteTokens WHERE token='$token'";
    if(mysqli_num_rows(mysqli_query($con, $sql)) == 1){
      //delete account
      echo "Your account has been deleted successfully!";
      header("refresh:5; Location: ../../");
    }
  }
  mysqli_close($con);
?>
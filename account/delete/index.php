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
  if(!isset($_GET["success"]) && !isset($_GET["token"])){
    //send deletion mail
    $sendMail = new sendMail;
    $sendMail->deleteAccount($_SESSION["email"], $con);
  }else if(isset($_GET["success"])){
    echo "A confirmation email has been sent. Please check your inbox.";
  }else if(isset($_GET["token"])){
    $token = $_GET["token"];
    $sql = "SELECT * FROM deleteTokens
      WHERE token='$token'
      AND created > NOW() - INTERVAL 15 MINUTE
      ORDER BY created DESC LIMIT 1";
    if(mysqli_num_rows(mysqli_query($con, $sql)) == 1){
      //delete account
      $uID = $_SESSION["userID"];
      mysqli_query($con, "DELETE FROM deleteTokens WHERE userFK='$uID'");
      mysqli_query($con, "DELETE FROM cookie WHERE userFK='$uID'");
      mysqli_query($con, "DELETE FROM 2FA WHERE userFK='$uID'");
      mysqli_query($con, "DELETE FROM ads WHERE userFK='$uID'");
      mysqli_query($con, "DELETE FROM verify WHERE userFK='$uID'");
      mysqli_query($con, "DELETE FROM pwreset WHERE userFK='$uID'");
      mysqli_query($con, "DELETE FROM passwords WHERE userFK='$uID'");
      mysqli_query($con, "DELETE FROM users WHERE ID='$uID'");
      echo mysqli_error($con);
      setcookie("stayloggedin", "", time() - 1, "/");
      session_destroy();
      echo "Your account has been deleted successfully! <a href='../'>go back</a>'";
    }
  }
  mysqli_close($con);
?>
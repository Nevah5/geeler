<?php
session_start();
$con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'f!ch#zen0!ac9#5Acr=7', "ubibudud_geeler");
include("../../../resources/scripts/autologin.php");
include("../../../resources/scripts/mailing.php");

//get latest code send date
$uID = $_SESSION["2FA_userID"];
$sql = "SELECT * FROM 2FA WHERE userFK='$uID' AND NOW() + INTERVAL 12 MINUTE < valid ORDER BY valid DESC LIMIT 1";
$query = mysqli_query($con, $sql);
//test if code was not last 3 mins
if(mysqli_num_rows($query) >= 1){
  $_SESSION["2FA_wait"] = true;
  header("Location: ../");
}else{
  //resend code
  $_SESSION["2FA_resent"] = true;
  $sendMail = new sendMail;
  $userID = $_SESSION["2FA_userID"];
  $userData = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE ID='$userID'"));
  $sendMail->twoFA($userID, $userData["email"], $userData["username"], $con);
}
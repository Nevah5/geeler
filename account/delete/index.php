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
?>
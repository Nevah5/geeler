<?php
session_start();
ob_start();
ob_flush();
$con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../media/PHPMailer/src/Exception.php';
require '../media/PHPMailer/src/PHPMailer.php';
require '../media/PHPMailer/src/SMTP.php';

if(isset($_GET["verify"]) && $_SESSION["registersuccess"] && isset($_SESSION["registeremail"])){
  $smtpUsername = "verify@geeler.net";
  $smtpPassword = "q6vuxly_Swu3Rec6lplN";
  $emailFrom = $smtpUsername;
  $emailFromName = "Verify - geeler.net";
  $emailTo = $_SESSION["registeremail"];
  $emailToName = $_SESSION["registeremail"];
  $emailReplyTo = "contact@geeler.net";
  $emailReplyToName = "Contact - geeler.net";
  $emailSubject = "Verification Account";
  $emailAlt = "https://dev.geeler.net/verify?token=" . $_SESSION["verifyToken"];
  $isHTML = true;
  $msgHTML = preg_replace('/[${]{1}.+[}]{1}/', $_SESSION["verifyToken"], file_get_contents('verify.html'));
}else if($_SESSION["contact"]){
  $email = $_SESSION["contactemail"];
  $smtpUsername = "contact@geeler.net";
  $smtpPassword = "q6vuxly_Swu3Rec6lplN";
  $emailFrom = $smtpUsername;
  $emailFromName = $email;
  $emailReplyTo = $email;
  $emailReplyToName = $email;
  $emailTo = "noah.d.geeler@gmail.com";
  $emailToName = "Noah Geeler";
  $emailSubject = "Contact from $email";
  $emailAlt = $_SESSION["contactmessage"];
  $isHTML = false;
  // $msgHTML = preg_replace('/[${]{1}.+[}]{1}/', $_SESSION["contactmessage"], file_get_contents('contact.html'));
  $msgHTML = null;
}else{
  header("Location: ../404/");
}

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
$mail->Host = "asmtp.mail.hostpoint.ch";
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;
$mail->setFrom($emailFrom, $emailFromName);
$mail->addAddress($emailTo, $emailToName);
$mail->addReplyTo($emailReplyTo, $emailReplyToName);
$mail->Subject = $emailSubject;
$mail->IsHTML($isHTML);
if($isHTML){
  $mail->msgHTML($msgHTML, __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
  $mail->AltBody = $emailAlt;
}else{
  $mail->Body = $emailAlt;
}

if(!$mail->send()){
  echo "Mailer Error: " . $mail->ErrorInfo;
}else{
  if(isset($_GET["verify"])){
    unset($_SESSION["verifyToken"]);
    header("Location: ../register/success/"); //when debugging comment out
  }
  if($_SESSION["contact"]){
    $message = $_SESSION["contactmessage"];
    $email = $_SESSION["contactemail"];
    mysqli_query($con, "INSERT INTO contact VALUES (DEFAULT, '$email', '$message')");
    unset($_SESSION["contact"]);
    unset($_SESSION["contactmessage"]);
    unset($_SESSION["contactemail"]);
    header("Location: ../home/contact/success/");
  }
}

mysqli_close($con);
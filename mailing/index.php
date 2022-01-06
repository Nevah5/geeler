<?php
session_start();
ob_start();
ob_flush();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../media/PHPMailer/src/Exception.php';
require '../media/PHPMailer/src/PHPMailer.php';
require '../media/PHPMailer/src/SMTP.php';

if(!$_SESSION["registersuccess"] || !isset($_SESSION["registeremail"])){
  header("Location: ../403");
}else{
  $smtpUsername = "verify@geeler.net";
  $smtpPassword = "q6vuxly_Swu3Rec6lplN";
  $emailFrom = $smtpUsername;
  $emailFromName = "Verify - geeler.net";
  $emailTo = $_SESSION["registeremail"];
  $emailToName = $_SESSION["registeremail"];
  $emailSubject = isset($_GET["verify"]) ? "Verification Account" : "Error";
  $emailAlt = isset($_GET["verify"]) ? "https://dev.geeler.net/verify?token=" . $_SESSION["verifyToken"] : "Error";

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
  $mail->Subject = $emailSubject;
  $mail->msgHTML(preg_replace('/[${]{1}.+[}]{1}/', $_SESSION["verifyToken"], file_get_contents('verify.html'), __DIR__)); //Read an HTML message body from an external file, convert referenced images to embedded,
  $mail->AltBody = $emailAlt;

  if(!$mail->send()){
    echo "Mailer Error: " . $mail->ErrorInfo;
  }else{
    unset($_SESSION["verifyToken"]);
    header("Location: ../register/success/"); //when debugging comment out
  }
}
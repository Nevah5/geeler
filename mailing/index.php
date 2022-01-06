<?php
session_start();
ob_start();
ob_flush();

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
  $emailSubject = "Verification Account";
  $emailAlt = "https://dev.geeler.net/verify?token=" . $_SESSION["verifyToken"];
  $msgHTML = preg_replace('/[${]{1}.+[}]{1}/', $_SESSION["verifyToken"], file_get_contents('verify.html'));
}else if($_SESSION["contact"]){
  $email = $_SESSION["contactemail"];
  $smtpUsername = "contact@geeler.net";
  $smtpPassword = "q6vuxly_Swu3Rec6lplN";
  $emailFrom = $email;
  $emailFromName = "Contact - geeler.net";
  $emailTo = "noah.d.geeler@gmail.com";
  $emailToName = "Noah Geeler";
  $emailSubject = "Contact from $email";
  $emailAlt = $_SESSION["contactmessage"];
  $msgHTML = preg_replace('/[${]{1}.+[}]{1}/', $_SESSION["contactmessage"], file_get_contents('contact.html'));
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
$mail->Subject = $emailSubject;
$mail->IsHTML(true);
$mail->msgHTML($msgHTML, __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
$mail->AltBody = $emailAlt;

if(!$mail->send()){
  echo "Mailer Error: " . $mail->ErrorInfo;
}else{
  if(isset($_GET["verify"])){
    unset($_SESSION["verifyToken"]);
    header("Location: ../register/success/"); //when debugging comment out
  }
  if($_SESSION["contact"]){
    //insert into db
    unset($_SESSION["contact"]);
    unset($_SESSION["contactmessage"]);
    unset($_SESSION["contactemail"]);
    header("Location: ./home/contact/success/");
  }
}
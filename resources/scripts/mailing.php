<?php

session_start();
ob_start();
ob_flush();
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
// $con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER["DOCUMENT_ROOT"] . '/resources/PHPMailer/src/Exception.php';
require $_SERVER["DOCUMENT_ROOT"] . '/resources/PHPMailer/src/PHPMailer.php';
require $_SERVER["DOCUMENT_ROOT"] . '/resources/PHPMailer/src/SMTP.php';

class sendMail {
  private $smtpUsername = "noreply@geeler.net";
  private $smtpPassword = "q6vuxly_Swu3Rec6lplN";
  private $emailFrom = "noreply@geeler.net";
  private $emailFromName = "NoReply - geeler.net";
  private $emailReplyTo = "contact@geeler.net";
  private $emailReplyToName = "Contact - geeler.net";
  private $emailTo = "";
  private $emailToName = "";
  private $emailSubject = "";
  private $emailAlt = "";
  private $isHTML = true;
  private $msgHTML = "";

  public function verify($verifyToken, $email, $username) {
    $this->smtpUsername = "verify@geeler.net";
    $this->smtpPassword = "q6vuxly_Swu3Rec6lplN";
    $this->emailFrom = $this->smtpUsername;
    $this->emailFromName = "Verify - geeler.net";
    $this->emailReplyTo = "contact@geeler.net";
    $this->emailReplyToName = "Contact - geeler.net";
    $this->emailTo = $email;
    $this->emailToName = $username;
    $this->emailSubject = "Test";
    $this->emailAlt = "https://dev.geeler.net/verify?token=" . $verifyToken;
    $this->isHTML = true;
    $this->msgHTML = preg_replace('/[${]{1}.[verifyToken]+[}]{1}/', $verifyToken, file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/resources/mails/verify.html"));

    if($this->send()){
      header("Location: " . $_SERVER["DOCUMENT_ROOT"] . "/register/success/");
    }
  }
  public function contact($email, $message, $con){
    $this->smtpUsername = "contact@geeler.net";
    $this->smtpPassword = "q6vuxly_Swu3Rec6lplN";
    $this->emailFrom = $this->smtpUsername;
    $this->emailFromName = $email;
    $this->emailReplyTo = $email;
    $this->emailReplyToName = $email;
    $this->emailTo = "noah.d.geeler@gmail.com";
    $this->emailToName = "Noah Geeler";
    $this->emailSubject = "Contact from $email";
    $this->emailAlt = $message;
    $this->isHTML = true;
    $this->msgHTML = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/resources/mails/contact.html");
    $this->msgHTML = preg_replace('/[${]{1}.[message]+[}]{1}/', str_replace("\n", "<br>", $message), $this->msgHTML);

    if($this->send()){
      $IP = $_SERVER['REMOTE_ADDR'];
      mysqli_query($con, "INSERT INTO contact VALUES (NULL, '$email', '$message', '$IP', DEFAULT)");
      header("Location: ./home/contact/success/");
    }
  }
  public function send(){
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
    $mail->Host = "asmtp.mail.hostpoint.ch";
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = $this->smtpUsername;
    $mail->Password = $this->smtpPassword;
    $mail->setFrom($this->emailFrom, $this->emailFromName);
    $mail->addAddress($this->emailTo, $this->emailToName);
    $mail->addReplyTo($this->emailReplyTo, $this->emailReplyToName);
    $mail->Subject = $this->emailSubject;
    $mail->IsHTML($this->isHTML);
    if($this->isHTML){
      $mail->msgHTML($this->msgHTML, __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
      $mail->AltBody = $this->emailAlt;
    }else{
      $mail->Body = $this->emailAlt;
    }
    return $mail->send() ? true : false;
  }
}
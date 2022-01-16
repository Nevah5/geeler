<?php

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
      header("Location: ./success/");
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
  public function twoFA($userID, $email, $username, $con){
    $this->emailTo = $email;
    $this->emailToName = $username;
    $this->emailSubject = "2FA Code - geeler.net";

    $TwoFacAuthCode = bin2hex(random_bytes(3));
    $TwoFacAuthCode = strtoupper($TwoFacAuthCode);
    //insert code into db
    mysqli_query($con, "INSERT INTO 2FA (ID, userFK, code, valid) VALUES (NULL, '$userID', '$TwoFacAuthCode', NOW() + INTERVAL 15 MINUTE)");

    $this->emailAlt = "You code has arrived: $TwoFacAuthCode (only valid 15 Minutes)";
    $this->isHTML = true;
    $this->msgHTML = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/resources/mails/2FA.html");
    $this->msgHTML = preg_replace('/[${]{1}.[code]+[}]{1}/', $TwoFacAuthCode, $this->msgHTML);

    if($this->send()){
      $_SESSION["2FA_sent"] = true;
      header("Location: ./2FA");
    }
  }
  public function pwreset($email, $con){
    //test if already sent email
    $sql = "SELECT * FROM pwreset
      JOIN users ON users.ID = pwreset.userFK
      WHERE email='$email' AND created > NOW() - INTERVAL 3 MINUTE
      ORDER BY created DESC LIMIT 1
    ";
    if(mysqli_num_rows(mysqli_query($con, $sql)) == 1){ //if user already sent email last 3 minutes.
      $_SESSION["pwreset_wait"] = true;
      header("Location: ./"); //refresh
    }else{ //if user can send reset email
      $this->emailTo = $email;
      $this->emailToName = $email;
      $this->emailSubject = "Password Reset Link - geeler.net";
      $token = bin2hex(random_bytes(128));
      //insert code into db
      $userData = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE email='$email'"));
      $uID = $userData["ID"];
      mysqli_query($con, "INSERT INTO pwreset VALUES (NULL, '$uID', '$token', DEFAULT)");

      $this->emailAlt = "https://dev.geeler.net/login/forgotpassword?token=$token";
      $this->isHTML = true;
      $this->msgHTML = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/resources/mails/forgotpassword.html");
      $this->msgHTML = preg_replace('/[${]{1}.[token]+[}]{1}/', $token, $this->msgHTML);

      if($this->send()){
        $_SESSION["pwreset_sent"] = true;
        header("Location: ./");
      }
    }
  }
  public function pwreset_success($email, $con){
    $data = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE email='$email'"));
    $this->emailTo = $email;
    $this->emailToName = $data["username"];
    $this->emailSubject = "Password changed - geeler.net";
    $this->emailAlt = "Your password has successfully changed.";
    $this->isHTML = true;
    $this->msgHTML = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/resources/mails/passwordchanged.html");

    if($this->send()){
      $_SESSION["pwreset_success"] = true;
      header("Location: ../");
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
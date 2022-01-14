<?php
session_start();
ob_start();
ob_flush();
$con = mysqli_connect("ubibudud.mysql.db.internal", "ubibudud_geeler", 'qucoCr=$Es=uzaWret5I', "ubibudud_geeler");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../resources/PHPMailer/src/Exception.php';
require '../resources/PHPMailer/src/PHPMailer.php';
require '../resources/PHPMailer/src/SMTP.php';

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
  $msgHTML = preg_replace('/[${]{1}.[verifyToken]+[}]{1}/', $_SESSION["verifyToken"], file_get_contents('verify.html'));
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
  $isHTML = true;
  $msgHTML = file_get_contents("contact.html");
  $msgHTML = preg_replace('/[${]{1}.[message]+[}]{1}/', str_replace("\n", "<br>", $_SESSION["contactmessage"]), $msgHTML);
}else if(isset($_SESSION["2FA"])){
  $email = $_SESSION["2FA_email"];
  $smtpUsername = "noreply@geeler.net";
  $smtpPassword = "q6vuxly_Swu3Rec6lplN";
  $emailFrom = $smtpUsername;
  $emailFromName = "Noreply geeler.net";
  $emailReplyTo = "contact@geeler.net";
  $emailReplyToName = "Contact geeler.net";
  $emailTo = $email;
  $emailToName = $_SESSION["2FA_username"];
  $emailSubject = "Two factor authentication code - geeler.net";

  $TwoFacAuthCode = bin2hex(random_bytes(3));
  $TwoFacAuthCode = strtoupper($TwoFacAuthCode);
  //insert code into db
  $uID = $_SESSION["2FA_userID"];
  mysqli_query($con, "INSERT INTO 2FA (ID, userFK, code, valid) VALUES (NULL, '$uID', '$TwoFacAuthCode', NOW() + INTERVAL 15 MINUTE)");

  $emailAlt = "You code has arrived: $TwoFacAuthCode (only valid 15 Minutes)";
  $isHTML = true;
  $msgHTML = file_get_contents("2FA.html");
  $msgHTML = preg_replace('/[${]{1}.[code]+[}]{1}/', $TwoFacAuthCode, $msgHTML);
}else if(isset($_SESSION["pwreset"])){
  $email = $_SESSION["pwreset_email"];
  //test if already sent email
  $sql = "SELECT * FROM pwreset
    JOIN users ON users.ID = pwreset.userFK
    WHERE email='$email' AND created > NOW() - INTERVAL 3 MINUTE
    ORDER BY created DESC LIMIT 1
  ";
  if(mysqli_num_rows(mysqli_query($con, $sql)) == 1){ //if user already sent email last 3 minutes.
    unset($_SESSION["pwreset"]);
    $_SESSION["pwreset_wait"] = true;
    header("Location: ../login/forgotpassword/");
  }else{                                              //if user can reset pw
    $smtpUsername = "noreply@geeler.net";
    $smtpPassword = "q6vuxly_Swu3Rec6lplN";
    $emailFrom = $smtpUsername;
    $emailFromName = "Noreply geeler.net";
    $emailReplyTo = "contact@geeler.net";
    $emailReplyToName = "Contact geeler.net";
    $emailTo = $email;
    $emailToName = $email;
    $emailSubject = "Password Reset Link - geeler.net";
    $token = bin2hex(random_bytes(128));
    //insert code into db
    $userData = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE email='$email'"));
    $uID = $userData["ID"];
    mysqli_query($con, "INSERT INTO pwreset VALUES (NULL, '$uID', '$token', DEFAULT)");

    $emailAlt = "https://dev.geeler.net/login/forgotpassword?token=$token";
    $isHTML = true;
    $msgHTML = file_get_contents("forgotpassword.html");
    $msgHTML = preg_replace('/[${]{1}.[token]+[}]{1}/', $token, $msgHTML);
  }
}else if(isset($_SESSION["pwreset_success"])){
  $email = $_SESSION["pwreset_email"];
  $smtpUsername = "noreply@geeler.net";
  $smtpPassword = "q6vuxly_Swu3Rec6lplN";
  $emailFrom = $smtpUsername;
  $emailFromName = "Noreply geeler.net";
  $emailReplyTo = "contact@geeler.net";
  $emailReplyToName = "Contact geeler.net";
  $emailTo = $email;
  $data = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE email='$email'"));
  $emailToName = $data["username"];
  $emailSubject = "Password changed - geeler.net";
  $emailAlt = "Your password has successfully changed.";
  $isHTML = true;
  $msgHTML = file_get_contents("passwordchanged.html");
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
    header("Location: ../../register/success/"); //when debugging comment out
  }
  if($_SESSION["contact"]){
    $message = $_SESSION["contactmessage"];
    $email = $_SESSION["contactemail"];
    $IP = $_SERVER['REMOTE_ADDR'];
    mysqli_query($con, "INSERT INTO contact VALUES (NULL, '$email', '$message', '$IP', DEFAULT)");
    unset($_SESSION["contact"]);
    unset($_SESSION["contactmessage"]);
    unset($_SESSION["contactemail"]);
    header("Location: ../../home/contact/success/");
  }
  if(isset($_SESSION["2FA"])){
    unset($_SESSION["2FA"]);
    $_SESSION["2FA_sent"] = true;
    header("Location: ../../login/2FA");
  }
  if(isset($_SESSION["pwreset"])){
    $_SESSION["pwreset_sent"] = true;
    unset($_SESSION["pwreset"]);
    header("Location: ../../login/forgotpassword/");
  }
  if(isset($_SESSION["pwreset_success"])){
    unset($_SESSION["pwreset_email"]);
    header("Location: ../../login/");
  }
}

mysqli_close($con);
<?php
include("class.phpmailer.php");
include("class.smtp.php"); // note, this is optional - gets called from main class if not already loaded

$mail = new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";    // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port

$mail->Username   = "nextixdeveloper@gmail.com";  // GMAIL username
$mail->Password   = "6yhn7ujm8ik,";            // GMAIL password

$mail->From       = "nextixdeveloper@gmail.com";
$mail->FromName   = "Webmaster";
$mail->Subject    = "This is the subject";
$mail->AltBody    = "This is the body when user views in plain text format"; //Text Body
$mail->Body    = "This is the body when user views in plain text format"; //Text Body
$mail->WordWrap   = 50; // set word wrap
$mail->SMTPDebug = 0;

$mail->AddAddress("nextixdeveloper@gmail.com","Rey Philip Regis");

if(!$mail->Send()) {
  echo "<br />Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "<br />Message has been sent";
}
?>
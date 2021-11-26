<?php
require 'php_mailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->CharSet = 'UTF-8';
$mail->Username = 'amit.imprint81@gmail.com';
$mail->Password = 'xtkpalzuuzzqlhvh';

$mail->setFrom('amit.imprint81@gmail.com', 'ADMIN'); // Mail From & Mailer Name
$mail->CharSet="windows-1251";
$mail->CharSet="utf-8";
$mail->IsHTML(true);

$mail->CharSet="windows-1251";$mail->CharSet="utf-8";
$mail->IsHTML(true);

$mail_heading="Demo Mail";		   
$mail->Body = "Hiiii";

$mail->addAttachment("file.txt");        
$mail->addAttachment("6148779e1bf97.png"); //Filename is optional

$mail->Subject = $mail_heading; 
$mail->addAddress("steve@imprintnext.com"); 
if ($mail->send()) echo "99999999999";

?>
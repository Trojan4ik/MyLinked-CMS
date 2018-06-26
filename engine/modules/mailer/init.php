<?php
if (! defined ( 'READFILE' ))
{
	exit ( "Error, wrong way to file.<br><a href=\"/\">Go to main</a>." );
}
function Send_Mail($to,$subject,$body)
 {
require 'engine/phpmailer/class.phpmailer.php';
require 'engine/phpmailer/class.smtp.php';
$mail = new PHPMailer;
$mail->isSMTP(); 
$mail->Host = 'smtp.gmail.com'; 
$mail->SMTPAuth = true; 
$mail->Username = 'mylinkedforum'; // Ваш логин в Яндексе. Именно логин, без @yandex.ru
$mail->Password = 'emen9254'; // Ваш пароль
$mail->SMTPSecure = 'ssl'; 
$mail->Port = 465;
$mail->setFrom('mylinkedforum@gmail.com'); // Ваш Email
$mail->addAddress($to);

// Письмо
$mail->isHTML(true); 
$mail->Subject = $subject; // Заголовок письма
$mail->Body = $body; // Текст письма

// Результат
if(!$mail->send()) {
 
 echo $mail->ErrorInfo;
}
}
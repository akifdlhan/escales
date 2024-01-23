<?php
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//setlocale(LC_TIME, "turkish");
//setlocale(LC_ALL,'turkish');
//include("iconlibrary.php");
//$vt = new veritabani();
$fimy_smtp = $vt->listele("fimy_smtp","where statu=1");
if($fimy_smtp != null) foreach( $fimy_smtp as $smtp ) {
    $username = $smtp['username'];
    $password = $smtp['password'];
    $server = $smtp['server'];
    $port = $smtp['port'];
    $Display = $smtp['Display-Name'];
    $Sender = $smtp['Sender'];
    $Statu = $smtp['Statu'];
}
   
// Mail gönderme fonksiyonu
function sendEmail($to, $subject, $message) {
    global $server, $port, $username, $password, $Display, $Sender;

    $mail = new PHPMailer(true);

    try {
        // Ayarlar
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = $server;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $port;

        // Gönderici bilgileri
        $mail->setFrom($Sender, $Display);

        // Alıcı bilgileri
        $mail->addAddress($to);
        $mail->addAddress("ik@fislash.com.tr");

        // İçerik
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Gönder
        $mail->send();

        return 'E-posta başarıyla gönderildi.';
    } catch (Exception $e) {
        return "E-posta gönderilirken bir hata oluştu: {$mail->ErrorInfo}";
    }
}

?>
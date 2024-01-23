<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani(); 
include("../src/fi-mailer.php");
	extract($_POST);
	if($_POST){
        $to = $testmail;
        $subject = 'Test E-postası';
        $message = 'Merhaba,<br><br>
Bu bir Türkçe karakter testidir. İçerisinde Türkçe karakterler bulunan bir e-posta metnidir.<br><br>
Örnek Türkçe karakterler:<br>
- İş çiçekleri üzerinde ötüşür.<br>
- Şu anda İstanbul\'da hava sıcaklığı 30°C\'dir.<br>
- Türkçe karakterler: ĞğÜüŞşİıÖöÇç.<br><br>
İyi günler.';
        $MailResponse = sendEmail($to, $subject, $message);
        echo '<script>$(document).ready(function(){toastr["success"]("'.$MailResponse.'");});</script>';

	}
?>
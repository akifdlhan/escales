<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
require_once '../src/googleLib/GoogleAuthenticator.php';
$vt = new veritabani();
extract($_POST);
if ($_POST) {
  //$islem;
  if ($islem == 1) {
    if ($yetki == "100") {
      echo '<script>toastr["error"]("Yetki grubu seçiniz..");</script>';
    }
    $fimy_username = $vt->ozellistele("select count(ID) as KullaniciBenzer from fimy_user where kullaniciadi='" . $username . "'");
    if ($fimy_username != null) foreach ($fimy_username as $uname) {
      $KSay = $uname['KullaniciBenzer'];
    }
    if ($KSay > 0) {
      echo '<script>toastr["error"]("' . $username . ' kullanıcısı mevcut..");</script>';
    } else {
      // Buradan devamkee..
      $ga = new GoogleAuthenticator();
      $uniquesecret = $ga->createSecret();
      // Buraya passrules çekliecek ve aşağısı ona göre ayarlanacak ve dbden gelen veriye göre aşağıdak else blogu uyarı metini gücellenecek.

      $fimy_prules = $vt->listele("fimy_prules", "WHERE ID=1");
      if ($fimy_prules != null) foreach ($fimy_prules as $pr) {
        $Min = $pr['Min'];
        $Cust = $pr['Cust-charter'];
        $Num = $pr['Num-req'];
        $UpLow = $pr['UpLow-req'];
        $Cust = ($Cust == true) ? "true" : "false";
        $Num = ($Num == true) ? "true" : "false";
        $UpLow = ($UpLow == true) ? "true" : "false";
      }

      // Buraya passrules çekliecek ve aşağısı ona göre ayarlanacak ve dbden gelen veriye göre aşağıdak else blogu uyarı metini gücellenecek.
      if (checkPasswordStrength($sifre, $Min, $Cust, $Num, $UpLow, $UpLow)) {
        //echo "Şifre geçerli.";
        $sifre = md5($sifre);
        $useradd = $vt->ekle("fimy_user", array("kullaniciadi" => $username, "Sifre" => $sifre, "SonSifre" => $sifre, "smstoken" => $uniquesecret));
        if ($useradd > 0) {
          $user_details_add = $vt->ekle("fimy_user_details", array(
            "Adi" => $adi,
            "Soyadi" => $soyadi,
            "TelefonNo" => $telefon,
            "Mail" => $mail,
            "Adres" => $adres,
            "Resim" => "../assets/images/users/user-default.jpg",
            "User_ID" => $useradd
          ));

          if ($user_details_add > 0) {

            $fimy_user_access = $vt->ekle("fimy_user_access", array(
              "Access_Level" => $yetki,
              "User_ID" => $useradd
            ));

            if ($fimy_user_access > 0) {
              $fimy_appoptions = $vt->listele("fimy_appoptions");
              if ($fimy_appoptions != null) foreach ($fimy_appoptions as $app) {
                $onek = $app['Onek'];
                $firmaAdi = $app['FirmaAdi'];
              }
              $onekFirmaAdi = str_replace(' ', '', $onek) . '.' . str_replace(' ', '', $firmaAdi);
              $onekFirmaAdi = strtolower($onekFirmaAdi);
              $qrCodeUrl   = $ga->getQRCodeGoogleUrl($username, $uniquesecret, $onekFirmaAdi);

              // Mail AT
              $usernamemail = $username;
              include("../src/fi-mailer.php");
              $to = $mail;
              $subject = $usernamemail.' Kullanıcınız başarıyla oluşturuldu. | Fi Slash Software';
              $message = 'Merhaba ' . $adi . ' ' . $soyadi . ',<br><br>
                          <p>Fi My üzerinde kullanıcınız başarıyla oluşturulmuştur, login sırasında kullanabilmek için Google Authenticator uygulamasına kayıt olmak için aşağıdaki QR kodu uygulama üzerinden tanıtmanız gerekmektedir.</p><br>
                          <b>URL.: </b> fi.fislash.com.tr <br>
                          <b>Kullanıcı Adı.: </b> ' . $usernamemail . '<br>
                          <b>Şifre.: </b> <i>Telefon Numaranıza özel olarak iletilmiştir.</i>
                          <br><br>
                          <center>
                          <b> Google Authenticator QR Code </b><br>
                          <img src="' . $qrCodeUrl . '">
                          </center>
                          <br><br>
                          İyi günler.';


              $MailResponse = sendEmail($to, $subject, $message);

              echo '<script>
                            Swal.fire({ title: "Başarılı!", text: "Kullanıcı başarıyla eklendi! ##  ' . $MailResponse . '", icon: "success" });
                            setTimeout(function() {
                                window.location = "./users.php";
                              }, 1000);
                                </script>';
            } else {
              echo '<script>toastr["error"]("Kullanıcı eklenirken sistem hatası oluştu..FiMy0065013 - InsertUser03");</script>';
            }
          } else {
            echo '<script>toastr["error"]("Kullanıcı eklenirken sistem hatası oluştu..FiMy0065012 - InsertUser02");</script>';
          }
        } else {
          echo '<script>toastr["error"]("Kullanıcı eklenirken sistem hatası oluştu..FiMy0065011 - InsertUser01");</script>';
        }
      } else {
        //echo "Şifre geçerli değil.";
        echo '<script>toastr["error"]("Şifre Gereksinimleri karşılamıyor.. (Minimum 8 Karakter, en az 1 özel karakter, en az 1 rakam, en az 1 büyük, 1 küçük harf içermelidir.)");</script>';
      }
    }
  } else if ($islem == 2) {
  } else {
  }
}

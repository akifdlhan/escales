<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {

    setlocale(LC_TIME, "turkish");
    setlocale(LC_ALL, 'turkish');
    //$smstoken = strtolower($smstoken);
    $ID = $userid;
    $sorgu = $vt->ozellistele("select count(ap.ID) as Say, ud.Resim, ap.ID, ap.kullaniciadi,ap.Sifre, ap.Aktif, ap.smstoken, ua.Access_Level, ud.Adi, ud.Soyadi, ud.Mail, ud.TelefonNo
        from fimy_user ap, fimy_user_access ua, fimy_access_group ag, fimy_user_details ud
        where
        (ap.ID = ud.User_ID)
        and (ap.ID = ua.User_ID)
        and (ua.Access_Level = ag.Level)
        and ap.ID={$ID}");
    if ($sorgu != null) foreach ($sorgu as $satir) {
        $username1 = strtolower($satir['kullaniciadi']);
        $say = $satir['Say'];
        //Session Start
        setcookie("MyCookieFi", $satir['ID'], 0);
        $_SESSION['KID'] = $satir['ID'];
        $_SESSION['KADI'] = $satir['kullaniciadi'];
        $_SESSION['aktif'] = $satir['Aktif'];
        $_SESSION['adi'] = $satir['Adi'];
        $_SESSION['soyadi'] = $satir['Soyadi'];
        $_SESSION['yetki'] = $satir['Access_Level'];

        //Session End
    }
    if ($say > 0) {

        require_once '../src/googleLib/GoogleAuthenticator.php';
        $ga = new GoogleAuthenticator();
        $checkResult = $ga->verifyCode($token, $smstoken, 2);    // 2 = 2*30sec clock tolerance
        if ($checkResult) {
            $Ci = $_SERVER['REMOTE_ADDR'];
            $UserIPUpdt = $vt->guncelle("fimy_user", array("ClientIP" => $Ci), "ID={$satir['ID']}");
            echo '
                <style>
                .authentication-bg {
                display: none;
                text-align: center;
                }
                </style>
                ';
            $_SESSION['googleCode'] = $token;
            echo "<script>window.location = './fpanel'</script>";
            echo $WeatherUpdate."<br>Doğrulama Başarılı.";

            exit;
        } else {
            echo "<script>window.location = './index.php'</script>";
            exit;
        }
    } else {
        echo '<button id="login" class="btn btn-primary" type="submit"> Giriş </button>';
    }
}

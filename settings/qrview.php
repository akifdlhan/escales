<!-- App favicon -->
<link rel="shortcut icon" href="../assets/images/logo-sm.png">
<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani(); 
if($_GET){
    $ID = $_GET['ID'];
    $fimy_username = $vt->listele("fimy_user","where ID='".$ID."'");
    if($fimy_username != null) foreach( $fimy_username as $uname ) {
            $user = $uname['kullaniciadi'];
            $secret = $uname['smstoken'];
    }

    $fimy_appoptions = $vt->listele("fimy_appoptions");
    if($fimy_appoptions != null) foreach( $fimy_appoptions as $app ) {
            $onek = $app['Onek'];
            $firmaAdi = $app['FirmaAdi'];
            
    }
    $onekFirmaAdi = str_replace(' ', '', $onek) . '.' . str_replace(' ', '', $firmaAdi);
    $onekFirmaAdi = strtolower($onekFirmaAdi);
    require_once '../src/googleLib/GoogleAuthenticator.php';
    $ga = new GoogleAuthenticator();
    $qrCodeUrl 	= $ga->getQRCodeGoogleUrl($user, $secret,$onekFirmaAdi);
    ?>
    <title> <?php echo $user." Google Authenticator QR Code"; ?> </title>
    <body style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;"
bgcolor="#f6f6f6">

<table class="body-wrap"
style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"
bgcolor="#f6f6f6">
<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
    valign="top"></td>
<td class="container" width="600"
    style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
    valign="top">
    <div class="content"
         style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
        <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope
               itemtype="http://schema.org/ConfirmAction"
               style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
               >
            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                <td class="content-wrap"
                    style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;padding: 30px;border: 3px solid #4fc6e1;border-radius: 7px; background-color: #fff;"
                    valign="top">
                    <meta itemprop="name" content="Confirm Email"
                          style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>
                    <table width="100%" cellpadding="0" cellspacing="0"
                           style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr>
                            <td style="text-align: center">
                                <a href="#" style="display: block;margin-bottom: 10px;"> <img src="<?php echo $qrCodeUrl; ?>" alt="<?php echo $user; ?>"/></a> <br/>
                            </td>
                        </tr>
                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-block"
                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                valign="top">
                                <center>
                                    <p> Uygulamaları aşağıdaki linklerden indirebilirsiniz.. </p>

                                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en_US">Google Authenticator - Google Play</a> <br>
                                <a href="https://apps.apple.com/us/app/google-authenticator/id388497605">Google Authenticator - Apple App Store</a>
                                </center>
                            </td>
                        </tr>
                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-block"
                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                valign="top">
                            </td>
                        </tr>
                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-block" itemprop="handler" itemscope
                                itemtype="http://schema.org/HttpActionHandler"
                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                valign="top">
                                <center> <a href="users.php" class="btn-primary" itemprop="url"
                                   style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #be1622; margin: 0; border-color: #be1622; border-style: solid; border-width: 8px 16px;">
                                Kullanıcılar
                                </a> </center>
                            </td>
                        </tr>
                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-block"
                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                valign="top">
                                <center> <b>Fi Slash Software</b> </center> 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="footer"
             style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
            <table width="100%"
                   style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td class="aligncenter content-block"
                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                        align="center" valign="top"><a href="#"
                                                       style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;"></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</td>
<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
    valign="top"></td>
</tr>
</table>
</body>

    <?php
}else{
    echo '<script>
                            Swal.fire({ title: "Hata!", text: "Başarısız İstek!", icon: "warning" });
                            setTimeout(function() {
                                window.location = "./users.php";
                              }, 1000);
                                </script>';
}
?>
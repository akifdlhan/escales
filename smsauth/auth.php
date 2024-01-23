<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    $username = strtolower($username);
    $pass = md5($pass);
    $sorgu = $vt->ozellistele("select ID,kullaniciadi,Sifre,smstoken,ClientIP, count(ID) as Say  from fimy_user ap where Aktif=1 and kullaniciadi = '" . $username . "'");
    if ($sorgu != null) foreach ($sorgu as $satir) {
        $username1 = strtolower($satir['kullaniciadi']);
        $satsifre = $satir['Sifre'];
        $say = $satir['Say'];
        $ID = $satir['ID'];
        $token = $satir['smstoken'];
        $ClientIP = $satir['ClientIP'];
    }
    if ($say > 0) {
        if ($satsifre == $pass) {
            $Ci = $_SERVER['REMOTE_ADDR'];
            if ($Ci == $ClientIP) {

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
                    setcookie("MyCookieFi", $satir['ID'], time() + 0);
                    $_SESSION['KID'] = $satir['ID'];
                    $_SESSION['KADI'] = $satir['kullaniciadi'];
                    $_SESSION['aktif'] = $satir['Aktif'];
                    $_SESSION['adi'] = $satir['Adi'];
                    $_SESSION['soyadi'] = $satir['Soyadi'];
                    $_SESSION['yetki'] = $satir['Access_Level'];

                    //Session End
                }
                echo "<script>window.location = './fpanel'</script>";
                echo "<br>Doğrulama Başarılı.";
            } else {


?>
                <div class="mb-3">
                    <input type="hidden" name="userid" id="userid" value="<?php echo $ID; ?>">
                    <input type="hidden" name="token" id="token" value="<?php echo $token; ?>">
                    <label for="smstoken" class="form-label">Google Authenticator Code</label>
                    <input class="form-control" type="username" id="smstoken1" required="" placeholder="Google Authenticator Code">
                </div>
                <div id="dogrulama" class="mb-3 d-grid text-center">
                    <button id="dogrula" class="btn btn-primary" type="submit"> Doğrula </button>
                </div>

                <script>
                    $("#smstoken1").focus();
                    $('#smstoken1').keypress(function(event) {
                        if (event.keyCode === 13) {
                            ds = "smstoken=" + $("#smstoken1").val() + "&userid=" + $("#userid").val() + "&token=" + $("#token").val();
                            console.log(ds);
                            $.ajax({
                                url: 'smsauth/validate.fi',
                                type: 'POST',
                                data: ds,
                                success: function(e) {
                                    $("div#smstoken").html("").html(e);
                                }
                            });
                        }
                    });
                    $("#dogrula").on("click", function() {
                        ds = "smstoken=" + $("#smstoken1").val() + "&userid=" + $("#userid").val() + "&token=" + $("#token").val();
                        console.log(ds);
                        $.ajax({
                            url: 'smsauth/validate.fi',
                            type: 'POST',
                            data: ds,
                            success: function(e) {
                                $("div#smstoken").html("").html(e);
                            }
                        });
                    });
                </script>
<?php
            }
        } else {
            echo '<script>toastr["error"]("Şifre yanlış.");</script>';
            echo '<button id="login" class="btn btn-primary" type="submit"> Giriş </button>';
            echo '<script>
                $("#login").on("click",function(){
                    $("#kullaniciadi").attr("disabled","disabled"); 
                   // $("#sifre").attr("disabled","disabled"); 
                
                ds="username="+$("#kullaniciadi").val()+"&pass="+$("#sifre").val();
                $.ajax({
                    url:"smsauth/auth.fi", 
                    type:"POST", 
                    data:ds,
                    success:function(e){ 
                        $("div#smstoken").html("").html(e);
                    }
                });
            });
                        </script>';
        }
    } else {
        echo "Kullanıcı adı yanlış";
    }
}
?>
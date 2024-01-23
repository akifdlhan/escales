<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani();

	if($_GET){      
        $Level = $_GET['Level'];
        if($Level == 0 || $Level == 1){
            echo '<script>
                           alert("Sistem kullanıcıları silinemez..");
                            setTimeout(function() {
                                window.location = "./usergroup.php";
                              }, 1000);
                                </script>';
        }else{
            $sayim = 0;
            $fimy_user_access = $vt->listele("fimy_user_access","WHERE Access_Level=".$Level."");
            if($fimy_user_access != null) foreach( $fimy_user_access as $fua ) {
                $sayim++;
            }
            if($sayim > 0){
                $guncelle = $vt->guncelle("fimy_user_access",array("Access_Level"=>1),"Access_Level=".$Level."");
            if($guncelle > 0 ){
                $delsonuc = $vt->sil("fimy_access_group","Level={$Level}");
                if($delsonuc > 0){
                    echo '<script>
                    window.location = "usergroup.php";
                    </script>';
                }else{
                    echo '<script>alert("Kullanıcı silinirken sistem hatası oluştu..FiMy0065023 - DelUser23");</script>';
                }
            }
            }else{
                $delsonuc = $vt->sil("fimy_access_group","Level={$Level}");
                if($delsonuc > 0){
                    echo '<script>
                    window.location = "usergroup.php";
                    </script>';
                }else{
                    echo '<script>alert("Kullanıcı silinirken sistem hatası oluştu..FiMy0065023 - DelUser23");</script>';
                }
            }

            
        }

	}
?>
<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani();
function dizinSil($dizin) {
    if (!is_dir($dizin)) {
        return;
    }

    $icerik = scandir($dizin);
    foreach ($icerik as $dosya) {
        if ($dosya != "." && $dosya != "..") {
            $dosyaYol = $dizin . '/' . $dosya;
            if (is_dir($dosyaYol)) {
                dizinSil($dosyaYol);
            } else {
                unlink($dosyaYol);
            }
        }
    }

    rmdir($dizin);
}
	if($_GET){
        //print_r($_GET);
        $MenuID = $_GET['unique'];
        if($_GET['action'] == 2){
            $fimy_menus = $vt->listele("fimy_menu","WHERE ID=".$MenuID."");
            if($fimy_menus != null) foreach( $fimy_menus as $menu ) {
                $url = $menu['url'];
            }
            dizinSil($url);
            // Delete İşlemleri
            
            $delsonuc = $vt->sil("fimy_menu","ID=".$MenuID." or parent_id=".$MenuID."");
            if($delsonuc > 0){
                echo '<script>
                    window.location = "menus.php";
                    </script>';
            } 


        }else if($_GET['action'] == 0){
            // Aktif Pasif İşlemleri - status
            $MenuID = $_GET['unique'];
            $status = $_GET['status'];
            $bir = md5(1);
            $sifir = md5(0);
            if($bir == $status){
                
                $updguncelle = $vt->guncelle("fimy_menu",array("statu"=>0),"ID=".$MenuID."");
                if($updguncelle > 0){
                    echo '<script>
                    window.location = "menus.php";
                    </script>';
                }else{
                    echo '<script>
                    window.location = "menus.php";
                    alert("Hatalı İşlem..");
                    </script>';
                }

            }else if($sifir == $status){

                $updguncelle = $vt->guncelle("fimy_menu",array("statu"=>1),"ID=".$MenuID."");
                if($updguncelle > 0){
                    echo '<script>
                    window.location = "menus.php";
                    </script>';
                }else{
                    echo '<script>
                    window.location = "menus.php";
                    alert("Hatalı İşlem..");
                    </script>';
                }

            }
        }else{

        }
		
	}
?>
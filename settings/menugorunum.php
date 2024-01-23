<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani();

	if($_GET){
        //print_r($_GET);
        $MenuID = $_GET['unique'];
        if($_GET['action'] == 0){
            // Aktif Pasif İşlemleri - status
            $MenuID = $_GET['unique'];
            $gorunum = $_GET['gorunum'];
            $bir = md5(1);
            $sifir = md5(0);
            if($bir == $gorunum){
                
                $updguncelle = $vt->guncelle("fimy_menu",array("Gorunum"=>0),"ID=".$MenuID."");
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

            }else if($sifir == $gorunum){

                $updguncelle = $vt->guncelle("fimy_menu",array("Gorunum"=>1),"ID=".$MenuID."");
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
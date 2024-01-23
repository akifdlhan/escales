<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){
    // $MenuID."--".$access;  
    $guncelle = $vt->guncelle("fimy_menu",array("access"=>$access),"ID=".$MenuID."");
    if($guncelle > 0){
      $count = $Toggle;
        if($count == "true"){
          $guncelle = $vt->guncelle("fimy_menu",array("access"=>$access),"parent_id=".$MenuID."");
          if($guncelle > 0){
            echo '<script>
                Swal.fire({ title: "Başarılı Yetkilendirme!", text: "Alt menüler ile beraber güncellenmiştir.!", icon: "success" });
                setTimeout(function() {
                    window.location = "./menus.php";
                  }, 1000);
                    </script>';
          }else{
            echo '<script>
                Swal.fire({ title: "Başarısız Yetkilendirme!", text: "Menü yetkisi güncellenememiştir.!", icon: "warning" });
                    </script>';
          }
        }else{
          echo '<script>
          Swal.fire({ title: "Başarılı Yetkilendirme!", text: "Menü yetkisi güncellenmiştir.!", icon: "success" });
          setTimeout(function() {
                    window.location = "./menus.php";
                  }, 1000);
                    </script>';
        }
         
    }else{

    }

	}
?>
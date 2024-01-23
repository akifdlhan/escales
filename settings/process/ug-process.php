<?php
session_start();
ob_start();
include("../../src/iconlibrary.php");
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){
		 //$islem;
        if($islem == 1){
              $fimy_access_group = $vt->ozellistele("select count(ID) as AccessAdi from fimy_access_group where Access_Adi='".$grupadi."'");
              if($fimy_access_group != null) foreach( $fimy_access_group as $uname ) {
                      $KSay = $uname['AccessAdi'];
              }
              if($KSay > 0){
                echo '<script>toastr["error"]("'.$grupadi.' İsimli kullanıcı grubu mevcut..");</script>';
              }else{
                
                $fimy_access_group = $vt->listele("fimy_access_group","ORDER BY Level DESC LIMIT 1");
                if($fimy_access_group != null) foreach( $fimy_access_group as $uname ) {
                        $Level = $uname['Level'];
                }

                $YeniGrupLeveli = $Level + 1;

                $usergroupadd = $vt->ekle("fimy_access_group",array("Level"=>$YeniGrupLeveli,"Access_Adi"=>$grupadi,"Access_Detay"=>$grupdetay));
                if($usergroupadd > 0){
                  echo '<script>
                    Swal.fire({ title: "Başarılı!", text: "Kullanıcı Grubu başarıyla eklendi!", icon: "success" });
                    setTimeout(function() {
                        window.location = "../settings/usergroup.php";
                      }, 1000);
                        </script>';

                }else{
                echo '<script>toastr["error"]("Kullanıcı Grubu eklenirken sistem hatası oluştu..FiMy0065033 - InsertUserGroup33");</script>';
                } 

              }
        }else if($islem == 2){
           
        }else{

        }
	}
?>
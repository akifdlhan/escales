<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){
		 //$islem;
        if($islem == 1){
              $oldpass = md5($oldpass);
              $count = 0;
              $fimy_user = $vt->listele("fimy_user","WHERE ID={$user} and Sifre='{$oldpass}'");
              if($fimy_user != null) foreach( $fimy_user as $fu ) {
                      $count++;
              } 
              if($count > 0){

                      $fimy_prules = $vt->listele("fimy_prules","WHERE ID=1");
                      if($fimy_prules != null) foreach( $fimy_prules as $pr ) {
                              $Min = $pr['Min'];
                              $Cust = $pr['Cust-charter'];
                              $Num = $pr['Num-req'];
                              $UpLow = $pr['UpLow-req'];
                              $Cust = ($Cust == true) ? "true" : "false";
                              $Num = ($Num == true) ? "true" : "false";
                              $UpLow = ($UpLow == true) ? "true" : "false";
                      }
                      //

                      if (checkPasswordStrength($npass, $Min, $Cust, $Num, $UpLow, $UpLow)) {
                        $npass = md5($npass);
                        $guncelle = $vt->guncelle("fimy_user",array("Sifre"=>$npass,"Sonsifre"=>$oldpass),"ID=".$user."");
                        if($guncelle > 0){
                          echo '<script>
                            Swal.fire({ title: "Başarılı!", text: "Şifre başarıyla güncellenmiştir!", icon: "success" });
                            setTimeout(function() {
                                window.location = "./profil.php";
                              }, 1000);
                                </script>';
                        }else{
                          echo '<script>
                            Swal.fire({ title: "Hata!", text: "Şifre güncellenemedi, sistem hatası!(NewPassword006501)", icon: "error" });
                            setTimeout(function() {
                                window.location = "./profil.php";
                              }, 1000);
                                </script>';
                        }

                      }else{
                    echo '<script>toastr["error"]("Şifre Gereksinimleri karşılamıyor.. \n (Minimum '.$Min.' Karakter \n Özel karakter:'.$Cust.'\n Rakam:'.$Num.'\n Büyük-Küçük Harf:'.$UpLow.'.)");</script>';
                      }

              }else{

              }
            
        }else if($islem == 2){
            
        }else{

        }
	}
?>
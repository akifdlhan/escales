<?php
include("../src/iconlibrary.php");
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){
        // $User
	// $pass
	// $IDNo
	// $name
	// $sname
	// $tel
	// $mail
	// $adres
	// $useryetki
        
             if(empty($company) ||
                empty($name) ||
                empty($surname) ||
                empty($tel) ||
                empty($tel2) ||
                empty($mail) ||
                empty($adres)){
                        echo '<br><div class="alert alert-danger" role="alert">
                        There is one or more empty fields.
                      </div>';
                }else{
                        //echo $company;
                        //echo $name;
                        //echo $surname;
                        //echo $tel;
                        //echo $tel2;
                        //echo $mail;
                        //echo $adres;
                $guncelle = $vt->guncelle("fimy_appoptions",array("FirmaAdi"=>$company,"YetkiliAdi"=>$name,"YetkiliSoyadi"=>$surname,"Telefon"=>$tel,"Telefon2"=>$tel2,"Mail"=>$mail,"Adres"=>$adres),"ID=1");
                if($guncelle > 0)
                {
                        echo '<script> toastr["success"]("App Firma Bilgileri Başarıyla Güncellendi..");
                        setTimeout(function(){window.location.assign("");}, 1000);
                        </script>';
                       // echo '<script>toastr["success"]("App Firma Bilgileri Başarıyla Güncellendi..");</script>';
                }else{
                        echo '<script>toastr["error"]("Bilgiler güncellenirken sistem hatası oluştu..FiMy0065024 - FiUpApp24");</script>';
                }              



                }
             


            
        }//post parantezi
?>
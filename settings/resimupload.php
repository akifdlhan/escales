<?php
require('../src/class.upload.php');
include("../src/iconlibrary.php");
$vt = new veritabani();
if (isset($_FILES['dosya'])) {
	
        $image = new \Verot\Upload\Upload($_FILES['dosya']);
                    
                    $today = date("Y");
                    $t = md5($today);
                    $r = rand(0,99);
                    $r1 = md5($r);
                    $t=substr($t,0,3);
                    $rt=substr($r1,0,3);
                    $ad = $image->file_new_name_body = 'ih_'.$rt;
                    $image->file_max_size = '5000000';
                    //$image->image_resize = true;
                    $image->image_ratio_crop = true;
                    $image->image_x = 320;
                    $image->image_y = 170;
                    $image->png_compression = 9;
                    $image->allowed = array ( 'image/png' );
                    $image->Process( '../assets/images/app' );
                    
    
            if ( $image->processed ){
                $Son = $image->file_dst_path.$ad.".png";
                $sor = $vt->listele("fimy_appoptions","WHERE ID=1");
                if($sor != null) foreach( $sor as $s ) {
                        $ID =  $s['ID'];
                        }
                $guncelle = $vt->guncelle("fimy_appoptions",array("Logo"=>$Son,"LogoSmall"=>$Son),"ID=".$ID."");
                if($guncelle > 0)
                {
                        echo '<script> 
                        toastr["success"]("Logo Başarıyla Güncellendi..");
                        setTimeout(function(){window.location.assign("");}, 1000);
                        </script>';
                }else{
                        echo '<script> toastr["error"]("Logo güncellenirken sistem hatası oluştu..FiMy0065025 - FiLogoApp25"); </script>';
                }
                
            } else {
                //echo 'Bir sorun oluştu: '.$image->error;
                echo '<script> toastr["error"]("Logo güncellenirken sistem hatası oluştu\n'.$image->error.'..FiMy0065026 - FiLogoApp26"); </script>';
               // echo '<script> swal("Not Update Logo", "'.$image->error.'", "error"); </script>';
            }
    }

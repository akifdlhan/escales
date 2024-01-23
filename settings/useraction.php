<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani();

	if($_GET){
        //print_r($_GET);
        $UserID = $_GET['ID'];
            echo $delsonuc = $vt->sil("fimy_user_access","User_ID={$UserID}");
            if($delsonuc > 0){
                $del = $vt->sil("fimy_user_details","User_ID={$UserID}");
                if($del > 0){
                    $dela = $vt->sil("fimy_user","ID={$UserID}");
                    if($del > 0){
                        echo '<script>
                        window.location = "users.php";
                        </script>';
                    }else{
                        echo '<script>toastr["error"]("Kullanıcı silinirken sistem hatası oluştu..FiMy0065023 - DelUser23");</script>';
                    }
                }else{
                    echo '<script>toastr["error"]("Kullanıcı silinirken sistem hatası oluştu..FiMy0065022 - DelUser22");</script>';
                }
            }else{
                echo '<script>toastr["error"]("Kullanıcı silinirken sistem hatası oluştu..FiMy0065021 - DelUser21");</script>';
            }
	}
?>
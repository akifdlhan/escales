<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
  if ($islem == 1) {


    $guncelle = $vt->guncelle("fimy_notice", array("desco" => $desc, "Title" => $title, "User" => $user), "ID=1");
    if ($guncelle > 0) {
      echo '<script>
                Swal.fire({ title: "Aktif/Pasif!", text: "İşlem Tamamlandı!", icon: "success" });
                setTimeout(function() {
                    window.location = "./notice.php";
                  }, 1000);
                    </script>';
    } else {
      // echo '<script>
      //           Swal.fire({ title: "Alanları Kontrol Edin!", text: "İşlem Tamamlanamadı!", icon: "warning" });
      //           setTimeout(function() {
      //               window.location = "./notice.php";
      //             }, 1000);
      //               </script>';
    }
  } else if ($islem == 2) {
    ($active == "true") ? $s = "1" : $s = "0";
    $guncelle = $vt->guncelle("fimy_notice", array("Statu" => $s), "ID=1");
    if ($guncelle > 0) {
      // echo '<script>
      //           Swal.fire({ title: "Aktif/Pasif!", text: "İşlem Tamamlandı!", icon: "success" });
      //           setTimeout(function() {
      //               window.location = "./notice.php";
      //             }, 1000);
      //               </script>';
    } else {
      // echo '<script>
      //           Swal.fire({ title: "Alanları Kontrol Edin!", text: "İşlem Tamamlanamadı!", icon: "warning" });
      //           setTimeout(function() {
      //               window.location = "./notice.php";
      //             }, 1000);
      //               </script>';
    }
  } else {
  }
}

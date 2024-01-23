<?php

include("../src/iconlibrary.php");


$vt = new veritabani();
$sehir = "istanbul";
$result = updateWeatherInDatabase($sehir, $vt);

if ($result) {
      //echo "Hava durumu bilgileri başarıyla güncellendi.";
      echo '<script>
      window.location = "../fpanel";
      </script>';
} else {
      //echo "Hava durumu bilgileri güncellenirken bir hata oluştu.";
}

<?php
include("../../src/iconlibrary.php");
require '../../src/private_custom.php';
$vt = new veritabani();
$fislash = new fislash();
extract($_POST);
if ($_GET) {
    $UrunID = $_GET['ID'];
    $UserID = $_GET['UserID'];
    $stok = 0;
    $fimy_urun_stok_depo = $vt->ozellistele("SELECT usd.*, depo.depo_adi FROM fimy_urun_stok_depo usd, fimy_depolar depo WHERE usd.bulundugu_depo=depo.ID and usd.UrunID={$UrunID};");
    if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
        $bulundugu_depo = $usd['depo_adi'];
        $stok_miktari = $usd['stok_miktari'];
        $stok = $stok + $stok_miktari;
        
    }
    $log =  $UrunID." ID'li ".$_GET['Adi']." isimli ürün için bulunan " . $stok . " adet stok ve ürün kayıdı silindi..";

    $fimy_urun_stok_depo = $vt->ekle("fimy_stok_log", array("UrunID" => $UrunID, "UserID" => $UserID, "Log" => $log));

    $silUrun = $vt->sil("fimy_urunler", "ID = {$UrunID}");
    $silUrunFiyat = $vt->sil("fimy_urun_fiyat", "UrunID = {$UrunID}");
    $silUrunStok = $vt->sil("fimy_urun_stok_depo", "UrunID = {$UrunID}");

    echo '<script>
    //toastr["success"]("Başarıyla stok silindi..");
    
    setTimeout(function() {
        window.location.href = "../../stok-yonetimi/urunler.php";
    }, 800);
                                    </script>';
}

<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_GET) {
    $usdID = $_GET['usdID'];
    $UserID = $_GET['UserID'];
    $fimy_urun_stok_depo = $vt->ozellistele("SELECT usd.*, depo.depo_adi FROM fimy_urun_stok_depo usd, fimy_depolar depo WHERE usd.bulundugu_depo=depo.ID and usd.ID={$usdID};");
    if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
        $bulundugu_depo = $usd['depo_adi'];
        $stok_miktari = $usd['stok_miktari'];
        $UrunID = $usd['UrunID'];
        $log = $bulundugu_depo . " isimli depoda bulunan " . $stok_miktari . " adet stok silindi..";
    }
    
    $fimy_urun_stok_depo = $vt->ekle("fimy_stok_log", array("UrunStokDepo" => $usdID, "UserID" => $UserID, "Log" => $log));

    $silStok = $vt->sil("fimy_urun_stok_depo", "ID = {$usdID}");
    echo '<script>
    //toastr["success"]("Başarıyla stok silindi..");
    
    setTimeout(function() {
        window.location.href = "../../stok-yonetimi/urun-karti.fi?UrunID='.$UrunID.'";
    }, 800);
                                    </script>';
    
}



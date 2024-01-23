<?php
include("../../src/iconlibrary.php");
require '../../src/private_custom.php';
$vt = new veritabani();
$fislash = new fislash();
extract($_POST);
if ($_POST) {
    // usdID
    // StokMiktari
    $fimy_urun_stok_depo = $vt->guncelle("fimy_urun_stok_depo", array(
        "stok_miktari" => $StokMiktari
    ), "ID={$usdID}");
    if ($fimy_urun_stok_depo > 0) {
        $fimy_urun_stok_depo = $vt->ekle("fimy_stok_log", array("UrunStokDepo" => $usdID, "UserID" => $UserID, "Log" => "Stok Miktarı Güncellendi, yeni stok.: ".$StokMiktari));
        $response[] = array('status' => 'success', 'message' => 'Stok başarıyla güncellendi..', 'refresh' => 1);
        echo json_encode($response);
    }
}

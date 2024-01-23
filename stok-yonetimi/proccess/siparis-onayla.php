<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    // siparisFormID - kullanici

    $fimy_siparis_formu = $vt->listele("fimy_siparis_formu", "WHERE ID={$siparisFormID}");
    if ($fimy_siparis_formu != null) foreach ($fimy_siparis_formu as $frm) {
        $siparisNo = $frm['SiparisNo']; 
    }
    //echo $UrunIDS." >>> ".$DepoStokAdet." adet üründen ".$SiparisFormuAdet ." çıkış yapılacak ve Depoda ".$DepoStokAdetNew." stok kalacaktır..";

    $LogText = "{$siparisNo} numaralı sipariş, {$kullanici} ID'li kullanıcı tarafından onaylanmıştır.";
    $fimy_stok_log = $vt->ekle("fimy_stok_log", array("UserID" => $kullanici, "LogTuru" => 2, "Log" => $LogText));

    if ($fimy_stok_log > 0) {
        $fimy_siparis_formu = $vt->guncelle("fimy_siparis_formu", array(
            "TeslimDurumu" => 1,
            "Onay" => 2,
            "TeslimTarihi" => date("Y-m-d")
        ), "ID={$siparisFormID}");
    }

    if ($fimy_stok_log > 0) {
        $response[] = array('status' => 'success', 'message' => 'Sipariş başarıyla onaylanmıştır..', 'refresh' => 1);
        echo json_encode($response);
    }
}

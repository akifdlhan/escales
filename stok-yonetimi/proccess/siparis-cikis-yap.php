<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    // onylCikisYap = 'UrunSfID=' + sfurunID + '&CikisYapacak=' + CikisYapacak;
    $fimy_sf_urun = $vt->listele("fimy_sf_urun", "WHERE ID in ({$UrunSfID})");
    if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sfurun) {

        $SiparisID = $sfurun['SiparisFormID'];
        $SfurunID = $sfurun['ID'];
        $UrunIDS = $sfurun['UrunID'];
        $SiparisFormuAdet = $sfurun['Adet'];

        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE UrunID={$UrunIDS} and bulundugu_depo={$CikisYapacak}");
        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $sd) {
            $UrunStokDepoID = $sd['ID'];
            $DepoStokAdet = $sd['stok_miktari'];
        }

        $DepoStokAdetNew = $DepoStokAdet - $SiparisFormuAdet;

        //echo $UrunIDS." >>> ".$DepoStokAdet." adet üründen ".$SiparisFormuAdet ." çıkış yapılacak ve Depoda ".$DepoStokAdetNew." stok kalacaktır..";

        $LogText = "{$SiparisID} Sipariş için {$CikisYapacak} ID'li depodan, {$DepoStokAdet} adet stoktan {$SiparisFormuAdet} adet sipariş için düşürülmüştür.";
        $fimy_stok_log = $vt->ekle("fimy_stok_log", array("UrunStokDepo" => $UrunStokDepoID, "UrunID" => $UrunIDS, "DepoID" => $CikisYapacak, "UserID" => 4, "LogTuru" => 2, "Log" => $LogText));

        if ($fimy_stok_log > 0) {
            $fimy_urun_stok_depo = $vt->guncelle("fimy_urun_stok_depo", array(
                "stok_miktari" => $DepoStokAdetNew
            ), "ID={$UrunStokDepoID}");

            $fimy_siparis_formu = $vt->guncelle("fimy_sf_urun", array(
                "CikisYapilanDepo" => $CikisYapacak,
                "CikisDurumu" => 1
            ), "ID={$SfurunID}");
            
        } 
    }
    if($fimy_stok_log > 0){
        $response[] = array('status' => 'success', 'message' => 'Ürün çıkışı yapılmıştır..', 'refresh' => 1);
        echo json_encode($response);
    }
}

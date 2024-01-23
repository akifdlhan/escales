<?php
require('../../src/class.upload.php');
include("../../src/iconlibrary.php");
require '../../src/private_custom.php';
$vt = new veritabani();
$fislash = new fislash();
extract($_POST);
if ($_POST) {
    // print_r($_POST);
    if ($AliciDepo == 0 || $urunID == 0 || empty($aktarimAdet)) {
        $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut lütfen kontrol ediniz..', 'refresh' => 0);
        echo json_encode($response);
    } else {
        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE UrunID={$urunID} and bulundugu_depo={$CikisDepoID}");
        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
            $DepodakiSayi = $usd['stok_miktari'];
        }

        if ($DepodakiSayi < 0) {
            $response[] = array('status' => 'error', 'message' => 'Seçilen ürün bu depoda mevcut değildir..', 'refresh' => 0);
            echo json_encode($response);
        } else if ($DepodakiSayi < $aktarimAdet) {
            $response[] = array('status' => 'error', 'message' => 'Seçilen ürün bu depoda yeterli stok mevcut değildir..', 'refresh' => 0);
            echo json_encode($response);
        } else if ($DepodakiSayi >= $aktarimAdet) {
            $Statu = 0;
            // Depodaki stok miktari güncelle
            $DepodaKalacak = $DepodakiSayi - $aktarimAdet;
            if ($DepodaKalacak <= 0) {
                $fimy_urun_stok_depo_sil = $vt->sil("fimy_urun_stok_depo", "UrunID={$urunID} and bulundugu_depo={$CikisDepoID}");
            } else {
                $fimy_urun_stok_depo = $vt->guncelle("fimy_urun_stok_depo", array("stok_miktari" => $DepodaKalacak), "UrunID={$urunID} and bulundugu_depo={$CikisDepoID}");
            }

            // Depodaki stok miktari güncelle - end
                $Statu = 1;
            if ($Statu == 1) {

                $fimy_depo_transfer = $vt->ekle("fimy_depo_transfer", array("miktar" => $aktarimAdet, "urun_id" => $urunID, "depo_cikis_id" => $CikisDepoID, "depo_giris_id" => $AliciDepo));
                if ($fimy_depo_transfer > 0) {
                    $response[] = array('status' => 'success', 'message' => 'Ürün aktarım talebi oluşturuldu. \n Aktarılacak depo sorumlusuna bilgi verebilirsiniz..', 'refresh' => 1);
                    echo json_encode($response);
                }
            } else if ($Statu == 0) {
            } else {
            }
        }
    }
}

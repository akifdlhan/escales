<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    if (!is_numeric($adet) || floor($adet) != $adet) {
        $response[] = array('status' => 'warning', 'message' => 'Adet değişkeni küsüratlı girildiyse tam değer giriniz.', 'refresh' => 0);
        echo json_encode($response);
    } else {
        $deposayimi = 0;
        $stok_miktari = 0;
        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE UrunID={$UrunID} and bulundugu_depo={$depolar}");
        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
            $deposayimi++;
            $stok_miktari = $usd['stok_miktari'] + $stok_miktari;
        }

        if ($deposayimi > 0) {
            // Update
            $stok_miktari = $adet + $stok_miktari;
            $fimy_urun_stok_depo = $vt->guncelle("fimy_urun_stok_depo", array("stok_miktari" => $stok_miktari), "UrunID={$UrunID} and bulundugu_depo={$depolar}");
            if ($fimy_urun_stok_depo > 0) {
                $response[] = array('status' => 'success', 'message' => 'Stok Ekleme başarılı..', 'refresh' => 1);
                echo json_encode($response);
            } else {
                $response[] = array('status' => 'error', 'message' => 'Stok Ekleme başarısız..', 'refresh' => 0);
                echo json_encode($response);
            }
        } else {
            // Insert
            $fimy_urun_stok_depo = $vt->ekle("fimy_urun_stok_depo", array(
                "UrunID" => $UrunID,
                "stok_miktari" => $adet,
                "bulundugu_depo" => $depolar
            ));

            if ($fimy_urun_stok_depo > 0) {
                $response[] = array('status' => 'success', 'message' => 'Stok Ekleme başarılı..', 'refresh' => 1);
                echo json_encode($response);
            } else {
                $response[] = array('status' => 'error', 'message' => 'Stok Ekleme başarısız..', 'refresh' => 0);
                echo json_encode($response);
            }
        }
    }
}

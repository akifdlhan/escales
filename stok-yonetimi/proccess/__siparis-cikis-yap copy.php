<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    /*
    cikisdepo
    SiparisID
    OdemeTipi
    OnOdeme
    Kasa
    KalanTutar
    
    */
    $OdemeTipi = 2;
    $OnOdeme = 0;
    $Kasa = 1;
    $fimy_sf_urun = $vt->listele("fimy_sf_urun", "WHERE SiparisFormID={$SiparisID}");
    if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sfurun) {

        $UrunIDS = $sfurun['UrunID'];
        $SiparisFormuAdet = $sfurun['Adet'];

        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE UrunID={$UrunIDS} and bulundugu_depo={$cikisdepo}");
        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $sd) {
            $UrunStokDepoID = $sd['ID'];
            $DepoStokAdet = $sd['stok_miktari'];
        }

        $DepoStokAdetNew = $DepoStokAdet - $SiparisFormuAdet;

        //echo $UrunIDS." >>> ".$DepoStokAdet." adet üründen ".$SiparisFormuAdet ." çıkış yapılacak ve Depoda ".$DepoStokAdetNew." stok kalacaktır..";
        $LogText = "{$SiparisID} Sipariş için {$cikisdepo} ID'li depodan, {$DepoStokAdet} adet stoktan {$SiparisFormuAdet} adet sipariş için düşürülmüştür.";
        $fimy_stok_log = $vt->ekle("fimy_stok_log", array("UrunStokDepo" => $UrunStokDepoID, "UrunID" => $UrunIDS, "DepoID" => $cikisdepo, "UserID" => 4, "LogTuru" => 2, "Log" => $LogText));
    }
    if ($fimy_stok_log > 0) {

        $fimy_urun_stok_depo = $vt->guncelle("fimy_urun_stok_depo", array(
            "stok_miktari" => $DepoStokAdetNew
        ), "ID={$UrunStokDepoID}");

        $fimy_siparis_formu = $vt->guncelle("fimy_siparis_formu", array(
            "TeslimDurumu" => 1,
            "Onay" => 2,
            "TeslimTarihi" => date("Y-m-d")
        ), "ID={$SiparisID}");

        $fimy_siparis_butce = $vt->guncelle("fimy_siparis_butce", array(
            "OdemeTipi" => $OdemeTipi,
            "OnOdeme" => $OnOdeme,
            "KalanOdeme" => $KalanTutar,
            "Kasa" => $Kasa,
            "OdemeTarihi" => date("Y-m-d H:i:s")
        ), "SiparisID={$SiparisID}");


        $fimy_siparis_formu = $vt->listele("fimy_siparis_formu", "WHERE ID={$SiparisID}");
        if ($fimy_siparis_formu != null) foreach ($fimy_siparis_formu as $siparisf) {
            $MusID = $siparisf['MusteriID'];
            $SiparisNo = $siparisf['SiparisNo'];
        }
        $Aciklama = $SiparisNo . " numaralı sipariş";
        /// Borç Cari - Başlangıç
        $ParaBirimi = 2;
        // $MusID = 0;
        $TutarB = $KalanTutar - $OnOdeme;
        $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=1");
        if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $B) {
            $Borc = $B['Tutar'];
        }
        $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=2");
        if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $B) {
            $Alacak = $B['Tutar'];
        }


        //Müsteri Bilgi Alanı
        $icrm_musterikarti = $vt->listele("fimy_cari_hesapkarti", "WHERE PID={$MusID}");
        if ($icrm_musterikarti != null) foreach ($icrm_musterikarti as $M) {
            $BorcLimit = $M['BorcLimit'];
        }
        //Müsteri Bilgi Alanı Bitiş
        //echo $BorcLimit;
        if ($BorcLimit < $TutarB) {
            $response[] = array('status' => 'error', 'message' => 'Girilen Tutar Borç Limitinden Yüksek!', 'refresh' => 0);
            echo json_encode($response);
            exit;
        } else {

            (float)$EldeKalan = (float)$TutarB - (float)$Alacak;
            if ($EldeKalan == 0) {
                $BorcGuncelle = 0;
                $AlacakGuncelle = 0;
            } else if ($EldeKalan > 0) {
                $AlacakGuncelle = 0;
                $BorcGuncelle = $EldeKalan + $Borc;
            } else if ($EldeKalan < 0) {
                $EldeKalan = abs($EldeKalan);
                $BorcGuncelle = 0;
                $AlacakGuncelle = $EldeKalan + $Alacak;
            } else {
            }

            // BorcAlacak + TutarB Alanı Bitiş
            $dovizcifti = 1;
            $fimy_dovizcifti = $vt->listele("fimy_dovizcifti", "WHERE PB1={$ParaBirimi}");
            if ($fimy_dovizcifti != null) foreach ($fimy_dovizcifti as $df) {
                $dovizcifti = $df['ID'];
            }
            $fimy_dovizkurlari = $vt->listele("fimy_dovizkurlari", "WHERE DovizID={$dovizcifti}");
            if ($fimy_dovizkurlari != null) foreach ($fimy_dovizkurlari as $dk) {

                $aliskuru = $dk['Alis'];
                $satiskuru = $dk['Satis'];
            }

            // Hareket Tablosuna Ekleme
            // Tur : 1 - Borc 2 - Alacak
            $icrm_bahareket = $vt->ekle("fimy_ba_hareket", array(
                "MID" => $MusID,
                "BorcAlacak" => 1,
                "Tutar" => $TutarB,
                "ParaBirimi" => $ParaBirimi,
                "Kur" => $satiskuru,
                "Aciklama" => $Aciklama
            ));
            // Hareket Tablosuna Ekleme End

            // Hareket tablosuna göre Borç ve Alacak güncelleme
            if ($icrm_bahareket > 0) {

                // Tur : 1 - Borc 2 - Alacak
                $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $BorcGuncelle), "MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=1");
                $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $AlacakGuncelle), "MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=2");

                $response[] = array('status' => 'success', 'message' => 'Sipariş Çıkışı Yapıldı ve Borç eklendi..', 'refresh' => 1);
                echo json_encode($response);
            } else {
                $response[] = array('status' => 'error', 'message' => 'Girilen Tutar Borç Limitinden Yüksek!', 'refresh' => 0);
                echo json_encode($response);
                exit;
            }
            // Hareket tablosuna göre Borç ve Alacak güncelleme End

        }
        /// Borç Cari - Bitiş


    }
    // echo $UrunIDS . " Çıkış yapıldı..";
}

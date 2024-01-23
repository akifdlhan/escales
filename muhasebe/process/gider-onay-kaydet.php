<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {

    /*
    var onaylaveode = 'GiderID=' + GiderID +
                                  '&GiderTutar=' + GiderTutar +
                                  '&GiderOnay=' + kullanici +
                                  '&GiderKasa=' + GiderKasa;
    */
    $GuncellemeTarihi = date("Y-m-d H:i:s");
    $tutar = str_replace(",", ".", $GiderTutar);


    /*$fimy_gider = $vt->ekle("fimy_gider", array(
            "GiderTarihi" => $gidertarihi,
            "GiderTipi" => $gidertipi,
            "OdemeDurumu" => $OdemeKontrol,
            "FaturaSeriNo" => $serino,
            "OdemeTarihi" => $sonodeme,
            "Kasa" => $kasa,
            "FaturaTutari" => $tutar,
            "Kullanici" => $kullanici,
            "Onay" => 1
        ));*/

    $fimy_gider = $vt->guncelle("fimy_gider", array("OdemeTarihi" => $GuncellemeTarihi, "OdemeDurumu" => 0, "OnayVeren" => $GiderOnay, "Onay" => 1, "Kasa" => $GiderKasa), "ID={$GiderID}");

    if ($fimy_gider > 0) {

        $fimy_gider_details = $vt->listele("fimy_gider", "WHERE ID={$GiderID}");
        if ($fimy_gider_details != null) foreach ($fimy_gider_details as $fgd) {
            $serino = $fgd['FaturaSeriNo'];
            $Tarihi = $fgd['GiderTarihi'];
        }

        //Kasa Bilgi Alanı - değişken: $kasa
        $Kasa = $vt->listele("fimy_kasa", "WHERE ID={$GiderKasa}");
        if ($Kasa != null) foreach ($Kasa as $K) {
            $Bakiye = $K['Bakiye'];
            $KasaAdi = $K['KasaAdi'];
            $ParaB = $K['ParaBirimi'];
        }
        // Kasa Bilgi Alanı Bitiş

        if ($Bakiye < $tutar) {
            $GuncellemeTarihi = date("Y-m-d H:i:s");
            $fimy_gider = $vt->guncelle("fimy_gider", array("OdemeTarihi" => $GuncellemeTarihi, "OdemeDurumu" => 1, "OnayVeren" => 0, "Onay" => 0, "Kasa" => 0), "ID={$GiderID}");
            $response[] = array('status' => 'warning', 'message' => 'Seçilen kasada yeterli bakiye bulunmamaktadır..', 'refresh' => 1);
            echo json_encode($response);
        } else {
            $AciklamaC = $Tarihi." tarihli ve ".$serino . " Seri numaralı gider faturası için ödeme yapıldı.";

            (float)$SonBakiye = (float)$Bakiye - (float)$tutar;

            $icrm_kasaparagc = $vt->ekle("fimy_kasaparagc", array(
                "KasaID" => $GiderKasa,
                "Tur" => 2,
                "Tutar" => $tutar,
                "Aciklama" => $AciklamaC
            ));

            if ($icrm_kasaparagc > 0) {

                $KasaGuncelle = $vt->guncelle("fimy_kasa", array("Bakiye" => $SonBakiye), "ID={$GiderKasa}");
                if ($KasaGuncelle > 0) {
                    $response[] = array('status' => 'success', 'message' => 'Gider Kaydı Onaylandı ve Ödeme başarıyla gerçekleştirildi..', 'refresh' => 1);
                    echo json_encode($response);
                } else {
                    $response[] = array('status' => 'error', 'message' => 'Sistem hatası yöneticinize başvurunuz.(UTillUpdate)', 'refresh' => 1);
                    echo json_encode($response);
                }
            } else {
                $response[] = array('status' => 'error', 'message' => 'Sistem hatası yöneticinize başvurunuz.(UTillGCAdd)', 'refresh' => 1);
                echo json_encode($response);
            }
        }
    } else {
        $response[] = array('status' => 'error', 'message' => 'Sistem hatası yöneticinize başvurunuz.', 'refresh' => 1);
        echo json_encode($response);
    }
}

<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    $tutar = str_replace(",", ".", $tutar);
    if ($OdemeKontrol == 1) {
        //Ödeme Bekliyor

        $fimy_gider = $vt->ekle("fimy_gider", array(
            "GiderTarihi" => $gidertarihi,
            "GiderTipi" => $gidertipi,
            "OdemeDurumu" => $OdemeKontrol,
            "FaturaSeriNo" => $serino,
            "OdemeTarihi" => $sonodeme,
            "Kasa" => $kasa,
            "Aciklama" => $aciklama,
            "FaturaTutari" => $tutar,
            "Kullanici" => $kullanici,
            "Onay" => 0
        ));
        if ($fimy_gider > 0) {
            $response[] = array('status' => 'success', 'message' => 'Gider Kaydı Oluşturuldu..', 'refresh' => 1);
            echo json_encode($response);
        } else {
            $response[] = array('error' => 'success', 'message' => 'Sistem hatası yöneticinize başvurunuz.', 'refresh' => 1);
            echo json_encode($response);
        }
    } else if ($OdemeKontrol == 0) {
        //Ödendi
        $fimy_gider = $vt->ekle("fimy_gider", array(
            "GiderTarihi" => $gidertarihi,
            "GiderTipi" => $gidertipi,
            "OdemeDurumu" => $OdemeKontrol,
            "FaturaSeriNo" => $serino,
            "OdemeTarihi" => $sonodeme,
            "Kasa" => $kasa,
            "Aciklama" => $aciklama,
            "FaturaTutari" => $tutar,
            "Kullanici" => $kullanici,
            "Onay" => 1
        ));

        if ($fimy_gider > 0) {

            //Kasa Bilgi Alanı - değişken: $kasa
            $Kasa = $vt->listele("fimy_kasa", "WHERE ID={$kasa}");
            if ($Kasa != null) foreach ($Kasa as $K) {
                $Bakiye = $K['Bakiye'];
                $KasaAdi = $K['KasaAdi'];
                $ParaB = $K['ParaBirimi'];
            }
            // Kasa Bilgi Alanı Bitiş

            if ($Bakiye < $tutar) {
                $GiderKayitSil = $vt->sil("fimy_gider", "ID={$fimy_gider}");
                $response[] = array('status' => 'warning', 'message' => 'Seçilen kasada yeterli bakiye bulunmamaktadır..', 'refresh' => 0);
                echo json_encode($response);
            } else {
                $KasaGuncelle = $vt->guncelle("fimy_gider", array("OnayVeren" => $kullanici), "ID={$fimy_gider}");
                $AciklamaC = $serino . " Seri numaralı gider faturası için ödeme yapıldı.";
                (float)$SonBakiye = (float)$Bakiye - (float)$tutar;

                $icrm_kasaparagc = $vt->ekle("fimy_kasaparagc", array(
                    "KasaID" => $kasa,
                    "Tur" => 2,
                    "Tutar" => $tutar,
                    "Aciklama" => $AciklamaC
                ));

                if ($icrm_kasaparagc > 0) {

                    $KasaGuncelle = $vt->guncelle("fimy_kasa", array("Bakiye" => $SonBakiye), "ID={$kasa}");
                    if ($KasaGuncelle > 0) {
                        $response[] = array('status' => 'success', 'message' => 'Gider Kaydı Oluşturuldu ve Ödeme başarıyla gerçekleştirildi..', 'refresh' => 1);
                        echo json_encode($response);
                    } else {
                        $response[] = array('status' => 'error', 'message' => 'Sistem hatası yöneticinize başvurunuz.(TillUpdate)', 'refresh' => 1);
                        echo json_encode($response);
                    }
                }else{
                    $response[] = array('status' => 'error', 'message' => 'Sistem hatası yöneticinize başvurunuz.(TillGCAdd)', 'refresh' => 1);
                    echo json_encode($response);
                }
            }
        } else {
            $response[] = array('status' => 'error', 'message' => 'Sistem hatası yöneticinize başvurunuz.', 'refresh' => 1);
            echo json_encode($response);
        }
    } else {
        //Sistemsel hata.
    }
}

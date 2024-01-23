<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    $borc = 1000000;
    $ust = 1000000;
    if (empty($tc) || empty($isim) || empty($soyisim) || empty($phoneMask) || empty($mail) || empty($adres) || empty($il) || empty($ilce) || empty($bakiye) || empty($borc) || empty($ust)) {
        $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut lütfen kontrol ediniz..', 'refresh' => 0);
        echo json_encode($response);
    } else {


        if ($kurumsal == "true") {
            $kurumsal = 1;
        } else if ($kurumsal == "false") {
            $kurumsal = 0;
        } else {
            $kurumsal = 0;
        }
        $fimy_cari_hesap = $vt->ekle("fimy_cari_hesap", array(
            "TC" => $tc,
            "Adi" => $isim,
            "Soyadi" => $soyisim,
            "Tel" => $phoneMask,
            "Mail" => $mail,
            "Adres" => $adres,
            "il" => $il,
            "ilce" => $ilce,
            "Kurumsal" => $kurumsal
        ));

        if ($kurumsal == 1) {
            $fimy_cari_kurumsal = $vt->ekle("fimy_cari_kurumsal", array(
                "CariID" => $fimy_cari_hesap,
                "FirmaAdi" => $firmadi,
                "VergiDairesi" => $vergidairesi,
                "VergiNo" => $vergino
            ));
        } else {
            echo "";
        }

        if ($fimy_cari_hesap > 0) {
            $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE Aktif=1");
            if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $pb) {
                $fimy_borc_alacak = $vt->ekle("fimy_borc_alacak", array(
                    "MID" => $fimy_cari_hesap,
                    "Tutar" => 0,
                    "BorcAlacak" => 1,
                    "ParaBirimi" => $pb['ID'],
                    "Aciklama" => "Borç ".$pb['ParaBirimi']." - Başlangıç"
                ));
    
                $fimy_borc_alacakk = $vt->ekle("fimy_borc_alacak", array(
                    "MID" => $fimy_cari_hesap,
                    "Tutar" => 0,
                    "BorcAlacak" => 2,
                    "ParaBirimi" => $pb['ID'],
                    "Aciklama" => "Alacak ".$pb['ParaBirimi']." - Başlangıç"
                ));
                $fimy_cari_hesapkarti = $vt->ekle("fimy_cari_hesapkarti", array(
                    "PID" => $fimy_cari_hesap,
                    "UstLimit" => $ust,
                    "BaslangicBakiye" => $bakiye,
                    "BorcLimit" => $borc,
                    "TotalBakiye" => 0,
                    "ParaBirimi" => $pb['ID']
                ));
            }
            

            if ($fimy_cari_hesapkarti > 0) {

                $response[] = array('status' => 'success', 'message' => 'Müşteri başarıyla eklenmiştir..', 'refresh' => 1);
                echo json_encode($response);
            } else {
                $response[] = array('status' => 'error', 'message' => 'Müşteri Ekleme Gerçekleştirilemedi!Hata Kodu: FIERROR:AddFncCustome001', 'refresh' => 1);
                echo json_encode($response);
            }
        }
    }
}

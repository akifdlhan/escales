<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {

    // ############################ INTERNAL PNR OLUŞTURMA ############################
    $siteoptions = $vt->listele("fimy_appoptions");
    if ($siteoptions != null) foreach ($siteoptions as $opt) {
        $prefix = $opt['Onek'];
    }

    $intSiparisNo = generateUniqueCode($prefix, 9, 0);

    $fimy_biletbilgisi = $vt->ozellistele("select count(ID) as Aynisi from fimy_siparis_formu WHERE SiparisNo='{$intSiparisNo}'");
    if ($fimy_biletbilgisi != null) foreach ($fimy_biletbilgisi as $fbb) {
        $PNRSayisi = $fbb['Aynisi'];
    }

    while ($PNRSayisi > 0) {
        $intSiparisNo = generateUniqueCode($prefix, 9, 0);

        $fimy_biletbilgisi = $vt->ozellistele("SELECT COUNT(ID) AS Aynisi FROM fimy_biletbilgisi WHERE FiPNR = '{$intSiparisNo}'");
        if ($fimy_biletbilgisi != null) foreach ($fimy_biletbilgisi as $fbb) {
            $PNRSayisi = $fbb['Aynisi'];
        }
    }
    // ############################ INTERNAL PNR OLUŞTURULDU ############################
    $musteriID = $tempCustomerinfo[0]['musteri'];
    $tahminiTeslim = $tempCustomerinfo[0]['tahminiteslim'];
    //$DiziBoyutu = count($UrunList);
    if ($musteriID == 0 || empty($tahminiTeslim) || empty($UrunList) ) {
        $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut lütfen kontrol ediniz..', 'refresh' => 0);
        echo json_encode($response);
    } else {
        $fimy_siparis_formu = $vt->ekle("fimy_siparis_formu", array(
            "SiparisNo" => $intSiparisNo,
            "MusteriID" => $tempCustomerinfo[0]['musteri'],
            "SiparisAlan" => $tempCustomerinfo[0]['OlusturanKullanici'],
            "SiparisNot" => $tempCustomerinfo[0]['siparisNotu'],
            "TahminiTeslim" => $tempCustomerinfo[0]['tahminiteslim']
        ));
        if ($fimy_siparis_formu > 0) {
           // echo "sipariş formu oluşturuldu.";
            $DiziBoyutu = count($UrunList);
            $GenelToplam = 0;
            for ($indis = 0; $indis < $DiziBoyutu; $indis++) {
                $araToplam = $UrunList[$indis]['araToplam'];

                $aratop = str_replace(",", ".", $UrunList[$indis]['araToplam']);
                $fimy_sf_urun = $vt->ekle("fimy_sf_urun", array(
                    "SiparisFormID" => $fimy_siparis_formu,
                    "UrunID" => $UrunList[$indis]['urun'],
                    "Adet" =>  $UrunList[$indis]['adet'],
                    "BirimFiyati" =>  $UrunList[$indis]['birimfiyati'],
                    "AraToplam" =>  $aratop
                ));

                $araToplam = str_replace(",", ".", $araToplam) . " \n";
                $GenelToplam = (float)$GenelToplam + (float)$araToplam;
            }
            // echo $GenelToplam;
            $fimy_siparis_butce = $vt->ekle("fimy_siparis_butce", array(
                "SiparisID" => $fimy_siparis_formu,
                "SiparisNo" => $intSiparisNo,
                "GenelToplam" =>  $GenelToplam
            ));
            if ($fimy_siparis_butce > 0) {
                $response[] = array('status' => 'success', 'message' => 'Sipariş başarıyla oluşturuldu ve detaylandırıldı..', 'refresh' => 1);
                echo json_encode($response);
            }
        }
    }
} else {
    $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut lütfen kontrol ediniz..', 'refresh' => 0);
    echo json_encode($response);
}

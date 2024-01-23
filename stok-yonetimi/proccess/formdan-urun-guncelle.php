<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {

    // [SipForID] => 76 [birimfiyati] => 1 [urunadet] => 150 [araToplam] => 150
    $araToplam = str_replace(",", ".", $araToplam);
    function SiparisFormuGuncelle($vt, $SiparisFormID)
    {

        (float)$GenelToplam = 0;
        $fimy_sf_urun = $vt->listele("fimy_sf_urun", "WHERE SiparisFormID={$SiparisFormID};");
        if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sf) {
            (float)$AraToplam = $sf['AraToplam'];
            $GenelToplam = $AraToplam + $GenelToplam;
        }

        $fimy_siparis_butce = $vt->guncelle("fimy_siparis_butce", array(
            "GenelToplam" => $GenelToplam
        ), "SiparisID={$SiparisFormID}");

        if ($fimy_sf_urun > 0 || $fimy_siparis_butce > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    //

    if ($islem == 1) {
        $fimy_sf_urun = $vt->listele("fimy_sf_urun", "WHERE ID={$SipForID};");
        if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sf) {
            $SiparisFormID = $sf['SiparisFormID'];
        }

        $fimy_sf_urun_up = $vt->guncelle("fimy_sf_urun", array(
            "Adet" => $urunadet,
            "BirimFiyati" => $birimfiyati,
            "AraToplam" => $araToplam
        ), "ID={$SipForID}");

        $FonkReturn = SiparisFormuGuncelle($vt, $SiparisFormID);

        if ($FonkReturn > 0) {
            echo "Başarıyla Güncellenmiştir..";
        } else {
            echo "Güncelleme yapılırken hata oluştu..";
        }
    } else if ($islem == 0) {
        $fimy_sf_urun = $vt->listele("fimy_sf_urun", "WHERE ID={$SipForID};");
        if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sf) {
            $SiparisFormID = $sf['SiparisFormID'];
        }

        $fimy_sf_urun_say = $vt->ozellistele("select count(ID) AS KayitSayisi from fimy_sf_urun WHERE SiparisFormID={$SiparisFormID};");
        if ($fimy_sf_urun_say != null) foreach ($fimy_sf_urun_say as $sfs) {
            $KayitSayisi = $sfs['KayitSayisi'];
        }

        if ($KayitSayisi == 1) {
            $SfDenSil = $vt->sil("fimy_sf_urun", "ID={$SipForID}");
            $fimy_siparis_formu = $vt->guncelle("fimy_siparis_formu", array(
                "Pasif" => 0
            ), "ID={$SiparisFormID}");

            if ($SfDenSil > 0 ) {
                echo "Sipariş formunda bulunan son ürün olduğundan dolayı ürün ve sipariş formu silindi...";
            } else {
                echo "Sipariş formundan silinemedi...";
            }
        } else {
            $SfDenSil = $vt->sil("fimy_sf_urun", "ID={$SipForID}");
            $FonkReturn = SiparisFormuGuncelle($vt, $SiparisFormID);

            if ($FonkReturn > 0) {
                echo "Başarıyla Silinmiştir..";
            } else {
                echo "Silme işlemi yapılırken hata oluştu..";
            }
        }
    } else {
        echo "İşlem seçiminde hata oluştu..";
    }
}

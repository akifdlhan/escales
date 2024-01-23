<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    // 'UrunID': $("#UrunID").val(),
    // 'urunadi': $("#urunadi").val(),
    // 'marka': $("#marka").val(),
    // 'model': $("#model").val(),
    // 'StokKodu': $("#StokKodu").val(),
    // 'olcubirimi': $("#olcubirimi").val(),
    // 'birimfiyati': $("#birimfiyati").val(),
    // 'satisfiyati': $("#satisfiyati").val()

    if (empty($urunadi) || empty($StokKodu) || empty($birimfiyati) || empty($satisfiyati) || $marka == 0 || $model == 0 || $olcubirimi == 0) {
        $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut lütfen kontrol ediniz..', 'refresh' => 0);
        echo json_encode($response);
    } else {
        $fimy_urunler = $vt->guncelle("fimy_urunler", array(
            "urun_adi" => $urunadi,
            "StokKodu" => $StokKodu,
            "serino" => $StokKodu,
            "marka" => $marka,
            "model" => $model,
            "KategoriID" => $kategori,
            "OlcuBirimi" => $olcubirimi
        ), "ID={$UrunID}");
        $birimfiyati = str_replace(",", ".", $birimfiyati);
        $satisfiyati = str_replace(",", ".", $satisfiyati);

        $fimy_urun_fiyat = $vt->guncelle("fimy_urun_fiyat", array(
            "BirimFiyati" => $birimfiyati,
            "SatisFiyati" => $satisfiyati
        ), "UrunID={$UrunID}");
        if ($fimy_urun_fiyat > 0 || $fimy_urunler > 0) {
            $response[] = array('status' => 'success', 'message' => 'Ürün Bilgileri Güncellendi', 'refresh' => 1);
            echo json_encode($response);
        }
    }
}

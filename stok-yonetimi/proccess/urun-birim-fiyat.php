<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    // $urun.">";
    if ($islemSec == 0) {
        // $birimfiyati = str_replace(".", ",", $birimfiyati);
        (float)$araToplami = $urunadet * (float)$birimfiyati;
        $araToplami = number_format($araToplami, 2, ',', '');
        // echo $araToplami;
        $response[] = array('urun' => 0, 'stoksayisi' => 0, 'satisfiyati' => $araToplami, 'toastrac' => 0);
        echo json_encode($response);
    } else if ($islemSec == 1) {
        $stok_sayisi = 0;
        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE UrunID={$urun}");
        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $deposayisi) {
            $BirimFiyati = $deposayisi['bulundugu_depo'];
            $stok_sayisi = $deposayisi['stok_miktari'] + $stok_sayisi;
        }
        $fimy_urun_fiyat = $vt->listele("fimy_urun_fiyat", "WHERE UrunID={$urun}");
        if ($fimy_urun_fiyat != null) foreach ($fimy_urun_fiyat as $fiyat) {
            $BirimFiyati = $fiyat['SatisFiyati'];
            $BirimFiyati = str_replace(".", ".", $BirimFiyati);
            $response[] = array('urun' => $urun, 'stoksayisi' => $stok_sayisi, 'satisfiyati' => $BirimFiyati, 'toastrac' => 1);
            echo json_encode($response);
        }
    } else if ($islemSec == 2) {
        // $birimfiyati
        $stok_sayisi = 0;
        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE UrunID={$urun}");
        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $deposayisi) {
            
            $stok_sayisi = $deposayisi['stok_miktari'] + $stok_sayisi;
        }
        // $fimy_urun_fiyat = $vt->listele("fimy_urun_fiyat", "WHERE UrunID={$urun}");
        //     if ($fimy_urun_fiyat != null) foreach ($fimy_urun_fiyat as $fiyat) {
        //         $BirimFiyati = $fiyat['SatisFiyati'];
        //         $BirimFiyati = (float)$birimfiyati;
        //     }
            $BirimFiyati = $birimfiyati;

        if ($urunadet > $stok_sayisi) {
            $response[] = array('urun' => $urun, 'stoksayisi' => $stok_sayisi, 'satisfiyati' => $BirimFiyati, 'toastrac' => 1);
            echo json_encode($response);
        } else {
            $fimy_urun_fiyat = $vt->listele("fimy_urun_fiyat", "WHERE UrunID={$urun}");
            if ($fimy_urun_fiyat != null) foreach ($fimy_urun_fiyat as $fiyat) {
                $BirimFiyati = $fiyat['SatisFiyati'];
                $BirimFiyati = str_replace(".", ".", $BirimFiyati);
               // $BirimFiyati = (float)$birimfiyati;
                $BirimFiyati = $birimfiyati;
                $response[] = array('urun' => $urun, 'stoksayisi' => $stok_sayisi, 'satisfiyati' => $BirimFiyati, 'toastrac' => 1);
                echo json_encode($response);
            }
        }
    } else {
        $response[] = array('urun' => "hata", 'stoksayisi' => "hata", 'satisfiyati' => "hata", 'toastrac' => 1);
        echo json_encode($response);
    }
}

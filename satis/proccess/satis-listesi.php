<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_GET);
if ($_GET) {
    $barkodNo = $barkodNo;
    $barkodNoSayaci = strlen($barkodNo);

    if ($barkodNoSayaci == 9) {
        $count = 0;
        $fimy_urunler = $vt->listele("fimy_urunler", "WHERE barkod='{$barkodNo}'");
        if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
            $count++;
        }
        if ($count > 0) {
            $fimy_urunler = $vt->listele("fimy_urunler", "WHERE barkod='{$barkodNo}'");
            if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
                $UrunID = $urun['ID'];
                $fimy_urun_stok_depo = $vt->ozellistele("SELECT SUM(stok_miktari) as stok_miktari FROM fimy_urun_stok_depo WHERE UrunID={$urun['ID']};");
                if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                    $stok_miktari = $usd['stok_miktari'];
                }
                $fimy_urun_fiyat = $vt->listele("fimy_urun_fiyat", "WHERE UrunID={$urun['ID']};");
                if ($fimy_urun_fiyat != null) foreach ($fimy_urun_fiyat as $uf) {
                    $BirimFiyati = $uf['BirimFiyati'];
                    $SatisFiyati = $uf['SatisFiyati'];
                }
                $urunAdi = $urun['urun_adi'];
            }
            $urunDetaylari = array(
                'adet' => 1,
                'name' => $urunAdi,
                'barkod' => $barkodNo,
                'fiyat' => $BirimFiyati,
                'varyok' => 1
            );
            echo json_encode($urunDetaylari);
        } else {
            $urunDetaylari = array(
                'name' => '',
                'barkod' => $barkodNo,
                'fiyat' => '',
                'varyok' => 0
            );
            echo json_encode($urunDetaylari);
        }
    } else {
    }
}

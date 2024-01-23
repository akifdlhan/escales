<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_GET) {
    $TransferID = $_GET['TransferID'];
    $UrunID = $_GET['UrID'];
    $Depo = $_GET['Depo'];
    $Onay = $_GET['Onay'];
    $User = $_GET['User'];
    $aktarimAdet = $_GET['Adet'];
    $AliciDepo = $Depo;
    if ($Onay == 0) {
        $stokSayaci = 0;
        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE UrunID={$UrunID} and bulundugu_depo={$Depo}");
        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
            $aliciDepodakiSayi = $usd['stok_miktari'];
            $stokSayaci++;
        }

        if ($stokSayaci > 0) {
            $DepoyaGirecek = $aliciDepodakiSayi + $aktarimAdet;
            $fimy_urun_stok_depo = $vt->guncelle("fimy_urun_stok_depo", array("stok_miktari" => $DepoyaGirecek), "UrunID={$UrunID} and bulundugu_depo={$AliciDepo}");
            if ($fimy_urun_stok_depo > 0) {
                $Statu = 1;
            }
        } else {
            $fimy_urun_stok_depo_alici = $vt->ekle("fimy_urun_stok_depo", array("stok_miktari" => $aktarimAdet, "UrunID" => $UrunID, "bulundugu_depo" => $AliciDepo));
            if ($fimy_urun_stok_depo_alici > 0) {
                $Statu = 1;
            }
        }
    } else if ($Onay == 1) {
        echo "Ürün onaylı zaten";
    } else {
    }

    if ($Statu = 1) {
        $fimy_urun_stok_depo = $vt->guncelle("fimy_depo_transfer", array("Onay" => 1,"OnayVeren" => $User), "ID={$TransferID}");
        echo '<script>
        alert("Başarıyla onaylandı ve stok depoya işlendi..");
    setTimeout(function() {
        window.location.href = "../../stok-yonetimi/depo-detay.fi?DepoID=' . $Depo . '&DepoName=";
    }, 800);
                                    </script>';
    }else{
        echo '<script>
        alert("Sistemsel bir hata mevcut..");
    setTimeout(function() {
        window.location.href = "../../stok-yonetimi/depo-detay.fi?DepoID=' . $Depo . '&DepoName=";
    }, 800);
                                    </script>';
    }
}

?>

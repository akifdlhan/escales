<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {

    if (empty($kategoriadi)) {
        $response[] = array('status' => 'warning', 'message' => 'Boş alanlar bulunmakta lütfen kontrol ediniz..', 'refresh' => 0);
        echo json_encode($response);
    } else {
        if ($Guncelleme == 0) {
            $KategoriSayaci = 0;
            //$kategoriadiUp = strtolower($kategoriadi);
            $kategoriadiUp = trim(mb_strtolower($kategoriadi, 'UTF-8'));
            $fimy_kategoriler = $vt->listele("fimy_kategoriler");
            if ($fimy_kategoriler != null) foreach ($fimy_kategoriler as $kat) {
                $katAdi = trim(mb_strtolower($kat['KategoriAdi'], 'UTF-8'));
                if ($kategoriadiUp == $katAdi) {
                    $KategoriSayaci++;
                }
            }

            if ($KategoriSayaci == 0) {
                // Kategori bulunamadı, ekle
                $fimy_kategoriler = $vt->ekle("fimy_kategoriler", array(
                    "KategoriAdi" => $kategoriadi
                ));


                if ($fimy_kategoriler > 0) {

                    $response[] = array('status' => 'success', 'message' => 'Kategori Başarıyla Eklendi..', 'refresh' => 1);
                    echo json_encode($response);
                }
            } else {
                $response[] = array('status' => 'error', 'message' => 'Aynı Kategori mevcut..', 'refresh' => 0);
                echo json_encode($response);
            }
        } else {
            $KategoriSayaci = 0;
            //$kategoriadiUp = strtolower($kategoriadi);
            $kategoriadiUp = trim(mb_strtolower($kategoriadi, 'UTF-8'));
            $fimy_kategoriler = $vt->listele("fimy_kategoriler");
            if ($fimy_kategoriler != null) foreach ($fimy_kategoriler as $kat) {
                $katAdi = trim(mb_strtolower($kat['KategoriAdi'], 'UTF-8'));
                if ($kategoriadiUp == $katAdi) {
                    $KategoriSayaci++;
                }
            }

            if ($KategoriSayaci == 0) {
                // Kategori bulunamadı, ekle
                $fimy_kategoriler = $vt->guncelle("fimy_kategoriler", array(
                    "KategoriAdi" => $kategoriadi
                ),"ID={$ID}");


                if ($fimy_kategoriler > 0) {

                    $response[] = array('status' => 'success', 'message' => 'Kategori Başarıyla Güncellendi..', 'refresh' => 1);
                    echo json_encode($response);
                }
            } else {
                $response[] = array('status' => 'error', 'message' => 'Aynı Kategori mevcut..', 'refresh' => 0);
                echo json_encode($response);
            }
        }
    }
} else if ($_GET) {
    $KatID = $_GET['ID'];
    $fimy_kategoriler = $vt->guncelle("fimy_urunler", array("KategoriID" => 1), "KategoriID=" . $KatID . "");
    $silStok = $vt->sil("fimy_kategoriler", "ID = {$KatID}");
    echo '<script>
    //alert("Kategori başarıyla silindi..");
    setTimeout(function() {
        window.location.href = "../../stok-yonetimi/kategori-yonetimi.fi";
    }, 800);
                                    </script>';
}

<?php
require('../../src/class.upload.php');
include("../../src/iconlibrary.php");
require '../../src/private_custom.php';
$vt = new veritabani();
$fislash = new fislash();
extract($_POST);
if ($_POST) {
    // print_r($_POST);
    // print_r($_FILES);
    // echo $stokkodu;
    if (empty($urunadi) || empty($stokkodu) || empty($birimfiyati) || empty($satisfiyati) || $marka == 0 || $model == 0 || $olcubirimi == 0 || $kategori == 0) {
        $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut lütfen kontrol ediniz..', 'refresh' => 0);
        echo json_encode($response);
    } else {
        $productInfo = array(
            'stokkodu' => $stokkodu,
            'tarih' => date('Y-m-d H:i:s'),
            'depo' => $depo,
            'raf' => '1',
            'goz' => '1'
        );
        $stokkoducheck = $vt->ozellistele("select count(ID) as StokKontrol FROM fimy_urunler WHERE StokKodu='{$stokkodu}'");
        if ($stokkoducheck != null) foreach ($stokkoducheck as $sk) {
            $StokKontrol = $sk['StokKontrol'];
        }

        if ($StokKontrol > 0) {
            $response[] = array('status' => 'warning', 'message' => 'Aynı Stok Koduna ait ürün mevcut.. Lütfen kontrol ediniz.', 'refresh' => 0);
            echo json_encode($response);
        } else {
            $Barcode_unique = $fislash->generateBarcode($productInfo);
            $fimy_urunler = $vt->ekle("fimy_urunler", array(
                "barkod" => "E" . $Barcode_unique,
                "urun_adi" => $urunadi,
                "StokKodu" => $stokkodu,
                "serino" => $stokkodu,
                "marka" => $marka,
                "model" => $model,
                "KategoriID" => $kategori,
                "OlcuBirimi" => $olcubirimi
            ));
            $birimfiyati = str_replace(",", ".", $birimfiyati);
            $satisfiyati = str_replace(",", ".", $satisfiyati);

            $fimy_urun_fiyat = $vt->ekle("fimy_urun_fiyat", array(
                "BirimFiyati" => $birimfiyati,
                "SatisFiyati" => $satisfiyati,
                "UrunID" => $fimy_urunler
            ));

            $fimy_urun_stok_depo = $vt->ekle("fimy_urun_stok_depo", array(
                "bulundugu_depo" => $depo,
                "stok_miktari" => $stokmiktari,
                "UrunID" => $fimy_urunler
            ));
            if ($fimy_urun_fiyat > 0 || $fimy_urunler > 0) {
                $file = $_FILES['urungorseli'];
                $UrunID = $fimy_urunler;
                $targetDirectory = '../../stok-yonetimi/urun-gorselleri';
                if (!is_dir($targetDirectory)) {
                    mkdir($targetDirectory, 0755, true);
                }
                $image = new \Verot\Upload\Upload($file);
                $today = date("Y");
                $t = md5($today);
                $r = rand(0, 99);
                $r1 = md5($r);
                $t = substr($t, 0, 3);
                $rt = substr($r1, 0, 3);
                $ad = $image->file_new_name_body = 'esc_' . $rt;
                $image->file_max_size = '5000000';

                // Accept multiple file types
                $image->allowed = array('image/jpg', 'image/jpeg', 'image/png', 'image/webp');

                $image->png_compression = 9;
                $image->Process($targetDirectory);

                if ($image->processed) {
                    $Son = $image->file_dst_path . $ad . "." . $image->file_src_name_ext;

                    // Convert and compress the image to WebP format if the original is PNG or JPEG
                    if ($image->file_src_mime == 'image/png' || $image->file_src_mime == 'image/jpeg' || $image->file_src_mime == 'image/jpg') {
                        $outputWebP = $image->file_dst_path . $ad . ".webp";
                        $inputImage = ($image->file_src_mime == 'image/png') ? imagecreatefrompng($Son) : imagecreatefromjpeg($Son);

                        // Compression quality (0 to 100)
                        $compressionQuality = 80;

                        // Convert image to WebP
                        imagewebp($inputImage, $outputWebP, $compressionQuality);

                        // Free up memory
                        imagedestroy($inputImage);

                        // Update the database with the WebP image path
                        $outputWebP = substr($outputWebP, 3);
                        $Son = $outputWebP;
                        $guncelle = $vt->guncelle("fimy_urunler", array("urun_gorseli" => $outputWebP), "ID=" . $UrunID . "");
                    } else {
                        // For other file types, update the database with the original image path
                        $Son = substr($Son, 3);
                        $guncelle = $vt->guncelle("fimy_urunler", array("urun_gorseli" => $Son), "ID=" . $UrunID . "");
                    }
                }

                $response[] = array('status' => 'success', 'message' => 'Ürün Bilgileri Güncellendi.. Kategori.:'.$kategori, 'refresh' => 1);
                echo json_encode($response);
            }
        }
    }
}

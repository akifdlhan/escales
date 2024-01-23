<?php
require('../../src/class.upload.php');
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_FILES) {
    // echo $UrunID;
    $image = new \Verot\Upload\Upload($_FILES['file']);

    // ############################ INTERNAL GÖRSEL ADI OLUŞTURMA ############################
    $today = date("Y");
    $t = md5($today);
    $r = rand(0, 1500);
    $r1 = md5($r);
    $t = substr($t, 0, 3);
    $rt = substr($r1, 0, 3);
    $ad = $image->file_new_name_body = 'escales_gozluk_' . $rt;
    $image->file_max_size = '5000000';

    $fimy_urunler = $vt->ozellistele("select count(ID) as Aynisi from fimy_urunler WHERE urun_gorseli_adi='{$ad}'");
    if ($fimy_urunler != null) foreach ($fimy_urunler as $fbb) {
        $PNRSayisi = $fbb['Aynisi'];
    }

    while ($PNRSayisi > 0) {
        $today = date("Y");
        $t = md5($today);
        $r = rand(0, 1500);
        $r1 = md5($r);
        $t = substr($t, 0, 3);
        $rt = substr($r1, 0, 3);
        $ad = $image->file_new_name_body = 'escales_gozluk_' . $rt;
        $image->file_max_size = '5000000';

        $fimy_urunler = $vt->ozellistele("select count(ID) as Aynisi from fimy_urunler WHERE urun_gorseli_adi='{$ad}'");
        if ($fimy_urunler != null) foreach ($fimy_urunler as $fbb) {
            $PNRSayisi = $fbb['Aynisi'];
        }
    }
    // ############################ INTERNAL GÖRSEL ADI OLUŞTURULDU ############################


    $guncelle = $vt->guncelle("fimy_urunler", array("urun_gorseli_adi" => $ad), "ID=" . $UrunID . "");
    // Accept multiple file types
    $image->allowed = array('image/jpg', 'image/jpeg', 'image/png', 'image/webp');
    $targetDirectory = '../../stok-yonetimi/urun-gorselleri';
    if (!is_dir($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
    }
    $image->png_compression = 9;
    $image->Process($targetDirectory);

    if ($image->processed) {
        $Son = $image->file_dst_path . $ad . "." . $image->file_src_name_ext;

        // Convert and compress the image to WebP format if the original is PNG or JPEG
        if ($image->file_src_mime == 'image/png') {
            $outputWebP = $image->file_dst_path . $ad . ".webp";
            $inputImage = imagecreatefrompng($Son);
        } elseif ($image->file_src_mime == 'image/jpeg' || $image->file_src_mime == 'image/jpg') {
            $outputWebP = $image->file_dst_path . $ad . ".webp";
            $inputImage = imagecreatefromjpeg($Son);
        } else {
            // For other file types, update the database with the original image path
            $Son = substr($Son, 3);
            $guncelle = $vt->guncelle("fimy_urunler", array("urun_gorseli" => $Son), "ID=" . $UrunID . "");
            exit(); // Exit the script for other file types
        }

        // Compression quality (0 to 100)
        $compressionQuality = 80;

        // Convert image to WebP
        imagewebp($inputImage, $outputWebP, $compressionQuality);

        // Free up memory
        imagedestroy($inputImage);

        // Update the database with the WebP image path
        $outputWebP = substr($outputWebP, 3);
        $guncelle = $vt->guncelle("fimy_urunler", array("urun_gorseli" => $outputWebP), "ID=" . $UrunID . "");
    }
}

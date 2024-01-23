<?php
/*
####################################################################
####################################################################
Firmaya veya işe özel class-func içerir.
14112023
Escales
####################################################################
####################################################################
*/

class fislash
{

    function generateBarcode($productInfo)
    {
        $uniqueIdentifier = $productInfo['stokkodu'] . $productInfo['tarih'] . $productInfo['depo'] . $productInfo['raf'] . $productInfo['goz'];
        $hash = md5($uniqueIdentifier);
        $barcodeText = strtoupper(substr($hash, 0, 8));
        return $barcodeText;
    }

    function gorselyukleveguncelle($file, $UrunID, $vt, $targetDirectory)
    {
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
        return $Son;
    }
}

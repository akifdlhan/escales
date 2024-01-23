<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    if (empty($marka)) {
        $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut lütfen kontrol ediniz..', 'refresh' => 0);
        echo json_encode($response);
    } else {
        $markaSayaci = 0;
        $markaUp = trim(mb_strtolower($marka, 'UTF-8'));
        $fimy_marka = $vt->listele("fimy_marka");
        if ($fimy_marka != null) foreach ($fimy_marka as $marka) {
            $marka_adi = trim(mb_strtolower($marka['marka'], 'UTF-8'));
            if ($markaUp == $marka_adi) {
                $markaSayaci++;
            }
        }

        if ($markaSayaci == 0) {
            $fimy_marka = $vt->ekle("fimy_marka", array(
                "marka" => $marka,
            ));
            if ($fimy_marka > 0) {

                $response[] = array('status' => 'success', 'message' => 'Başarıyla Eklenmiştir', 'refresh' => 1);
                echo json_encode($response);
            }

        } else {
            $response[] = array('status' => 'error', 'message' => 'Aynı Marka mevcut..', 'refresh' => 0);
            echo json_encode($response);
        }
    }
}

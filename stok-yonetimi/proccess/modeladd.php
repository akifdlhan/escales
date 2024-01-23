<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    if (empty($marka) || empty($model)) {
        $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut lütfen kontrol ediniz..', 'refresh' => 0);
        echo json_encode($response);
    } else {

        $modelSayaci = 0;
        $modelUp = trim(mb_strtolower($model, 'UTF-8'));

        $fimy_model = $vt->listele("fimy_model", "WHERE marka_id={$marka}");
        if ($fimy_model != null) foreach ($fimy_model as $modelim) {
            $model_adi = trim(mb_strtolower($modelim['model'], 'UTF-8'));
            if ($modelUp == $model_adi) {
                $modelSayaci++;
            }
        }

        if ($modelSayaci == 0) {
            $fimy_model = $vt->ekle("fimy_model", array(
                "model" => $model,
                "marka_id" => $marka,
            ));
            if ($fimy_model > 0) {

                $response[] = array('status' => 'success', 'message' => 'Model Başarıyla Eklenmiştir', 'refresh' => 1);
                echo json_encode($response);
            }
        } else {
            $response[] = array('status' => 'error', 'message' => 'Aynı Model mevcut..', 'refresh' => 0);
            echo json_encode($response);
        }
    }
}

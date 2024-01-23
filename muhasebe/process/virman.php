<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
        $VirmanTutar = str_replace(",", ".", $VirmanTutar);
        $VericiKasam = $vt->listele("fimy_kasa", "WHERE ID={$VericiKasa}");
        if ($VericiKasam != null) foreach ($VericiKasam as $VK) {
                $VBakiye = $VK['Bakiye'];
                $VKasaAdi = $VK['KasaAdi'];
                $VParaB = $VK['ParaBirimi'];
        }
        $alicikasam = $vt->listele("fimy_kasa", "WHERE ID={$alicikasa}");
        if ($alicikasam != null) foreach ($alicikasam as $AK) {
                $ABakiye = $AK['Bakiye'];
                $AKasaAdi = $AK['KasaAdi'];
                $AParaB = $AK['ParaBirimi'];
        }
        if ($VBakiye < $VirmanTutar) {
                $response[] = array('status' => 'error', 'message' => 'Kasada bakiye bulunmadığından dolayı Virman yapılamamıştır.', 'refresh' => 1);
                echo json_encode($response);
        }else{
                (float)$VericiKasaSonBakiye = (float)$VBakiye - (float)$VirmanTutar; 
                (float)$AliciKasaSonBakiye = (float)$ABakiye + (float)$VirmanSonTutar; 
                $fimy_kasa_virma = $vt->ekle("fimy_kasa_virma", array(
                        "VericiKasa" => $VericiKasa,
                        "AliciKasa" => $alicikasa,
                        "VirmanTutar" => $VirmanTutar,
                        "Aciklama" => $VirmanAciklama,
                        "Kur" => $kur,
                        "KurKarsiligi" => $VirmanSonTutar,
                        "VericiOncekiBakiye" => $VBakiye,
                        "AliciOncekiBakiye" => $ABakiye
                ));

                if($fimy_kasa_virma > 0){
                        $AKasaGuncelle = $vt->guncelle("fimy_kasa", array("Bakiye" => $AliciKasaSonBakiye), "ID={$alicikasa}");
                        $VKasaGuncelle = $vt->guncelle("fimy_kasa", array("Bakiye" => $VericiKasaSonBakiye), "ID={$VericiKasa}");
                        if($AKasaGuncelle > 0 || $VKasaGuncelle > 0){
                                $response[] = array('status' => 'success', 'message' => 'Virman başarıyla gerçekleştirildi..', 'refresh' => 1);
                                echo json_encode($response);
                        }else{
                                $response[] = array('status' => 'error', 'message' => 'Virman yapılırken sistemsel hata oluştu..', 'refresh' => 1);
                                echo json_encode($response);
                        }

                }else{
                        $response[] = array('status' => 'error', 'message' => 'Virman yapılırken sistemsel hata oluştu..', 'refresh' => 1);
                        echo json_encode($response);
                }

        }
        /*  if (empty($PGTutarC) || empty($AciklamaC)) {
                echo '
                        <i class="icon ion-ios-glasses-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                        <h4 class="tx-danger tx-semibold mg-b-20">Boş Alanlar Mevcut!</h4>
                        <p class="mg-b-20 mg-x-20"></p>';
                echo '<script>setTimeout(function(){
                                var yol = window.location.pathname+"?KasaID=' . $KasaID . '";
                                window.location.assign(yol);
                              }, 1000);</script>';
        } else {
                $PGTutarC = str_replace(",", ".", $PGTutarC);
                // $KasaID
                //Kasa Bilgi Alanı
                $Kasa = $vt->listele("fimy_kasa", "WHERE ID={$KasaID}");
                if ($Kasa != null) foreach ($Kasa as $K) {
                        $Bakiye = $K['Bakiye'];
                        $KasaAdi = $K['KasaAdi'];
                        $ParaB = $K['ParaBirimi'];
                }
                // Kasa Bilgi Alanı Bitiş

                if ($Bakiye >= $PGTutarC) {
                        // $PGTutar - $Bakiye

                        (float)$SonBakiye = (float)$Bakiye - (float)$PGTutarC;

                        // Bakiye - PGTutar Alanı Bitiş
                        $icrm_pb = $vt->listele("fimy_parabirimi", "WHERE ID='" . $ParaB . "'");
                        if ($icrm_pb != null) foreach ($icrm_pb as $pb) {
                                $exentedpb = $pb['ParaBirimi'];
                        }
                        // Satış Yap Alanı
                        // Tur : 1 - Para Girisi 2 - Para Cıkısı
                        $icrm_kasaparagc = $vt->ekle("fimy_kasaparagc", array(
                                "KasaID" => $KasaID,
                                "Tur" => 2,
                                "Tutar" => $PGTutarC,
                                "Aciklama" => $AciklamaC
                        ));

                        if ($icrm_kasaparagc > 0) {
                                $KasaGuncelle = $vt->guncelle("fimy_kasa", array("Bakiye" => $SonBakiye), "ID={$KasaID}");

                                echo '
                    <i class="icon ion-checkmark tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-success tx-semibold mg-b-20">İşlem Başarılı!</h4>
                    <p class="mg-b-20 mg-x-20">İşlem başarıyla gerçekleştirilmiştir.</p>';

                                echo '<script>setTimeout(function(){
                        var yol = window.location.pathname+"?KasaID=' . $KasaID . '";
                        window.location.assign(yol);
                      }, 1000);</script>';
                                // Tur - 1 Satış, 2 Ekleme, 3 Giriş Yapıldı
                                // Durum - 1 Başarılı, 2 Başarısız
                                /* $icrm_log = $vt->ekle("icrm_log",array(
                          "MID"=>0,
                          "Tur"=>0,
                          "Tutar"=>$PGTutarC,
                          "Aciklama"=>$KasaAdi." isimli kasadan ",
                          "Aciklama2"=>" ".$exentedpb." para çıkışı gerçekleştirildi.",
                          "Durum"=>1));*//*
                        } else {
                                echo '
                       <i class="icon ion-android-close tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                       <h4 class="tx-success tx-semibold mg-b-20">Satış Gerçekleştirilemedi!</h4>
                       <p class="mg-b-20 mg-x-20">Sistemsel sorun oluştu, sistem yöneticiniz ile iletişime geçiniz.</p>
                       <p class="mg-b-20 mg-x-20">Hata Kodu: ICONERROR:TillExportImport002</p>';
                                echo '<script>setTimeout(function(){
                        var yol = window.location.pathname+"?KasaID=' . $KasaID . '";
                               window.location.assign(yol);
                             }, 2000);</script>';
                        }

                        // Satış Yap Alanı Bitiş
                } else {
                        echo '
                        <i class="icon ion-ios-glasses-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                        <h4 class="tx-danger tx-semibold mg-b-20">Kasada Yeterli Tutar Bulunmamaktadır.!</h4>
                        <p class="mg-b-20 mg-x-20"></p>';
                        echo '<script>setTimeout(function(){
                                var yol = window.location.pathname+"?KasaID=' . $KasaID . '";
                                window.location.assign(yol);
                              }, 2000);</script>';
                }
        }*/
}

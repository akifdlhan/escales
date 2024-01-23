<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
        // $BorcAlacak Değişkini 1 - Borç 2 - Alacak

        if ($BorcAlacak == 1) {
                // $ParaBirimi
                $TutarB = str_replace(",", ".", $TutarB);
                if (empty($TutarB) || empty($Aciklama)) {
                        $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut lütfen kontrol ediniz..', 'refresh' => 0);
                        echo json_encode($response);
                } else {
                        $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=1");
                        if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $B) {
                                $Borc = $B['Tutar'];
                        }
                        $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=2");
                        if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $B) {
                                $Alacak = $B['Tutar'];
                        }

                        //BorcAlacak Bilgi Alanı
                        $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=1");
                        if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $B) {
                                $BorcAlacak = $B['Tutar'];
                        }
                        //BorcAlacak Bilgi Alanı Bitiş

                        //Müsteri Bilgi Alanı
                        $icrm_musterikarti = $vt->listele("fimy_cari_hesapkarti", "WHERE PID={$MusID}");
                        if ($icrm_musterikarti != null) foreach ($icrm_musterikarti as $M) {
                                $BorcLimit = $M['BorcLimit'];
                        }
                        //Müsteri Bilgi Alanı Bitiş
                        //echo $BorcLimit;
                        if ($BorcLimit < $TutarB) {
                                echo '
                       <i class="icon ion-android-close tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                       <h4 class="tx-danger tx-semibold mg-b-20">Girilen Tutar Borç Limitinden Yüksek!!</h4>
                       <p class="mg-b-20 mg-x-20">Tutarı tekrar kontrol ediniz.</p>
                       <p class="mg-b-20 mg-x-20"></p>';
                                echo 'toastr["error"]("I do not think that means what you think it means.", "Test")';
                                /* echo '<script>setTimeout(function(){
                        var yol = window.location.pathname+"?MusteriID='.$MusID.'";
                               window.location.assign(yol);
                             }, 1000);</script>';*/
                        } else {

                                // $BorcAlacak + $TutarB
                                if ($Alacak == $TutarB) {
                                        (float)$SonAlacak = 0;
                                        (float)$SonBakiye = (float)$BorcAlacak + (float)$TutarB;
                                }
                                if ($Alacak > 0) {
                                        (float)$SonAlacak =  (float)$Alacak - (float)$TutarB;
                                } else {
                                }

                                // BorcAlacak + TutarB Alanı Bitiş

                                // Hareket Tablosuna Ekleme
                                // Tur : 1 - Borc 2 - Alacak
                                $icrm_bahareket = $vt->ekle("fimy_ba_hareket", array(
                                        "MID" => $MusID,
                                        "BorcAlacak" => 1,
                                        "Tutar" => $TutarB,
                                        "ParaBirimi" => $ParaBirimi,
                                        "Aciklama" => $Aciklama
                                ));
                                // Hareket Tablosuna Ekleme End

                                // Hareket tablosuna göre Borç ve Alacak güncelleme
                                if ($icrm_bahareket > 0) {

                                        // Tur : 1 - Borc 2 - Alacak
                                        $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $SonBakiye), "MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=1");
                                        $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $SonAlacak), "MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=2");

                                        $response[] = array('status' => 'success', 'message' => 'Borç eklendi..', 'refresh' => 1);
                                        echo json_encode($response);
                                } else {
                                        $response[] = array('status' => 'error', 'message' => 'Girilen Tutar Borç Limitinden Yüksek!', 'refresh' => 0);
                                        echo json_encode($response);
                                }
                                // Hareket tablosuna göre Borç ve Alacak güncelleme End

                        }
                }
        } else if ($BorcAlacak == 2) {
                $TutarA = str_replace(",", ".", $TutarA);
                if (empty($TutarA) || empty($Aciklama)) {
                        $response[] = array('status' => 'warning', 'message' => 'Boş Alanlar Mevcut!', 'refresh' => 0);
                        echo json_encode($response);
                } else {
                        //BorcAlacak Bilgi Alanı
                        $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=1");
                        if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $B) {
                                $Borc = $B['Tutar'];
                        }
                        $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=2");
                        if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $B) {
                                $Alacak = $B['Tutar'];
                        }
                        //BorcAlacak Bilgi Alanı Bitiş

                        // $BorcAlacak + $TutarB


                        if ($Borc == $TutarA) {
                                (float)$SonBorc = 0;
                                (float)$SonBakiye = (float)$Alacak + (float)$TutarA;
                        } else {


                                if ($Borc > 0) {
                                        (float)$SonBorc =  (float)$Borc - (float)$TutarA;
                                } else {
                                        (float)$SonBorc = (float)$Borc;
                                        (float)$SonBakiye = (float)$Alacak + (float)$TutarA;
                                        //$response[] = array('status' => 'warning', 'message' => 'Borç ve Alacak mahsuplaşmasında hata oluştu lütfen yapılan işlemi dikkate almayınız..', 'refresh' => 0);
                                        //echo json_encode($response);
                                }
                        }
                        // BorcAlacak + TutarB Alanı Bitiş

                        // Hareket Tablosuna Ekleme
                        // Tur : 1 - Borc 2 - Alacak
                        $icrm_bahareket = $vt->ekle("fimy_ba_hareket", array(
                                "MID" => $MusID,
                                "BorcAlacak" => 2,
                                "Tutar" => $TutarA,
                                "ParaBirimi" => $ParaBirimi,
                                "Aciklama" => $Aciklama
                        ));
                        // Hareket Tablosuna Ekleme End


                        // Hareket tablosuna göre Borç ve Alacak güncelleme
                        if ($icrm_bahareket > 0) {

                                // Tur : 1 - Borc 2 - Alacak
                                $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $SonBakiye), "MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=2");
                                $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $SonBorc), "MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=1");

                                $response[] = array('status' => 'success', 'message' => 'İşlem başarıyla gerçekleştirilmiştir.', 'refresh' => 1);
                                echo json_encode($response);
                        } else {
                                $response[] = array('status' => 'success', 'message' => 'Sistemsel sorun oluştu, sistem yöneticiniz ile iletişime geçiniz. \n Hata Kodu: FIERRR:DebtCreditt002', 'refresh' => 1);
                                echo json_encode($response);
                        }
                        // Hareket tablosuna göre Borç ve Alacak güncelleme End


                }
        }
        // $BorcAlacak End
}

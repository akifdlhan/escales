<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
        if (empty($kasa) || empty($Aciklama) || empty($TutarOdeme)) {
                $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut veya kasa seçilmemiş lütfen kontrol ediniz..', 'refresh' => 0);
                echo json_encode($response);
        } else {
                $TutarOdeme = str_replace(",", ".", $TutarOdeme);
                //Kasa Bilgi Alanı - değişken: $kasa
                $Kasa = $vt->listele("fimy_kasa", "WHERE ID={$kasa}");
                if ($Kasa != null) foreach ($Kasa as $K) {
                        $Bakiye = $K['Bakiye'];
                        $KasaAdi = $K['KasaAdi'];
                        $ParaB = $K['ParaBirimi'];
                }
                // Kasa Bilgi Alanı Bitiş

                if ($Bakiye <= 0) {
                        $response[] = array('status' => 'error', 'message' => 'Kasada yeterli bakiye bulunmamaktadır..', 'refresh' => 1);
                        echo json_encode($response);
                } else if ($Bakiye <= $TutarOdeme) {
                        $response[] = array('status' => 'error', 'message' => 'Kasada yeterli bakiye bulunmamaktadır..', 'refresh' => 1);
                        echo json_encode($response);
                } else {


                        //Kasa Bilgi Alanı - değişken: $kasa
                        $fimy_borc_alacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaB} and BorcAlacak=2");
                        if ($fimy_borc_alacak != null) foreach ($fimy_borc_alacak as $BA) {
                                $Alacak = $BA['Tutar'];
                        }
                        // Kasa Bilgi Alanı Bitiş

                        // $Bakiye - $TutarOdeme = $SonBakiye - Bu değer Kasa Bakiyesinden güncellenecek.

                        (float)$SonBakiye = (float)$Bakiye - (float)$TutarOdeme;

                        // $Bakiye - $TutarOdeme = $SonBakiyer Alanı Bitiş

                        // $Alacak - $TutarOdeme = $SonAlacak - Bu değer Kasa Bakiyesinden güncellenecek.

                        (float)$SonAlacak = (float)$Alacak - (float)$TutarOdeme;

                        // $Alacak - $TutarOdeme = $SonAlacak Alanı Bitiş
                        if ($ParaB == 1){
                                $aliskuru = 0;
                                $satiskuru = 0;
                        }else {
                                $icrm_pb = $vt->listele("fimy_parabirimi", "WHERE ID='" . $ParaB . "'");
                                if ($icrm_pb != null) foreach ($icrm_pb as $pb) {
                                        $exentedpb = $pb['ParaBirimi'];
                                }
                                $fimy_dovizcifti = $vt->listele("fimy_dovizcifti", "WHERE PB1={$ParaB}");
                                if ($fimy_dovizcifti != null) foreach ($fimy_dovizcifti as $df) {
                                        $dovizcifti = $df['ID'];
                                }
                                $fimy_dovizkurlari = $vt->listele("fimy_dovizkurlari", "WHERE DovizID={$dovizcifti}");
                                if ($fimy_dovizkurlari != null) foreach ($fimy_dovizkurlari as $dk) {
                                        $aliskuru = $dk['Alis'];
                                        $satiskuru = $dk['Satis'];
                                }
                        }
                        // Müşteri Ödeme Hareketi Ekle
                        $icrm_modemehareket = $vt->ekle("fimy_m_odemehareket", array(
                                "MID" => $MusID,
                                "AlVer" => 1,
                                "Tutar" => $TutarOdeme,
                                "KasaID" => $kasa,
                                "Kur" => $satiskuru,
                                "PBID" => $ParaB,
                                "Aciklama" => $Aciklama
                        ));

                        // Müşteri Ödeme Hareketi Ekle End      

                        // Müşteri Ödeme Hareketi Ekle Sorgusu ve Kasa Bakiye Güncelleme
                        if ($icrm_modemehareket > 0) {
                                // $SonAlacak;
                                $KasaGuncelle = $vt->guncelle("fimy_kasa", array("Bakiye" => $SonBakiye), "ID={$kasa}");

                                if ($SonAlacak < 0) {
                                        //Borc Bilgi Alanı - değişken: $MusID
                                        $fimy_borc_alacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaB} and BorcAlacak=1");
                                        if ($fimy_borc_alacak != null) foreach ($fimy_borc_alacak as $BA) {
                                                $Borc = $BA['Tutar'];
                                        }
                                        // Borc Bilgi Alanı Bitiş
                                        $SonAlacak = explode("-", $SonAlacak);
                                        $SonAlacak = $SonAlacak[1];
                                        // $Alacak - $TutarOdeme = $SonAlacak - Bu değer Kasa Bakiyesinden güncellenecek.

                                        (float)$SonBorc = (float)$Borc + (float)$SonAlacak;

                                        // $Alacak - $TutarOdeme = $SonAlacak Alanı Bitiş

                                        $fimy_borc_alacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $SonBorc), " MID={$MusID} and ParaBirimi={$ParaB} and BorcAlacak=1");
                                        $fimy_borc_alacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => 0), " MID={$MusID} and ParaBirimi={$ParaB} and BorcAlacak=2");
                                } else {

                                        $fimy_borc_alacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $SonAlacak), " MID={$MusID} and ParaBirimi={$ParaB} and BorcAlacak=2");
                                }


                                $response[] = array('status' => 'success', 'message' => 'Ödeme Başarılı..', 'refresh' => 1);
                                echo json_encode($response);
                        } else {
                                $response[] = array('status' => 'error', 'message' => 'Sistemsel sorun oluştu, sistem yöneticiniz ile iletişime geçiniz.. \n Hata Kodu: ICONERROR:TillExportImport001', 'refresh' => 1);
                                echo json_encode($response);
                        }
                        // Müşteri Ödeme Hareketi Ekle Sorgusu ve Kasa Bakiye Güncelleme End

                }
        }
}

<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
        if (empty($kasa) || empty($Aciklama) || empty($TutarOdeme)) {
                $response[] = array('status' => 'warning', 'message' => 'Boş alanlar mevcut veya kasa seçilmemiş lütfen kontrol ediniz..', 'refresh' => 0);
                echo json_encode($response);
        } else {
                // ############################ INTERNAL ODEME NO OLUŞTURMA ############################
                $siteoptions = $vt->listele("fimy_appoptions");
                if ($siteoptions != null) foreach ($siteoptions as $opt) {
                        $prefix = $opt['Onek'];
                }
                $prefix = $prefix . "A";
                $IntOdemeSN = generateUniqueCode($prefix);

                $fimy_m_odemehareket = $vt->ozellistele("select count(ID) as Aynisi from fimy_m_odemehareket WHERE OdemeSN = '{$IntOdemeSN}'");
                if ($fimy_m_odemehareket != null) foreach ($fimy_m_odemehareket as $fmo) {
                        $OdemeNoSayisi = $fmo['Aynisi'];
                }

                while ($OdemeNoSayisi > 0) {
                        $prefix = $prefix . "A";
                        $IntOdemeSN = generateUniqueCode($prefix);

                        $fimy_m_odemehareket = $vt->ozellistele("SELECT COUNT(ID) AS Aynisi FROM fimy_m_odemehareket WHERE OdemeSN = '{$IntOdemeSN}'");
                        if ($fimy_m_odemehareket != null) foreach ($fimy_m_odemehareket as $fmo) {
                                $OdemeNoSayisi = $fmo['Aynisi'];
                        }
                }
                // ############################ INTERNAL ODEME NO OLUŞTURULDU ############################
                $TutarOdeme = str_replace(",", ".", $TutarOdeme);
                //Kasa Bilgi Alanı - değişken: $kasa
                $Kasa = $vt->listele("fimy_kasa", "WHERE ID={$kasa}");
                if ($Kasa != null) foreach ($Kasa as $K) {
                        $Bakiye = $K['Bakiye'];
                        $KasaAdi = $K['KasaAdi'];
                        $ParaB = $K['ParaBirimi'];
                }
                // Kasa Bilgi Alanı Bitiş

                //icrm_borcalacak Bilgi Alanı - değişken: $kasa
                $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaB} and BorcAlacak=1");
                if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $BA) {
                        $Borc = $BA['Tutar'];
                }
                // icrm_borcalacak Bilgi Alanı Bitiş

                // $Bakiye - $TutarOdeme = $SonBakiye - Bu değer Kasa Bakiyesinden güncellenecek.

                (float)$SonBakiye = (float)$Bakiye + (float)$TutarOdeme; //SonBakiye kasanın güncel tutarı olacak kasaya para girecek çünkü

                // $Bakiye - $TutarOdeme = $SonBakiyer Alanı Bitiş

                // $Alacak - $TutarOdeme = $SonAlacak - Bu değer Kasa Bakiyesinden güncellenecek.

                (float)$SonBorc = (float)$Borc - (float)$TutarOdeme;

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
                        "OdemeSN" => $IntOdemeSN,
                        "AlVer" => 2,
                        "Tutar" => $TutarOdeme,
                        "KasaID" => $kasa,
                        "PBID" => $ParaB,
                        "Kur" => $aliskuru,
                        "OankiBorc" => $Borc,
                        "Aciklama" => $Aciklama
                ));

                // Müşteri Ödeme Hareketi Ekle End      

                // Müşteri Ödeme Hareketi Ekle Sorgusu ve Kasa Bakiye Güncelleme
                if ($icrm_modemehareket > 0) {
                        // echo $SonAlacak;
                        $KasaGuncelle = $vt->guncelle("fimy_kasa", array("Bakiye" => $SonBakiye), "ID={$kasa}");


                        if ($SonBorc < 0) {

                                //Alacak Bilgi Alanı - değişken: $MusID
                                $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaB} and BorcAlacak=2");
                                if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $BA) {
                                        $Alacak = $BA['Tutar'];
                                }
                                // Alacak Bilgi Alanı Bitiş
                                $SonBorc = explode("-", $SonBorc);
                                $SonBorc = $SonBorc[1];
                                (float)$SonAlacak = (float)$Alacak + (float)$SonBorc;
                                $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $SonAlacak), "MID={$MusID} and ParaBirimi={$ParaB} and BorcAlacak=2");
                                $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => 0), "MID={$MusID} and ParaBirimi={$ParaB} and BorcAlacak=1");
                        } else {
                                $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $SonBorc), "MID={$MusID} and ParaBirimi={$ParaB} and BorcAlacak=1");
                        }

                        $icrm_musterikarti = $vt->listele("fimy_cari_hesapkarti", "WHERE PID={$MusID} and ParaBirimi={$ParaB}");
                        if ($icrm_musterikarti != null) foreach ($icrm_musterikarti as $TB) {
                                $TotalB = $TB['TotalBakiye'];
                        }
                        (float)$SonTBakiye = (float)$TotalB + (float)$TutarOdeme;
                        $icrm_musterikarti = $vt->guncelle("fimy_cari_hesapkarti", array("TotalBakiye" => $SonTBakiye), "PID={$MusID} and ParaBirimi={$ParaB}");


                        $response[] = array('status' => 'success', 'message' => 'Ödeme başarılı..', 'refresh' => 1);
                        echo json_encode($response);
                } else {

                        $response[] = array('status' => 'error', 'message' => 'Sistemsel sorun oluştu, sistem yöneticiniz ile iletişime geçiniz.. \n Hata Kodu: ICONERROR:TillExportImport002', 'refresh' => 1);
                        echo json_encode($response);
                }

                // Müşteri Ödeme Hareketi Ekle Sorgusu ve Kasa Bakiye Güncelleme End




        }
}

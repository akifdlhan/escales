<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    /*
    cikisdepo
    SiparisID
    OdemeTipi
    OnOdeme
    Kasa
    KalanTutar
    
    */
    $OdemeTipi = 2;
    $OnOdeme = 0;
    $Kasa = 1;
    $fimy_sf_urun = $vt->listele("fimy_sf_urun", "WHERE SiparisFormID={$SiparisID}");
    if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sfurun) {

        $UrunIDS = $sfurun['UrunID'];
        $SiparisFormuAdet = $sfurun['Adet'];

        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE UrunID={$UrunIDS} and bulundugu_depo={$cikisdepo}");
        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $sd) {
            $UrunStokDepoID = $sd['ID'];
            $DepoStokAdet = $sd['stok_miktari'];
        }

        $DepoStokAdetNew = $DepoStokAdet - $SiparisFormuAdet;

        //echo $UrunIDS." >>> ".$DepoStokAdet." adet üründen ".$SiparisFormuAdet ." çıkış yapılacak ve Depoda ".$DepoStokAdetNew." stok kalacaktır..";
        $LogText = "{$SiparisID} Sipariş için {$cikisdepo} ID'li depodan, {$DepoStokAdet} adet stoktan {$SiparisFormuAdet} adet sipariş için düşürülmüştür.";
        $fimy_stok_log = $vt->ekle("fimy_stok_log", array("UrunStokDepo" => $UrunStokDepoID, "UrunID" => $UrunIDS, "DepoID" => $cikisdepo, "UserID" => 4, "LogTuru" => 2, "Log" => $LogText));

        if ($fimy_stok_log > 0) {

            $fimy_urun_stok_depo = $vt->guncelle("fimy_urun_stok_depo", array(
                "stok_miktari" => $DepoStokAdetNew
            ), "ID={$UrunStokDepoID}");

            $fimy_siparis_formu = $vt->guncelle("fimy_siparis_formu", array(
                "TeslimDurumu" => 1,
                "Onay" => 2,
                "TeslimTarihi" => date("Y-m-d")
            ), "ID={$SiparisID}");

            $fimy_siparis_butce = $vt->guncelle("fimy_siparis_butce", array(
                "OdemeTipi" => $OdemeTipi,
                "OnOdeme" => $OnOdeme,
                "KalanOdeme" => $KalanTutar,
                "Kasa" => $Kasa,
                "OdemeTarihi" => date("Y-m-d H:i:s")
            ), "SiparisID={$SiparisID}");
        
            
                $fimy_siparis_formu = $vt->listele("fimy_siparis_formu", "WHERE ID={$SiparisID}");
                if ($fimy_siparis_formu != null) foreach ($fimy_siparis_formu as $siparisf) {
                    $MusID = $siparisf['MusteriID'];
                    $SiparisNo = $siparisf['SiparisNo'];
                }
                $Aciklama = $SiparisNo." numaralı sipariş";
                /// Borç Cari - Başlangıç
                $ParaBirimi = 2;
                // $MusID = 0;
                $TutarB = $KalanTutar - $OnOdeme;
                $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=1");
                if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $B) {
                    $Borc = $B['Tutar'];
                }
                $icrm_borcalacak = $vt->listele("fimy_borc_alacak", "WHERE MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=2");
                if ($icrm_borcalacak != null) foreach ($icrm_borcalacak as $B) {
                    $Alacak = $B['Tutar'];
                }


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

                    (float)$EldeKalan = (float)$TutarB - (float)$Alacak;
                    if ($EldeKalan == 0) {
                        $BorcGuncelle = 0;
                        $AlacakGuncelle = 0;
                    } else if ($EldeKalan > 0) {
                        $AlacakGuncelle = 0;
                        $BorcGuncelle = $EldeKalan;
                    } else if ($EldeKalan < 0) {
                        $EldeKalan = abs($EldeKalan);
                        $BorcGuncelle = 0;
                        $AlacakGuncelle = $EldeKalan;
                    } else {
                    }

                    // BorcAlacak + TutarB Alanı Bitiş
                    $dovizcifti = 1;
                    $fimy_dovizcifti = $vt->listele("fimy_dovizcifti", "WHERE PB1={$ParaBirimi}");
                    if ($fimy_dovizcifti != null) foreach ($fimy_dovizcifti as $df) {
                        $dovizcifti = $df['ID'];
                    }
                    $fimy_dovizkurlari = $vt->listele("fimy_dovizkurlari", "WHERE DovizID={$dovizcifti}");
                    if ($fimy_dovizkurlari != null) foreach ($fimy_dovizkurlari as $dk) {
                        
                        $aliskuru = $dk['Alis'];
                        $satiskuru = $dk['Satis'];
                    }
                    
                    // Hareket Tablosuna Ekleme
                    // Tur : 1 - Borc 2 - Alacak
                    $icrm_bahareket = $vt->ekle("fimy_ba_hareket", array(
                        "MID" => $MusID,
                        "BorcAlacak" => 1,
                        "Tutar" => $TutarB,
                        "ParaBirimi" => $ParaBirimi,
                        "Kur" => $satiskuru,
                        "Aciklama" => $Aciklama
                    ));
                    // Hareket Tablosuna Ekleme End

                    // Hareket tablosuna göre Borç ve Alacak güncelleme
                    if ($icrm_bahareket > 0) {

                        // Tur : 1 - Borc 2 - Alacak
                        $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $BorcGuncelle), "MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=1");
                        $icrm_borcalacak = $vt->guncelle("fimy_borc_alacak", array("Tutar" => $AlacakGuncelle), "MID={$MusID} and ParaBirimi={$ParaBirimi} and BorcAlacak=2");

                        // $response[] = array('status' => 'success', 'message' => 'Borç eklendi..', 'refresh' => 1);
                        // echo json_encode($response);
                    } else {
                        $response[] = array('status' => 'error', 'message' => 'Girilen Tutar Borç Limitinden Yüksek!', 'refresh' => 0);
                        echo json_encode($response);
                        exit;
                    }
                    // Hareket tablosuna göre Borç ve Alacak güncelleme End

                }
                /// Borç Cari - Bitiş
                if($OdemeTipi == 1){
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

                $TutarOdeme = $KalanTutar - $OnOdeme;
                $kasa = $Kasa;
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


                        $response[] = array('status' => 'success', 'message' => 'Ürün Çıkışı Yapıldı.. Muhasebe tarafına işlendi..', 'refresh' => 1);
                        echo json_encode($response);
                } else {

                        $response[] = array('status' => 'error', 'message' => 'Sistemsel sorun oluştu, sistem yöneticiniz ile iletişime geçiniz.. \n Hata Kodu: ICONERROR:TillExportImport002', 'refresh' => 1);
                        echo json_encode($response);
                }

                // Müşteri Ödeme Hareketi Ekle Sorgusu ve Kasa Bakiye Güncelleme End




        }
                
            }
        }
       // echo $UrunIDS . " Çıkış yapıldı..";
    }

?>
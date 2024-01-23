<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-bordered nav-justified">
                                <li class="nav-item">
                                    <a href="#odemehareketleri" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                        Aracı Firma Özet Raporu
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tumbilethareketleri" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                        Tüm Bilet Haraketleri
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#aylikbilethareketleri" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                        Aylık Bilet Haraketleri
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="odemehareketleri">
                                    <div class="table-responsive">
                                        <h4> Tüm Dönemler Aracı Firma Özeti</h4>
                                        <table id="aracifirmarapor" class="table mg-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Firma</th>
                                                    <th>Komisyon Tutarı</th>
                                                    <th>Toplam Tutar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $fimy_aracirapor = $vt->ozellistele("SELECT af.Firma, sum(bo.KomisyonTutari) as komisyontoplam, sum(bo.TotalUcret) as toplam FROM fimy_biletodeme bo, fimy_biletbilgisi bb, fimy_aracifirma af WHERE bo.BiletID=bb.ID and bb.AraciFirma=af.ID GROUP BY bb.AraciFirma;");
                                                if ($fimy_aracirapor != null) foreach ($fimy_aracirapor as $aracir) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $aracir['Firma']; ?></td>
                                                        <td><?php echo number_format($aracir['komisyontoplam'], 2, ',', '.'); ?> ₺ </td>
                                                        <td><?php echo number_format($aracir['toplam'], 2, ',', '.'); ?> ₺ </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div><!-- table-responsive -->
                                    <hr>
                                    <div class="table-responsive">
                                        <?php
                                        $dinamiktarih = date("Y-m-d 23:59:59");
                                        $BugununTarihi = new DateTime($dinamiktarih);
                                        $OncesiTarih = clone $BugununTarihi; // Doğru yaklaşım değil, hata verir
                                        $OncesiTarih->modify("-1 month");
                                        $OncesiTarih->setTime(0, 0, 0);

                                        $before = $BugununTarihi->format("Y-m-d H:i:s");
                                        $after = $OncesiTarih->format("Y-m-d H:i:s");
                                        ?>
                                        <h4> Aylık Aracı Firma Özeti | <?php echo $after . " - " . $before; ?> </h4>
                                        <table id="aracifirmarapor" class="table mg-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Firma</th>
                                                    <th>Komisyon Tutarı</th>
                                                    <th>Toplam Tutar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $fimy_aracirapor = $vt->ozellistele("SELECT af.Firma, sum(bo.KomisyonTutari) as komisyontoplam, sum(bo.TotalUcret) as toplam FROM fimy_biletodeme bo, fimy_biletbilgisi bb, fimy_aracifirma af WHERE bo.BiletID=bb.ID and bb.AraciFirma=af.ID and bo.Proccess_Date > '" . $after . "' and bo.Proccess_Date <= '" . $before . "' GROUP BY bb.AraciFirma;");
                                                if ($fimy_aracirapor != null) foreach ($fimy_aracirapor as $aracir) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $aracir['Firma']; ?></td>
                                                        <td><?php echo number_format($aracir['komisyontoplam'], 2, ',', '.'); ?> ₺ </td>
                                                        <td><?php echo number_format($aracir['toplam'], 2, ',', '.'); ?> ₺ </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div><!-- table-responsive -->

                                </div>

                                <div class="tab-pane" id="tumbilethareketleri">
                                    <div class="row">
                                        <?php
                                        $BiletlerOzet = $vt->ozellistele("SELECT COUNT(bb.ID) as biletsayisi, sum(bo.KomisyonTutari) as komisyontoplam, sum(bo.TotalUcret) as toplam FROM fimy_biletodeme bo, fimy_biletbilgisi bb, fimy_aracifirma af
                                        WHERE bo.BiletID=bb.ID
                                        and bb.AraciFirma=af.ID;");
                                        if ($BiletlerOzet != null) foreach ($BiletlerOzet as $bb) {
                                            $biletsayisi = $bb['biletsayisi'];
                                            $komisyontoplam = $bb['komisyontoplam'];
                                            $toplam = $bb['toplam'];
                                        }
                                        ?>
                                        <div class="col-lg-4 text-center">
                                            <h4>Toplam Bilet Sayısı</h4>
                                            <h4> <?php echo $biletsayisi; ?> </h4>
                                        </div>
                                        <div class="col-lg-4 text-center">
                                            <h4>Toplam Bilet Tutarı</h4>
                                            <h4> <?php echo number_format($toplam, 2, ',', '.'); ?> </h4>
                                        </div>
                                        <div class="col-lg-4 text-center">
                                            <h4>Toplam Komisyon Tutarı</h4>
                                            <h4> <?php echo number_format($komisyontoplam, 2, ',', '.'); ?> </h4>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="pgc" class="table mg-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Oluşturma Tarihi</th>
                                                    <th>FiPNR</th>
                                                    <th>PNR</th>
                                                    <th>Tarih ve Saat</th>
                                                    <th>Yolcu</th>
                                                    <th>Komisyon</th>
                                                    <th>Total Ücret</th>
                                                    <th>Ödeme Yöntemi</th>
                                                    <th>Firma</th>
                                                    <th>İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $Biletler = $vt->ozellistele("SELECT fb.ID, fb.FiPNR, fb.Proccess_Date, fu.PNR, fu.Tarih, fy.Adi, fy.Soyadi, fbi.KomisyonTutari, fbi.TotalUcret, fbi.OdemeYontemi, faf.Firma
                                                FROM fimy_biletbilgisi fb, fimy_ucus fu, fimy_yolcu fy, fimy_biletodeme fbi, fimy_aracifirma faf
                                                where fu.ID=fb.UcusID and fy.ID = fb.YolcuID and fb.ID=fbi.BiletID and faf.ID=fb.AraciFirma;");
                                                if ($Biletler != null) foreach ($Biletler as $bilet) {
                                                    $odeme = "";
                                                    if ($bilet['OdemeYontemi'] == 1) {
                                                        $odeme = "Nakit";
                                                    } else if ($bilet['OdemeYontemi'] == 2) {
                                                        $odeme = "Kredi Kartı(Firma)";
                                                    } else if ($bilet['OdemeYontemi'] == 3) {
                                                        $odeme = "Havale/EFT";
                                                    } else if ($bilet['OdemeYontemi'] == 4) {
                                                        $odeme = "Kredi Kartı(Müşteri)";
                                                    } else if ($bilet['OdemeYontemi'] == 5) {
                                                        $odeme = "Borç";
                                                    }
                                                    echo '<tr>
                                                        <td>' . date("d.m.Y H:i", strtotime($bilet['Proccess_Date'])) . '</td>
                                                        <td>' . $bilet['FiPNR'] . '</td>
                                                        <td>' . $bilet['PNR'] . '</td>
                                                        <td>' . $bilet['Tarih'] . '</td>
                                                        <td>' . $bilet['Adi'] . ' ' . $bilet['Soyadi'] . '</td>
                                                        <td>' . number_format($bilet['KomisyonTutari'], 2, ',', '.') . ' ₺</td>
                                                        <td>' . number_format($bilet['TotalUcret'], 2, ',', '.') . ' ₺</td>
                                                        <td>' . $odeme . '</td>
                                                        <td>' . $bilet['Firma'] . '</td>
                                                        <td><a href="bilet-detay.php?ID=' . $bilet['ID'] . '">Detay</a>
                                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Ödeme Al</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Durum Güncelle</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">İptal Et</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Düzenle</a>
                                            </div>
                                        </div>
                                                        </td>
                                                        </tr>';
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div><!-- table-responsive -->
                                </div>
                                <div class="tab-pane" id="aylikbilethareketleri">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ucustarihi">Başlangıç Tarihi</label>
                                                        <input type="text" id="baslangic" class="form-control" placeholder="Başlangıç Tarihi">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ucustarihi">Bitiş Tarihi</label>
                                                        <input type="text" id="bitis" class="form-control" placeholder="Bitiş Tarihi">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="submti">* Lütfen tarih seçimine dikkat ediniz..</label>
                                                        <input type="submit" id="veriyigetir" class="btn btn-soft-success col-lg-12" value="Listele">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="AylikRaporlamaDivi" > 
                                    <div  class="row">
                                        <h5 class="text-center"> <?php echo $after . " - " . $before . " Tarihleri Arasına Ait Hareketler"; ?> </h5>
                                        <?php
                                        $BiletlerOzet = $vt->ozellistele("SELECT COUNT(bb.ID) as biletsayisi, sum(bo.KomisyonTutari) as komisyontoplam, sum(bo.TotalUcret) as toplam FROM fimy_biletodeme bo, fimy_biletbilgisi bb, fimy_aracifirma af
                                        WHERE bo.BiletID=bb.ID
                                        and bb.AraciFirma=af.ID
                                        and bo.Proccess_Date > '" . $after . "' and bo.Proccess_Date <= '" . $before . "';");
                                        if ($BiletlerOzet != null) foreach ($BiletlerOzet as $bb) {
                                            $biletsayisi = $bb['biletsayisi'];
                                            $komisyontoplam = $bb['komisyontoplam'];
                                            $toplam = $bb['toplam'];
                                        }
                                        ?>
                                        <div class="col-lg-4 text-center">
                                            <h4>Toplam Bilet Sayısı</h4>
                                            <h4> <?php echo $biletsayisi; ?> </h4>
                                        </div>
                                        <div class="col-lg-4 text-center">
                                            <h4>Toplam Bilet Tutarı</h4>
                                            <h4> <?php echo number_format($toplam, 2, ',', '.'); ?> </h4>
                                        </div>
                                        <div class="col-lg-4 text-center">
                                            <h4>Toplam Komisyon Tutarı</h4>
                                            <h4> <?php echo number_format($komisyontoplam, 2, ',', '.'); ?> </h4>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="aylikbilet" class="table mg-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Oluşturma Tarihi</th>
                                                    <th>FiPNR</th>
                                                    <th>Yolcu</th>
                                                    <th>Komisyon</th>
                                                    <th>Total Ücret</th>
                                                    <th>Ödeme Yöntemi</th>
                                                    <th>Firma</th>
                                                    <th>İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $Biletler = $vt->ozellistele("SELECT fb.ID, fb.FiPNR, fb.Proccess_Date, fu.PNR, fu.Tarih, fy.Adi, fy.Soyadi, fbi.KomisyonTutari, fbi.TotalUcret, fbi.OdemeYontemi, faf.Firma
                                                FROM fimy_biletbilgisi fb, fimy_ucus fu, fimy_yolcu fy, fimy_biletodeme fbi, fimy_aracifirma faf
                                                where fu.ID=fb.UcusID and fy.ID = fb.YolcuID and fb.ID=fbi.BiletID and faf.ID=fb.AraciFirma
                                                and fbi.Proccess_Date > '" . $after . "' and fbi.Proccess_Date <= '" . $before . "';");
                                                if ($Biletler != null) foreach ($Biletler as $bilet) {
                                                    $odeme = "";
                                                    if ($bilet['OdemeYontemi'] == 1) {
                                                        $odeme = "Nakit";
                                                    } else if ($bilet['OdemeYontemi'] == 2) {
                                                        $odeme = "Kredi Kartı(Firma)";
                                                    } else if ($bilet['OdemeYontemi'] == 3) {
                                                        $odeme = "Havale/EFT";
                                                    } else if ($bilet['OdemeYontemi'] == 4) {
                                                        $odeme = "Kredi Kartı(Müşteri)";
                                                    } else if ($bilet['OdemeYontemi'] == 5) {
                                                        $odeme = "Borç";
                                                    }
                                                    echo '<tr>
                                                        <td>' . date("d.m.Y H:i", strtotime($bilet['Proccess_Date'])) . '</td>
                                                        <td>' . $bilet['FiPNR'] . '</td>
                                                        <td>' . $bilet['Adi'] . ' ' . $bilet['Soyadi'] . '</td>
                                                        <td>' . number_format($bilet['KomisyonTutari'], 2, ',', '.') . ' ₺</td>
                                                        <td>' . number_format($bilet['TotalUcret'], 2, ',', '.') . ' ₺</td>
                                                        <td>' . $odeme . '</td>
                                                        <td>' . $bilet['Firma'] . '</td>
                                                        <td><a href="bilet-detay.php?ID=' . $bilet['ID'] . '">Detay</a>
                                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Ödeme Al</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Durum Güncelle</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">İptal Et</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Düzenle</a>
                                            </div>
                                        </div>
                                                        </td>
                                                        </tr>';
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div><!-- table-responsive -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->


        </div> <!-- container -->

    </div> <!-- content -->
    <script>
        $(document).ready(function() {
            var bugun = new Date();

            // Bir ay önceki tarihi hesapla
            var birAyOnce = new Date();
            birAyOnce.setMonth(birAyOnce.getMonth() - 1);

            // flatpickr ile tarih seçiciyi başlat
            flatpickr("#baslangic", {
                minDate: birAyOnce,
                dateFormat: "Y-m-d"
            });
            flatpickr("#bitis", {
                minDate: birAyOnce,
                maxDate: bugun,
                dateFormat: "Y-m-d"
            });
            $("#veriyigetir").on("click", function() {
                var baslangic = $('#baslangic').val();
                var bitis = $('#bitis').val();

                if (baslangic && bitis) {
                    // Tarihleri JavaScript Date nesnelerine dönüştür
                    var baslangicTarih = new Date(baslangic);
                    var bitisTarih = new Date(bitis);

                    if (baslangicTarih <= bitisTarih) {
                        var raporgetirdata = 'baslangic=' + baslangic + '&bitis=' + bitis;

                        $.ajax({
                            url: '../rapor/process/aylik-bilet-rapor.fi',
                            type: 'POST',
                            data: raporgetirdata,
                            success: function(e) {
                                $("div#AylikRaporlamaDivi").html("").html(e);
                            }
                        });
                    } else {
                        // Başlangıç tarihi bitiş tarihinden büyükse veya uygun değilse hata mesajı gösterin
                        alert("Başlangıç tarihi, bitiş tarihinden büyük olamaz.");
                    }
                } else {
                    // Tarihler boşsa veya geçersizse hata mesajı gösterin
                    alert("Geçerli başlangıç ve bitiş tarihleri giriniz.");
                }
            });
            var pgc = $("#pgc").DataTable({
                lengthChange: !1,
                buttons: ["copy", "excel", "pdf"],
                "lengthMenu": [50, 100, 150, 250, 300]
            });
            pgc.buttons().container().appendTo("#pgc_wrapper .col-md-6:eq(0)");
            var aylikbilet = $("#aylikbilet").DataTable({
                lengthChange: !1,
                buttons: ["copy", "excel", "pdf"],
                "lengthMenu": [50, 100, 150, 250, 300]
            });
            aylikbilet.buttons().container().appendTo("#aylikbilet_wrapper .col-md-6:eq(0)");
        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
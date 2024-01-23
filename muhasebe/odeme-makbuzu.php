<?php include("../src/access.php");
if ($_GET) {
    if ($_GET['OdemeNo']) {
        $OdemeNo = $_GET['OdemeNo'];
?>
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <link href="../assets/css/app-makbuz.css" rel="stylesheet" type="text/css" id="app-style" />
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $siteoptions = $vt->listele("fimy_appoptions");
                                    if ($siteoptions != null) foreach ($siteoptions as $opt) {
                                        $firma = $opt['FirmaAdi'];
                                        $logo = $opt['Logo'];
                                        $Adres = $opt['Adres'];
                                        $Telefon = $opt['Telefon'];
                                        $Mail = $opt['Mail'];
                                    }
                                    ?>
                                    <div id="html-template">
                                        <div class="header">
                                            <img src="<?php echo $logo; ?>" alt="<?php echo $firma; ?>">
                                            <h2><?php echo $firma; ?></h2>
                                            <p><?php echo $Adres; ?></p>
                                            <p><b>Telefon:</b> <?php echo $Telefon; ?></p>
                                            <p><b>Mail:</b> <?php echo $Mail; ?></p>
                                            <p class="text-end"> <b> Ödeme Makbuzu </b> </p>
                                        </div>
                                        <?php
                                        $icrm_bahareket = $vt->listele("fimy_m_odemehareket", "WHERE ID={$OdemeNo}");
                                        if ($icrm_bahareket != null) foreach ($icrm_bahareket as $bah) {
                                            $MusteriID = $bah['MID'];
                                            $Tur = "";
                                            if ($bah['AlVer'] == 1) {
                                                $Tur = "Ödeme Yapıldı";
                                            } else if ($bah['AlVer'] == 2) {
                                                $Tur = "Ödeme Alındı";
                                            } else {
                                                $Tur = "SystemErrorICON_OdemeListeme228";
                                            }
                                            $KA = $bah['KasaID'];
                                            $PB = $bah['PBID'];
                                            $icrm_kasalar = $vt->listele("fimy_kasa", "WHERE ID='" . $KA . "'");
                                            if ($icrm_kasalar != null) foreach ($icrm_kasalar as $f) {
                                                $KasaAdi = $f['KasaAdi'];
                                            }
                                            $icrm_pb = $vt->listele("fimy_parabirimi", "WHERE ID='" . $PB . "'");
                                            if ($icrm_pb != null) foreach ($icrm_pb as $pb) {
                                                $exentedpb = $pb['Aciklama'];
                                            }
                                            $fimy_cari_hesap = $vt->listele("fimy_cari_hesap", "WHERE ID='" . $MusteriID . "'");
                                            if ($fimy_cari_hesap != null) foreach ($fimy_cari_hesap as $ms) {
                                                $Adi = $ms['Adi'];
                                                $Soyadi = $ms['Soyadi'];
                                                $Tel = $ms['Tel'];
                                            }
                                            $fimy_cari_hesap = $vt->listele("fimy_cari_hesap", "WHERE ID='" . $MusteriID . "'");
                                            if ($fimy_cari_hesap != null) foreach ($fimy_cari_hesap as $ms) {
                                                $Adi = $ms['Adi'];
                                                $Soyadi = $ms['Soyadi'];
                                                $Tel = $ms['Tel'];
                                            }
                                        ?>
                                            <div class="content">
                                                <div class="info">
                                                    <p><b>Sıra No:</b> <?php echo $bah['OdemeSN']; ?></p>
                                                    <p><b>Tarih:</b> <?php $kt = new DateTime($bah['Tarih']);
                                                                echo $kt->format('d.m.Y H:i'); ?></p>
                                                </div>
                                                <div class="payment">
                                                    <p><b>Ödeme Yapan:</b><?php echo $Adi . " " . $Soyadi; ?></p>
                                                    <p><b>İletişim Bilgileri:</b> <?php echo $Tel; ?> </p>
                                                    <p><b>Ödeme Tipi:</b> Nakit</p>
                                                    <p><b>Tutar:</b> <?php echo number_format($bah['Tutar'], 2, ',', '.'); ?> <?php echo $exentedpb; ?></p>
                                                </div>
                                                <div class="payment">
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <th> Toplam Borç </th>
                                                            <th> Alınan Ödeme </th>
                                                            <th> Kalan Borç </th>
                                                        </thead>
                                                        <tbody>
                                                            <td style="font-family: Arial, Helvetica, sans-serif; font-size:18px;"> <?php echo number_format($bah['OankiBorc'], 2, ',', '.'); ?> <?php echo $exentedpb; ?> </td>
                                                            <td style="font-family: Arial, Helvetica, sans-serif; font-size:18px;"> <?php echo number_format($bah['Tutar'], 2, ',', '.'); ?> <?php echo $exentedpb; ?> </td>
                                                            <td style="font-family: Arial, Helvetica, sans-serif; font-size:18px;"> <?php $ozet = $bah['OankiBorc'] - $bah['Tutar']; echo number_format($ozet, 2, ',', '.'); ?> <?php echo $exentedpb; ?>  </td>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br><br>
                                                <div class="details">
                                                    <p><b>Sayın </b><i><?php echo $Adi . " " . $Soyadi; ?>'dan</i>,
                                                        <u>"<?php echo $bah['Aciklama']; ?>"</u> notuyla, <b><i style="font-family: Arial, Helvetica, sans-serif !important; font-size:18px;"> <?php echo number_format($bah['Tutar'], 2, ',', '.'); ?> </i> <?php echo $exentedpb; ?> </b> <b> alınmıştır.</b>
                                                    </p>
                                                </div>
                                                <br>
                                                <div class="signature">
                                                    <div class="row">
                                                        <div class="col-lg-6 text-start"><u>Ödeme Yapan</u></div>
                                                        <div class="col-lg-6"><u>Ödeme Alan</u></div>
                                                    </div>
                                                    <br><br>
                                                    <br><br>
                                                </div>
                                            <?php
                                        }
                                            ?>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                </div> <!-- container -->

            </div> <!-- content -->

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
    <?php
        include("../src/footer-alt.php");
    } else {
        include("../src/footer-alt.php");
        echo "
            <script>
            Swal.fire({ title: 'Hata!', text: 'Geçersiz parametre. Lütfen kontrol ediniz!', icon: 'error' });
                        setTimeout(function() {
                            window.location.href = '../muhasebe/musteriler.fi';
                        }, 800);
            </script>";
    }
} else {
    include("../src/footer-alt.php");
    echo "
            <script>
            Swal.fire({ title: 'Hata!', text: 'Böyle bir parametre yok. lütfen kontrol ediniz!', icon: 'error' });
                        setTimeout(function() {
                            window.location.href = '../muhasebe/musteriler.fi';
                        }, 800);
            </script>";
}

    ?>
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
                                        Tur Rezervasyon Özet Raporu
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tumbilethareketleri" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                        Tüm Tur Haraketleri
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#aylikbilethareketleri" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                        Aylık Tur Haraketleri
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="odemehareketleri">
                                    <div class="table-responsive">
                                        <h4> Tüm Dönemler Rezervasyon Özeti</h4>
                                        <table id="aracifirmaraportum" class="table mg-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Tur Adı</th>
                                                    <th>Toplam Tutar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $fimy_aracirapor = $vt->ozellistele("SELECT tur.TurAdi, SUM(Ucret) as Toplam, SUM(Komisyon) as Komisyon
                                                FROM fimy_rez_odeme ro, fimy_tur_rez tr, fimy_tur tur
                                                WHERE ro.RezID = tr.ID and tur.ID = tr.TurID GROUP BY tur.TurAdi");
                                                if ($fimy_aracirapor != null) foreach ($fimy_aracirapor as $aracir) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $aracir['TurAdi']; ?></td>
                                                        <td><?php echo number_format($aracir['Toplam'], 2, ',', '.'); ?> ₺ </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div><!-- table-responsive -->
                                    <hr>
                                    <?php
                                    $dinamiktarih = date("Y-m-d 23:59:59");
                                    $BugununTarihi = new DateTime($dinamiktarih);
                                    $OncesiTarih = clone $BugununTarihi; // Doğru yaklaşım değil, hata verir
                                    $OncesiTarih->modify("-1 month");
                                    $OncesiTarih->setTime(0, 0, 0);

                                    $before = $BugununTarihi->format("Y-m-d H:i:s");
                                    $after = $OncesiTarih->format("Y-m-d H:i:s");
                                    ?>
                                    <h4> Aylık Rezervasyon Özet Raporu | <?php echo $after . " - " . $before; ?> </h4>
                                    <div class="table-responsive">
                                        <table id="aracifirmarapor" class="table mg-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Firma</th>
                                                    <th>Toplam Tutar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $fimy_aracirapor = $vt->ozellistele("SELECT tur.TurAdi, SUM(Ucret) as Toplam, SUM(Komisyon) as Komisyon FROM fimy_rez_odeme ro, fimy_tur_rez tr, fimy_tur tur WHERE ro.RezID = tr.ID and tur.ID = tr.TurID and tr.Procces_Date > '" . $after . "' and tr.Procces_Date <= '" . $before . "' GROUP BY tur.TurAdi;");
                                                if ($fimy_aracirapor != null) foreach ($fimy_aracirapor as $aracir) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $aracir['TurAdi']; ?></td>
                                                        <td><?php echo number_format($aracir['Toplam'], 2, ',', '.'); ?> ₺ </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div><!-- table-responsive -->

                                </div>
                                <div class="tab-pane active" id="tumbilethareketleri">
                                    <div class="table-responsive">
                                        <h4> Tüm Dönemler Rezervasyon Özeti</h4>
                                        <table id="aracifirmaraportum" class="table mg-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Tur Adı</th>
                                                    <th>Toplam Tutar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $fimy_aracirapor = $vt->ozellistele("SELECT tur.TurAdi, SUM(Ucret) as Toplam, SUM(Komisyon) as Komisyon
                                                FROM fimy_rez_odeme ro, fimy_tur_rez tr, fimy_tur tur
                                                WHERE ro.RezID = tr.ID and tur.ID = tr.TurID GROUP BY tur.TurAdi");
                                                if ($fimy_aracirapor != null) foreach ($fimy_aracirapor as $aracir) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $aracir['TurAdi']; ?></td>
                                                        <td><?php echo number_format($aracir['Toplam'], 2, ',', '.'); ?> ₺ </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div><!-- table-responsive -->
                                    <hr>
                                    <?php
                                    $dinamiktarih = date("Y-m-d 23:59:59");
                                    $BugununTarihi = new DateTime($dinamiktarih);
                                    $OncesiTarih = clone $BugununTarihi; // Doğru yaklaşım değil, hata verir
                                    $OncesiTarih->modify("-1 month");
                                    $OncesiTarih->setTime(0, 0, 0);

                                    $before = $BugununTarihi->format("Y-m-d H:i:s");
                                    $after = $OncesiTarih->format("Y-m-d H:i:s");
                                    ?>
                                    <h4> Aylık Rezervasyon Özet Raporu | <?php echo $after . " - " . $before; ?> </h4>
                                    <div class="table-responsive">
                                        <table id="aracifirmarapor" class="table mg-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Firma</th>
                                                    <th>Toplam Tutar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $fimy_aracirapor = $vt->ozellistele("SELECT tur.TurAdi, SUM(Ucret) as Toplam, SUM(Komisyon) as Komisyon FROM fimy_rez_odeme ro, fimy_tur_rez tr, fimy_tur tur WHERE ro.RezID = tr.ID and tur.ID = tr.TurID and tr.Procces_Date > '" . $after . "' and tr.Procces_Date <= '" . $before . "' GROUP BY tur.TurAdi;");
                                                if ($fimy_aracirapor != null) foreach ($fimy_aracirapor as $aracir) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $aracir['TurAdi']; ?></td>
                                                        <td><?php echo number_format($aracir['Toplam'], 2, ',', '.'); ?> ₺ </td>
                                                    </tr>
                                                <?php
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
            <!-- end row -->


        </div> <!-- container -->

    </div> <!-- content -->
    <script>
        $(document).ready(function() {
            var aracifirmarapor = $("#aracifirmarapor").DataTable({
                lengthChange: !1,
                buttons: ["copy", "excel", "pdf", "colvis"],
                "lengthMenu": [50, 100, 150, 250, 300]
            });
            aracifirmarapor.buttons().container().appendTo("#aracifirmarapor_wrapper .col-md-6:eq(0)");
            var aracifirmaraportum = $("#aracifirmaraportum").DataTable({
                lengthChange: !1,
                buttons: ["copy", "excel", "pdf", "colvis"],
                "lengthMenu": [50, 100, 150, 250, 300]
            });
            aracifirmaraportum.buttons().container().appendTo("#aracifirmaraportum_wrapper .col-md-6:eq(0)");
        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
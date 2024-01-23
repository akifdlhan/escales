<?php include("../src/access.php");
if ($_GET) {
    $KasaID = $_GET['KasaID'];
    $fimy_kasa = $vt->listele("fimy_kasa", "WHERE ID={$KasaID}");
    if ($fimy_kasa != null) foreach ($fimy_kasa as $kasalar) {
        $KasaID = $kasalar['ID'];
        $Bakiye = $kasalar['Bakiye'];

        echo '<script>
          newTitle="' . $kasalar['KasaAdi'] . ' | Tüm Hareketler | ' . $_SESSION['Firma'] . '";
          document.title = newTitle;
          document.getElementById("page-title-main").innerHTML = "' . $kasalar['KasaAdi'] . ' Tüm Hareketler ";
          </script>';
        $KPB = $kasalar['ParaBirimi'];
        $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE ID='" . $KPB . "'");
        if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $pb) {
            $exentedpb = $pb['ParaBirimi'];
        }
?>
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4> Alınan Ödemeler </h4>
                                    <?php
                                    $fimy_kasa = $vt->ozellistele("SELECT SUM(Tutar) as ToplamAlinan FROM `fimy_m_odemehareket` WHERE KasaID={$KasaID} and AlVer=2;");
                                    if ($fimy_kasa != null) foreach ($fimy_kasa as $kasalar) {
                                        $toplama = $kasalar['ToplamAlinan'];
                                    }
                                    echo "<h5>" . number_format($toplama, 2, ',', '.') . " " . $exentedpb . "</h5>";
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4> Yapılan Ödemeler </h4>
                                    <?php
                                    $fimy_kasa = $vt->ozellistele("SELECT SUM(Tutar) as ToplamAlinan FROM `fimy_m_odemehareket` WHERE KasaID={$KasaID} and AlVer=1;");
                                    if ($fimy_kasa != null) foreach ($fimy_kasa as $kasalar) {
                                        $toplama = $kasalar['ToplamAlinan'];
                                    }
                                    echo "<h5>" . number_format($toplama, 2, ',', '.') . " " . $exentedpb . "</h5>";
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4> Para Girişi </h4>
                                    <?php
                                    $fimy_kasa = $vt->ozellistele("SELECT SUM(Tutar) as ToplamAlinan FROM `fimy_kasaparagc` WHERE KasaID={$KasaID} and Tur=1;");
                                    if ($fimy_kasa != null) foreach ($fimy_kasa as $kasalar) {
                                        $toplama = $kasalar['ToplamAlinan'];
                                    }
                                    echo "<h5>" . number_format($toplama, 2, ',', '.') . " " . $exentedpb . "</h5>";
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4> Para Çıkışı </h4>
                                    <?php
                                    $fimy_kasa = $vt->ozellistele("SELECT SUM(Tutar) as ToplamAlinan FROM `fimy_kasaparagc` WHERE KasaID={$KasaID} and Tur=2;");
                                    if ($fimy_kasa != null) foreach ($fimy_kasa as $kasalar) {
                                        $toplama = $kasalar['ToplamAlinan'];
                                    }
                                    echo "<h5>" . number_format($toplama, 2, ',', '.') . " " . $exentedpb . "</h5>";
                                    ?>
                                </div>
                            </div>
                        </div>





                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-bordered nav-justified">
                                        <li class="nav-item">
                                            <a href="#odemehareketleri" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                                Ödeme Haraketleri
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#paragchareketleri" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                                Para Giriş-Çıkış Haraketleri
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="odemehareketleri">
                                            <div class="table-responsive">
                                                <table id="po" class="table mg-b-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Müşteri</th>
                                                            <th>Al - Ver</th>
                                                            <th>Tutar</th>
                                                            <th>Açıklama</th>
                                                            <th>Tarih</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $fimy_m_odemehareket = $vt->listele("fimy_m_odemehareket", "WHERE KasaID={$KasaID} ORDER BY ID DESC");
                                                        if ($fimy_m_odemehareket != null) foreach ($fimy_m_odemehareket as $bah) {
                                                            $Tur = "";
                                                            if ($bah['AlVer'] == 1) {
                                                                $Tur = "Ödeme Yapıldı";
                                                            } else if ($bah['AlVer'] == 2) {
                                                                $Tur = "Ödeme Alındı";
                                                            } else {
                                                                $Tur = "SystemErrorICON_OdemeListeme228";
                                                            }
                                                            $KA = $bah['KasaID'];
                                                            $MID = $bah['MID'];
                                                            $fimy_kasa = $vt->listele("fimy_kasa", "WHERE ID='" . $KA . "'");
                                                            if ($fimy_kasa != null) foreach ($fimy_kasa as $f) {
                                                                $KasaAdi = $f['KasaAdi'];
                                                            }
                                                            $fimy_cari_hesap = $vt->listele("fimy_cari_hesap", "WHERE ID='" . $MID . "'");
                                                            if ($fimy_cari_hesap != null) foreach ($fimy_cari_hesap as $m) {
                                                                $exentedisim = $m['Adi'];
                                                                $exentedsisim = $m['Soyadi'];
                                                                $MusAdiSoy = $exentedisim . " " . $exentedsisim;
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $MusAdiSoy; ?></td>
                                                                <td><?php echo $Tur; ?></td>
                                                                <td><?php echo number_format($bah['Tutar'], 2, ',', '.'); ?> ₺ </td>
                                                                <td><?php echo $bah['Aciklama']; ?></td>
                                                                <td><?php $kt = new DateTime($bah['Tarih']);
                                                                    echo $kt->format('d.m.Y H:i'); ?></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div><!-- table-responsive -->

                                        </div>

                                        <div class="tab-pane" id="paragchareketleri">
                                            <div class="table-responsive">
                                                <table id="pgc" class="table mg-b-0">
                                                    <thead>
                                                        <tr>
                                                            <th>İşlem Türü</th>
                                                            <th>Tutar</th>
                                                            <th>Para Birimi</th>
                                                            <th>Açıklama</th>
                                                            <th>Tarih</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $fimy_kasaparagc = $vt->listele("fimy_kasaparagc", "WHERE KasaID={$KasaID} ORDER BY ID DESC");
                                                        if ($fimy_kasaparagc != null) foreach ($fimy_kasaparagc as $paragc) {

                                                        ?>
                                                            <tr>
                                                                <td><?php // $paragc['Tur']; 
                                                                    if ($paragc['Tur'] == 1) {
                                                                        echo "Para Girişi";
                                                                    } else {
                                                                        echo "Para Çıkışı";
                                                                    }
                                                                    ?></td>
                                                                <td><?php echo number_format($paragc['Tutar'], 2, ',', '.');
                                                                    //echo $paragc['Tutar']; 
                                                                    ?></td>
                                                                <td><?php echo $exentedpb; ?></td>
                                                                <td><?php echo $paragc['Aciklama']; ?></td>
                                                                <td><?php $ttarih = $paragc['Tarih'];
                                                                    $t = new DateTime($ttarih);
                                                                    echo $t->format('d.m.Y H:i:s');
                                                                    ?></td>
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
                    var a = $("#po").DataTable({
                        lengthChange: !1,
                        buttons: ["copy", "excel", "pdf"],
                        order: [
                            [4, 'desc']
                        ],
                        "lengthMenu": [50, 100, 150, 250, 300]
                    });
                    a.buttons().container().appendTo("#po_wrapper .col-md-6:eq(0)");

                    var b = $("#pgc").DataTable({
                        lengthChange: !1,
                        buttons: ["copy", "excel", "pdf"],
                        order: [
                            [4, 'desc']
                        ],
                        "lengthMenu": [50, 100, 150, 250, 300]
                    });
                    b.buttons().container().appendTo("#pgc_wrapper .col-md-6:eq(0)");

                });
            </script>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
    <?php
    }
} else {
    include("../src/footer-alt.php");
    echo '<script>
        toastr["error"]("Kasa bilgisi çekilemedi..!");
        setTimeout(function() {
            window.location.href = "../";
        }, 800);
        </script>';
}
include("../src/footer-alt.php"); ?>

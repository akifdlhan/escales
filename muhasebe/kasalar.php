<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<script>
    // Sayfa tamamen yüklendiğinde çalışacak fonksiyon
    window.onload = function() {
        // boyutlandir div'inin yüksekliğini ölç
        var boyutlandirDiv = document.getElementById("boyutlandir");
        var boyutlandirYukseklik = boyutlandirDiv.clientHeight;

        // sabit div'inin yüksekliğini değiştir
        var sabitDiv = document.getElementById("sabit");
        sabitDiv.style.height = boyutlandirYukseklik + "px";
    };
</script>

<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div style="display: flex;align-items: center;justify-content: center;" id="sabit" class="col-lg-4">
                                    <center>
                                        <i style="font-size:50px; color:green;" class="ti-plus"></i>
                                    </center>
                                </div>
                                <div style="display: flex;align-items: center;justify-content: center;" class="col-lg-8">
                                    <center>
                                        <h4>
                                            <a data-bs-toggle="modal" data-bs-target="#page-add-kasa" data-animation="fadein" data-plugin="page-add-kasa" data-overlayspeed="200" data-overlaycolor="#36404a" href="#"> Kasa Ekle </a>
                                        </h4>
                                        <p style="color:black;"> </p>
                                        <a href=""> </a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $fimy_kasa = $vt->listele("fimy_kasa", "order by ID desc");
                if ($fimy_kasa != null) foreach ($fimy_kasa as $kasa) {
                    $pb = $kasa['ParaBirimi'];

                    $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE ID={$pb}");
                    if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $parabirimi) {
                        $pb_simge = $parabirimi['Aciklama'];
                    }

                ?>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div id="boyutlandir" class="col-lg-4">
                                        <center>
                                            <i style="font-size:50px; color:#be1622;" class="ti-wallet"></i>
                                        </center>
                                    </div>
                                    <div style="display: flex;align-items: center;justify-content: center;" class="col-lg-8">
                                        <center>
                                            <h5>
                                                <a href="kasa-hareketleri.php?KasaAdi=<?php echo $kasa['KasaAdi']; ?>&KasaID=<?php echo $kasa['ID']; ?>"> <?php
                                                if(strlen($kasa['KasaAdi']) > 25 ){
                                                    echo substr($kasa['KasaAdi'], 0, 25)."..";
                                                }else{
                                                    echo $kasa['KasaAdi'];
                                                }
                                                 ?> </a>
                                            </h5>
                                            <p style="color:black;"> <b style="color:#0e2d67 !important;">Bakiye.: </b> <?php echo number_format($kasa['Bakiye'], 2, ',', '.') . "" . $pb_simge; ?></p>
                                            <a href="kasa-hareketleri.php?KasaAdi=<?php echo $kasa['KasaAdi']; ?>&KasaID=<?php echo $kasa['ID']; ?>"> Tüm Hareketler </a>
                                            |
                                            <a href="kasa-sil.php?KasaAdi=<?php echo $kasa['KasaAdi']; ?>&KasaID=<?php echo $kasa['ID']; ?>"> Sil </a>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Modal -->
    <div class="modal fade" id="page-add-kasa" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Kasa Ekle</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">

                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="kasaadi">Kasa Adı</label>
                                    <input class="form-control" placeholder="Kasa Adı" id="kasaadi" required type="text">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="acilisbakiye">Açılış Bakiyesi</label>
                                    <input class="form-control" value="000,00" id="acbakiye" required type="text">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="acilisbakiye">Para Birimi</label>
                                    <select id="ParaBirimi" class="form-control select2">
                                        <option label="Para Birimi"></option>
                                        <?php
                                        $icrm_pb = $vt->listele("fimy_parabirimi","WHERE Aktif=1");
                                        if ($icrm_pb != null) foreach ($icrm_pb as $pb) {
                                            echo '<option value="' . $pb['ID'] . '">' . $pb['ParaBirimi'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="aciklama">Açıklama</label>
                                    <textarea id="aciklama" rows="3" class="form-control" placeholder="Açıklama"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <a id="addtill" type="button" class="btn btn-outline-success col-lg-12">Kaydet</a>
                                </div>
                                <div id="SearchModalBody"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script>
        $("#addtill").on("click", function() {
            var ds = 'KasaAdi=' + $('#kasaadi').val() +
                '&ABakiye=' + $('#acbakiye').val() +
                '&ParaBirimi=' + $('#ParaBirimi').val() +
                '&Aciklama=' + $('#aciklama').val();
            $.ajax({
                url: '../muhasebe/process/addtill.fi',
                type: 'POST',
                data: ds,
                success: function(e) {
                    $("div#SearchModalBody").html("").html(e);
                }
            });

        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
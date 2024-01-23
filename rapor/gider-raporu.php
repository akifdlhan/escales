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
                            <center>
                                <h4>
                                    Toplam Giderler
                                </h4>
                            </center>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th> Kullanıcı </th>
                                        <th> Kayıt Adeti </th>
                                        <th> Toplam </th>
                                    </tr>
                                </thead>
                                <?php
                                $gider = $vt->ozellistele("SELECT us.kullaniciadi, COUNT(gd.ID) as toplam, SUM(FaturaTutari) as toplamt FROM fimy_gider gd, fimy_user us WHERE us.ID=gd.Kullanici and gd.Onay=1 GROUP by gd.Kullanici;");
                                if ($gider != null) foreach ($gider as $g) {
                                    echo '
                                        <tr>
                                            <td> ' . $g['kullaniciadi'] . ' </td>
                                            <td> ' . $g['toplam'] . ' </td>
                                            <td> ' . number_format($g['toplamt'], 2, ',', '.') . ' ₺ </td>
                                        </tr>';
                                }
                                ?>

                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
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
                            <?php
                            $dinamiktarih = date("Y-m-d 23:59:59");
                            $BugununTarihi = new DateTime($dinamiktarih);
                            $OncesiTarih = clone $BugununTarihi; // Doğru yaklaşım değil, hata verir
                            $OncesiTarih->modify("-1 month");
                            $OncesiTarih->setTime(0, 0, 0);

                            $before = $BugununTarihi->format("Y-m-d H:i:s");
                            $after = $OncesiTarih->format("Y-m-d H:i:s");
                            ?>
                            <center>
                                <h4>
                                    Toplam Giderler | <?php echo $after . " - " . $before; ?>
                                </h4>
                            </center>
                            <table id="ozelgiderrapor" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th> Kullanıcı </th>
                                        <th> Kayıt Adeti </th>
                                        <th> Toplam </th>
                                    </tr>
                                </thead>
                                <?php

                                $gider = $vt->ozellistele("SELECT us.kullaniciadi, COUNT(gd.ID) as toplam, SUM(FaturaTutari) as toplamt
                                FROM fimy_gider gd, fimy_user us
                                WHERE us.ID=gd.Kullanici
                                and gd.ProccessDate > '" . $after . "' and gd.ProccessDate <= '" . $before . "'
                                and gd.Onay=1 GROUP by gd.Kullanici;");
                                if ($gider != null) foreach ($gider as $g) {
                                    echo '
                                        <tr>
                                            <td> ' . $g['kullaniciadi'] . ' </td>
                                            <td> ' . $g['toplam'] . ' </td>
                                            <td> ' . number_format($g['toplamt'], 2, ',', '.') . ' ₺ </td>
                                        </tr>';
                                }
                                ?>

                            </table>
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
            var birAyOnce = new Date();
            birAyOnce.setMonth(birAyOnce.getMonth() - 1);
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
                    var baslangicTarih = new Date(baslangic);
                    var bitisTarih = new Date(bitis);

                    if (baslangicTarih <= bitisTarih) {
                        var raporgetirdata = 'baslangic=' + baslangic + '&bitis=' + bitis;

                        $.ajax({
                            url: '../rapor/process/aylik-gider-rapor.fi',
                            type: 'POST',
                            data: raporgetirdata,
                            success: function(e) {
                                $("table#ozelgiderrapor").html("").html(e);
                            }
                        });
                    } else {
                        alert("Başlangıç tarihi, bitiş tarihinden büyük olamaz.");
                    }
                } else {
                    alert("Geçerli başlangıç ve bitiş tarihleri giriniz.");
                }
            });
        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
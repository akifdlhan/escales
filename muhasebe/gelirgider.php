<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style>
    .select2 {
        display: block !important;
        padding: 0.45rem 0.9rem;
        font-size: .9rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--ct-input-color);
        background-color: var(--ct-input-bg);
        border: 1px solid var(--ct-input-border-color);
        -webkit-appearance: none;
        appearance: none;
        border-radius: 0.2rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .select2-container {
        display: block !important;
        padding: 0.45rem 0.9rem;
        font-size: .9rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--ct-input-color);
        background-color: var(--ct-input-bg);
        background-clip: padding-box;
        border: 1px solid var(--ct-input-border-color);
        -webkit-appearance: none;
        appearance: none;
        border-radius: 0.2rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-3">
                                    <label class="form-label" for="gidertarihi">Gider Tarihi</label>
                                    <input type="text" id="gidertarihi" class="form-control" placeholder="Gider Tarihi">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label" for="gidertipi">Gider Tipi</label>
                                    <select id="gidertipi" name="gidertipi" class="form-select">
                                        <option value="0">Gider Tipi</option>
                                        <?php
                                        $fimy_gidertipi = $vt->listele("fimy_gidertipi");
                                        if ($fimy_gidertipi != null) foreach ($fimy_gidertipi as $gt) {
                                            echo '<option value="' . $gt['ID'] . '">' . $gt['GiderAdi'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label" for="tutar">Fatura Tutarı</label>
                                    <input type="text" id="tutar" class="form-control" placeholder="Fatura Tutarı">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label" for="OdemeKontrol">Ödeme Durumu</label>
                                    <center>
                                        <div class="row">
                                            <div class="col-lg-6 form-check">
                                                <input type="radio" value="0" id="odendi" name="OdemeKontrol" class="form-check-input" checked>
                                                <label class="form-check-label" for="customRadio1">Ödendi</label>
                                            </div>
                                            <div class="col-lg-6 form-check">
                                                <input type="radio" value="1" id="odenmedi" name="OdemeKontrol" class="form-check-input">
                                                <label class="form-check-label" for="customRadio2">Ödenmedi</label>
                                            </div>
                                        </div>
                                    </center>
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-label" for="serino">Fatura Seri No</label>
                                    <input type="text" id="serino" class="form-control" placeholder="Fatura Seri No">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label" for="aciklama">Açıklama</label>
                                    <input type="text" id="aciklama" class="form-control" placeholder="Açıklama">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label" for="sonodeme">Son Ödeme Tarihi</label>
                                    <input type="text" id="sonodeme" class="form-control" placeholder="Son Ödeme Tarihi">
                                </div>
                                <div id="kasadetayi" class="col-lg-4">
                                    <label class="form-label" for="kasa">Kasa</label>
                                    <select id="kasa" name="kasa" class="form-select">
                                        <option value="0">Kasa</option>
                                        <?php
                                        $fimy_kasa = $vt->listele("fimy_kasa","WHERE ParaBirimi=1");
                                        if ($fimy_kasa != null) foreach ($fimy_kasa as $ka) {
                                            echo '<option value="' . $ka['ID'] . '">' . $ka['KasaAdi'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div style="margin-top:20px;" class="col-lg-12 text-end">
                                    <button id="giderkaydet" class="btn btn-block btn-success"> Kaydet </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <?php
            $kullanici = $_SESSION['KID'];
            $fimy_gider = $vt->listele("fimy_user_access", "WHERE User_ID={$kullanici} and Access_Level in (0,2,6)");
            if ($fimy_gider != null) foreach ($fimy_gider as $gider) {
            }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <table id="gider-full" class="table dt-responsive table-responsive">
                        <thead>
                            <tr>
                                <th>İşlem Tarihi</th>
                                <th>Kullanıcı</th>
                                <th>Tarih</th>
                                <th>Gider Tipi</th>
                                <th>Fatura SN</th>
                                <th>Açıklama</th>
                                <th>Tutar</th>
                                <th>Ödeme Tarihi</th>
                                <th>Kasa</th>
                                <th>Ödeme Durumu</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $fimy_gider = $vt->listele("fimy_gider");
                            if ($fimy_gider != null) foreach ($fimy_gider as $gider) {
                                $fimy_user_details = $vt->listele("fimy_user_details", "WHERE User_ID={$gider['Kullanici']}");
                                if ($fimy_user_details != null) foreach ($fimy_user_details as $user) {
                                    $as = $user['Adi'] . " " . $user['Soyadi'];
                                }
                                if ($gider['OnayVeren'] == NULL) {
                                    $onaylayan = "";
                                } else {
                                    $fimy_user_details = $vt->listele("fimy_user_details", "WHERE User_ID={$gider['OnayVeren']}");
                                    if ($fimy_user_details != null) foreach ($fimy_user_details as $user) {
                                        $onaylayan = $user['Adi'] . " " . $user['Soyadi'];
                                    }
                                }


                                $fimy_gidertipi = $vt->listele("fimy_gidertipi", "WHERE ID={$gider['GiderTipi']}");
                                if ($fimy_gidertipi != null) foreach ($fimy_gidertipi as $gt) {
                                    $gtt = $gt['GiderAdi'];
                                }
                                if ($gider['Kasa'] == 0) {
                                    $kss = "";
                                } else {
                                    $fimy_kasa = $vt->listele("fimy_kasa", "WHERE ID={$gider['Kasa']}");
                                    if ($fimy_kasa != null) foreach ($fimy_kasa as $ks) {
                                        $kss = $ks['KasaAdi'];
                                    }
                                }

                                if ($gider['Onay'] == 1) {
                                    $buton = "<button title='Onaylayan:  " . $onaylayan . " ' class='btn btn-success'> Onaylandı </button>";
                                } else {
                                    $buton = '<button id="onaylamak" data-bs-toggle="modal" data-bs-target="#verify-goes-modal" data-animation="fadein" data-plugin="verify-goes-modal" data-overlayspeed="200" data-overlaycolor="#36404a" class="btn btn-warning onaylamak">
                                    <i id="' . $gider['ID'] . '" class="fa fa-check OnayID"></i> Onayla 
                                    </button>';
                                }



                                $OdemeDurumu = ($gider['OdemeDurumu'] == 0) ? "<b style='color:green;'>Ödendi</b>" : "<b style='color:red;'>Ödeme Bekliyor</b>";

                                echo '<tr>
                                        <td>' . $gider['ProccessDate'] . '</td>
                                        <td>' . $as . '</td>
                                        <td>' .  date("d.m.Y", strtotime($gider['GiderTarihi'])) . '</td>
                                        <td>' . $gtt . '</td>
                                        <td>' . $gider['FaturaSeriNo'] . '</td>
                                        <td>' . $gider['Aciklama'] . '</td>
                                        <td>' . number_format($gider['FaturaTutari'], 2, ',', '.') . '</td>
                                        <td>' . date("d.m.Y", strtotime($gider['OdemeTarihi'])) . '</td>
                                        <td>' . $kss . '</td>
                                        <td>' . $OdemeDurumu . '</td>
                                        <td>' . $buton . '</td>
                                        </tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div><!-- ikinci row -->


        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Modal -->
    <div class="modal fade" id="verify-goes-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Ödemeyi Onayla</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div id="modal-body-verify" class="modal-body">
                </div>
                <div class="modal-footer">
                    <button id="onaylaode" class="btn btn-success waves-effect waves-light col-lg-12">Onayla ve Öde</button>
                    <div id="son"></div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php echo "<script> var kullanici= " . $_SESSION['KID'] . ";</script>"; ?>
    <script>
        $(document).ready(function() {

            $("#onaylaode").on("click", function() {
                var GiderID = $("#GiderIDOnay").val();
                var GiderTutar = $("#GiderTutarOnay").val();
                var GiderKasa = $("#GiderKasa").val();
                if (GiderKasa == 0) {
                    toastr["warning"]("Boş alanlar mevcut lütfen kontrol ediniz..");
                } else {
                    var onaylaveode = 'GiderID=' + GiderID +
                        '&GiderTutar=' + GiderTutar +
                        '&GiderOnay=' + kullanici +
                        '&GiderKasa=' + GiderKasa;
                    $.ajax({
                        url: '../muhasebe/process/gider-onay-kaydet.fi',
                        type: 'POST',
                        data: onaylaveode,
                        success: function(e) {
                            var responses = JSON.parse(e);
                            var RefreshChechk = responses[0].refresh;
                            if (RefreshChechk == 0) {

                                toastr[responses[0].status](responses[0].message);

                            } else {

                                toastr[responses[0].status](responses[0].message);

                                setTimeout(function() {
                                    window.location.href = window.location.href;
                                }, 800);

                            }
                        }
                    });
                }

            });

            $(".onaylamak").on("click", function() {
                var GiderID = 'GiderID=' + $(this).find('i.OnayID').attr('id');
                $.ajax({
                    url: '../muhasebe/process/gider-onayla.fi',
                    type: 'POST',
                    data: GiderID,
                    success: function(e) {
                        $("div#modal-body-verify").html("").html(e);
                    }
                });
            });

            $("#giderkaydet").on("click", function() {
                var gidertarihi = $("#gidertarihi").val();
                var gidertipi = $("#gidertipi").val();
                var tutar = $("#tutar").val();
                var serino = $("#serino").val();
                var sonodeme = $("#sonodeme").val();
                var kasa = $("#kasa").val();
                var aciklama = $("#aciklama").val();
                var OdemeKontrol = $('input[name="OdemeKontrol"]:checked').attr('value');

                if (OdemeKontrol == 0) {

                    if (gidertipi == 0 || kasa == 0 || gidertarihi === '' || tutar === '' || sonodeme === '') {
                        toastr["warning"]("Boş alanlar mevcut lütfen kontrol ediniz..");
                    } else {
                        var dataset = 'gidertarihi=' + gidertarihi +
                            '&gidertipi=' + gidertipi +
                            '&tutar=' + tutar +
                            '&serino=' + serino +
                            '&sonodeme=' + sonodeme +
                            '&kasa=' + kasa +
                            '&kullanici=' + kullanici +
                            '&aciklama=' + aciklama +
                            '&OdemeKontrol=' + OdemeKontrol;
                        $.ajax({
                            url: '../muhasebe/process/giderkaydet.fi',
                            type: 'POST',
                            data: dataset,
                            success: function(e) {
                                var responses = JSON.parse(e);
                                var RefreshChechk = responses[0].refresh;
                                if (RefreshChechk == 0) {

                                    toastr[responses[0].status](responses[0].message);

                                } else {

                                    toastr[responses[0].status](responses[0].message);

                                    setTimeout(function() {
                                        window.location.href = window.location.href;
                                    }, 800);

                                }
                            }
                        });
                    }

                } else if (OdemeKontrol == 1) {
                    kasa = 0;
                    if (gidertipi == 0 || gidertarihi === '' || tutar === '' || sonodeme === '') {
                        toastr["warning"]("Boş alanlar mevcut lütfen kontrol ediniz..");
                    } else {
                        var dataset = 'gidertarihi=' + gidertarihi +
                            '&gidertipi=' + gidertipi +
                            '&tutar=' + tutar +
                            '&serino=' + serino +
                            '&sonodeme=' + sonodeme +
                            '&kasa=' + kasa +
                            '&kullanici=' + kullanici +
                            '&aciklama=' + aciklama +
                            '&OdemeKontrol=' + OdemeKontrol;
                        $.ajax({
                            url: '../muhasebe/process/giderkaydet.fi',
                            type: 'POST',
                            data: dataset,
                            success: function(e) {
                                var responses = JSON.parse(e);
                                var RefreshChechk = responses[0].refresh;
                                if (RefreshChechk == 0) {

                                    toastr[responses[0].status](responses[0].message);

                                } else {

                                    toastr[responses[0].status](responses[0].message);

                                    setTimeout(function() {
                                        window.location.href = window.location.href;
                                    }, 800);

                                }
                            }
                        });
                    }
                } else {
                    toastr["error"]("Sistem sorunu oluştu sistem yöneticinize başvurunuz..");
                }


            });


            $("#odenmedi").on("click", function() {
                var end = "";
                $("div#kasadetayi").html("").html(end);

            });
            $("#odendi").on("click", function() {
                var a = 'ID=' + 100;
                $.ajax({
                    url: '../muhasebe/process/giderkasasi.fi',
                    type: 'POST',
                    data: a,
                    success: function(e) {
                        $("div#kasadetayi").html("").html(e);
                    }
                });
            });
            // sleect2
            $("#gidertipi").select2();
            $("#kasa").select2();
            $('#tutar').mask('00000000000,00', {
                reverse: true
            });
            $('#serino').mask('AAAA-000000000000', {
        translation: {
            'A': { pattern: /[A-Za-z0-9]/ }
        }
    });
            // Şu anki tarihi al
            var currentDate = new Date();
            // 1 ay öncesini hesapla
            var oneMonthAgo = new Date();
            oneMonthAgo.setMonth(currentDate.getMonth() - 1);
            flatpickr("#gidertarihi", {
                minDate: oneMonthAgo,
                dateFormat: "Y-m-d"
            });

            flatpickr("#sonodeme", {
                minDate: "today",
                dateFormat: "Y-m-d"
            });
            $("#gider-full").DataTable({
                order: [
                    [0, 'desc']
                ],
                "lengthMenu": [15, 20, 50, 100, 200]
            });

        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style>
    .select2 {
        display: block !important;
        width: 100%;
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

    .select2-container {
        display: block !important;
        width: 100%;
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
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <h5>Kişisel Bilgiler</h5>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group has-success mg-b-0">
                                        <p class="mg-b-10" style="margin-top:2px;">T.C No</p>
                                        <input class="form-control" placeholder="TC" id="tc" required type="text">
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-6"></div>
                                <div class="col-lg-6">
                                    <div class="form-group has-success mg-b-0">
                                        <p class="mg-b-10" style="margin-top:2px;">İsim</p>
                                        <input class="form-control" placeholder="İsim" id="isim" required type="text">
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="form-group has-success mg-b-0">
                                        <p class="mg-b-10" style="margin-top:2px;">Soyisim</p>
                                        <input class="form-control" placeholder="Soyisim" id="soyisim" required type="text">
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="form-group has-success mg-b-0">
                                        <p class="mg-b-10" style="margin-top:5px;">Telefon</p>
                                        <input id="phoneMask" type="text" class="form-control" placeholder="(000)000-0000">
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="form-group has-success mg-b-0">
                                        <p class="mg-b-10" style="margin-top:5px;">Mail</p>
                                        <input id="mail" class="form-control" placeholder="@serivanturizm" required type="mail">
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="az-content-label mg-b-5">
                                        <h5>Adres Bilgileri</h5>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mg-b-0">
                                        <select id="il" class="form-control select2">
                                            <option value="il">İl..</option>
                                            <?php
                                            $ils = $vt->listele("fimy_il");
                                            if ($ils != null) foreach ($ils as $il) {
                                                echo '<option value="' . $il['ID'] . '">' . $il['il'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="form-group mg-b-0">
                                        <select id="ilce" class="form-control select2">
                                            <option value="ilce">İlçe..</option>
                                            <?php
                                            ?>
                                        </select>
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div style="text-align:left; margin:5px;" class="col-lg-12">
                                    <input class="form-check-input checkboxtc" type="checkbox" id="kurumsal" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample">
                                    <label class="form-label" for="kurumsal">Kurumsal</label>
                                </div>
                                <div class="col-lg-12 collapse collapse-horizontal" id="collapseWidthExample">


                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mg-b-0">
                                                <p class="mg-b-10" style="margin-top:2px;">Firma</p>
                                                <input id="firmadi" class="form-control" required type="text">
                                            </div><!-- form-group -->
                                        </div><!-- col-lg-6 -->
                                        <div class="col-lg-3">
                                            <div class="form-group mg-b-0">
                                                <p class="mg-b-10" style="margin-top:2px;">Vergi Dairesi</p>
                                                <select id="vergidairesi" class="form-control select2" data-toggle="select2" data-width="100%">
                                                    <option value="VergiDairesi">Vergi Dairesi..</option>
                                                    <?php
                                                    $fimy_vergidairesi = $vt->listele("fimy_vergidairesi");
                                                    if ($fimy_vergidairesi != null) foreach ($fimy_vergidairesi as $vd) {
                                                        echo '<option value="' . $vd['ID'] . '">' . $vd['VDKodu'] . ' - ' . $vd['VergiDairesi'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div><!-- form-group -->
                                        </div><!-- col-lg-3 -->
                                        <div class="col-lg-3">
                                            <div class="form-group mg-b-0">
                                                <p class="mg-b-10" style="margin-top:2px;">Vergi No</p>
                                                <input id="vergino" class="form-control" required type="text">
                                            </div><!-- form-group -->
                                        </div><!-- col-lg-3 -->

                                    </div>
                                </div>
                                <div class="col-lg-12">
                                        <div class="form-group has-success mg-b-0">
                                            <p class="mg-b-10" style="margin-top:5px;">Adres</p>
                                            <textarea id="adres" rows="3" class="form-control" placeholder="Adres"></textarea>
                                        </div><!-- form-group -->
                                    </div><!-- col-lg-12 -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <style>
                    .scroll-button {
                        width: 60px;
                        height: 60px;
                        background-color: #09e00d;
                        color: white;
                        font-size: 12px;
                        font-weight: bold;
                        border: none;
                        border-radius: 50%;
                        position: fixed;
                        top: 72px;
                        right: 30px;
                        cursor: pointer;
                        transition: bottom 0.3s ease;
                    }

                    .scroll-button.clicked {
                        bottom: 20px;
                        /* Düğmeyi aşağı indirmek için */
                    }

                    .scroll-button:hover {
                        background-color: #44f247;
                    }
                </style>
                <button id="AddCustomer" class="scroll-button">Oluştur</button>
            </div> <!-- container -->

        </div> <!-- content -->
        <script>
            $(document).ready(function() {
                $('#phoneMask').mask('9999999999');
                $('#tc').mask('99999999999');
                $('#vergino').mask('9999999999');
                $('#bakiye').mask('00000000000,00', {
                    reverse: true
                });
                $('#borc').mask('00000000000,00', {
                    reverse: true
                });
                $('#ust').mask('00000000000,00', {
                    reverse: true
                });
                // select2'yi etkinleştirme
                $("#vergidairesi").select2();
                $("#il").select2();
                $("#ilce").select2();
                // İl-İlçe Filtreleme
                $("#il").on("change", function() {
                    var ds = 'ilID=' + $('#il').val();
                    $.ajax({
                        url: '../muhasebe/process/ililce_filtre.fi',
                        type: 'POST',
                        data: ds,
                        success: function(e) {
                            $("select#ilce").html("").html(e);
                        }
                    });

                });

                $("#AddCustomer").on("click", function() {
                    var bakiye = 1000000;
                    var borc = 1000000;
                    var ust = 1000000;
                    var datastore = 'isim=' + $('#isim').val() +
                        '&soyisim=' + $('#soyisim').val() +
                        '&tc=' + $('#tc').val() +
                        '&phoneMask=' + $('#phoneMask').val() +
                        '&mail=' + $('#mail').val() +
                        '&il=' + $('#il').val() +
                        '&ilce=' + $('#ilce').val() +
                        '&adres=' + $('#adres').val() +
                        '&bakiye=' + bakiye +
                        '&borc=' + borc+
                        '&ust=' + ust +
                        '&kurumsal=' + document.getElementById("kurumsal").checked +
                        '&vergidairesi=' + $('#vergidairesi').val() +
                        '&firmadi=' + $('#firmadi').val() +
                        '&vergino=' + $('#vergino').val();
                    $.ajax({
                        url: '../muhasebe/process/addcustomerfunc.fi',
                        type: 'POST',
                        data: datastore,
                        success: function(e) {
                            //alert(e);
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

                });

            });
        </script>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
        <?php include("../src/footer-alt.php"); ?>
<?php include("../src/access.php");
$yetkiSinif = $_SESSION['yetki'];
if ($_GET) {
    $SiparisID = $_GET['ID'];
    $SiparisNo = $_GET['SiparisNo'];
    $kullaniciID = $_SESSION['KID'];
    $fimy_siparis_formu = $vt->listele("fimy_siparis_formu", "WHERE ID={$SiparisID} ORDER BY ID DESC");
    if ($fimy_siparis_formu != null) foreach ($fimy_siparis_formu as $mst) {
        $OnayDurumu = $mst['Onay'];
        $TeslimDurumu = $mst['TeslimDurumu'];
        // fimy_sf_urun
        $fimy_sf_urun = $vt->ozellistele("select count(UrunID) as UrunSayisi from fimy_sf_urun WHERE SiparisFormID={$SiparisID}");
        if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sf) {
            $UrunSayisi = $sf['UrunSayisi'];
        }
        $fimy_siparis_butce = $vt->listele("fimy_siparis_butce", "WHERE SiparisID={$SiparisID}");
        if ($fimy_siparis_butce != null) foreach ($fimy_siparis_butce as $btc) {
            $UrunButcesi = $btc['GenelToplam'];
        }
    }
    if ($OnayDurumu == 1) {
    } else {
        echo '
        <script>
        alert("Sipariş daha önce teslimi yapılmış veya onaylanmamış.. Yönlendiriliyorsunuz.");
        window.location.href = "../stok-yonetimi/siparis.fi";
        </script>';
        exit;
    }
?>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <?php
    if ($yetkiSinif == 0 || $yetkiSinif == 6) {
        $deposrogusu = "SELECT depo.*, udet.Adi, udet.Soyadi, udet.TelefonNo, udet.Mail
        FROM fimy_depolar depo, fimy_user_details udet
        WHERE depo.sorumlu_id = udet.User_ID ORDER BY depo.ID DESC";
    } else if ($yetkiSinif == 7) {

        $deposrogusu = "SELECT depo.*, udet.Adi, udet.Soyadi, udet.TelefonNo, udet.Mail
        FROM fimy_depolar depo, fimy_user_details udet
        WHERE depo.sorumlu_id = {$kullaniciID} AND depo.sorumlu_id = udet.User_ID ORDER BY depo.ID DESC";
    } else {
        echo '<script> alert("Bu ekrana erişim yetkiniz bulunmamaktadır.."); </script>';
        header("Location: ../stok-yonetimi/siparis.php");
        exit();
    }
    ?>
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <center>
                                    <h5> Çıkış Yapılacak Depo </h5>
                                </center>
                            </div>
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <input type="hidden" name="SiparisID" id="SiparisID" value="<?php echo $SiparisID; ?>">
                                    <select style="margin-top: -10px;" class="form-control" name="cikisdepo" id="cikisdepo">
                                        <option value="0"> Depo Seçiniz.. </option>
                                        <?php
                                        $depolar = $vt->ozellistele($deposrogusu);
                                        if ($depolar != null) foreach ($depolar as $depo) {
                                            echo '<option value="' . $depo['ID'] . '">' . $depo['depo_adi'] . '</option>';
                                        }
                                        ?>
                                    </select>

                                    <p class="text-muted"> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <center>
                                    <h5> Çıkış Yapan Kullanıcı </h5>
                                </center>
                            </div>
                            <div class="card-body">
                                <?php
                                $fimy_user_details = $vt->listele("fimy_user_details", "WHERE User_ID={$kullaniciID};");
                                if ($fimy_user_details != null) foreach ($fimy_user_details as $user) {
                                    $useradi = $user['Adi'];
                                    $usersoyadi = $user['Soyadi'];
                                    $useradisoyadi = $useradi . " " . $usersoyadi;

                                    // ;
                                    $Access_Adi = $vt->ozellistele("SELECT gr.Access_Adi, usac.User_ID FROM fimy_user_access usac, fimy_access_group gr WHERE gr.Level=usac.Access_Level and usac.User_ID={$kullaniciID};");
                                    if ($Access_Adi != null) foreach ($Access_Adi as $acc) {
                                        $AccessAdi = $acc['Access_Adi'];
                                    }
                                }
                                ?>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mb-0">
                                            <?php echo $useradisoyadi; ?>
                                        </h4>
                                        <p class="text-muted"> </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4 class="mb-0">
                                            <?php echo $AccessAdi; ?>
                                        </h4>
                                        <p class="text-muted"> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <center>
                                    <h5> Ürün Sayısı ve Tutar </h5>
                                </center>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mb-0">
                                            <?php echo $UrunSayisi; ?> Çeşit
                                        </h4>
                                        <p class="text-muted"> </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4 class="mb-0">
                                            <?php echo number_format($UrunButcesi, 2, ',', '.'); ?> $
                                        </h4>
                                        <p class="text-muted"> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $fimy_sf_urun_total = $vt->verisay("fimy_sf_urun", "WHERE SiparisFormID={$SiparisID}");
                    $fimy_sf_urun_teslim_edilen = $vt->verisay("fimy_sf_urun", "WHERE SiparisFormID={$SiparisID} and CikisDurumu=1");
                    if ($fimy_sf_urun_total == $fimy_sf_urun_teslim_edilen) {
                        if (empty($TeslimDurumu)) {
                            echo '<input type="hidden" id="siparisFormID" name="siparisFormID" value="' . $SiparisID . '">';
                            echo '<input type="hidden" id="kullanici" name="kullanici" value="' . $kullaniciID . '">';
                    ?>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4>Sipariş formundaki tüm ürünlerin depo çıkışları yapılmıştır.<a href="#" class="badge badge-soft-info">Detay</a></h4>
                                        <button id="depoCikisiniOnayla" class="btn btn-success rounded-pill waves-effect waves-light">
                                            <span class="btn-label"><i class="mdi mdi-check-all"></i></span> Depo Çıkışını Onayla
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="col-lg-12">
                            <div class="card">
                                <div id="resultSiparisDepoControl" class="card-body">

                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>


                </div>
                <!-- end row -->


            </div> <!-- container -->

        </div> <!-- content -->
        <script>
            $(document).ready(function() {

                $("#depoCikisiniOnayla").on("click", function() {
                    document.getElementById('preloader').style.display = 'flex';
                    var kontroldataset = 'siparisFormID=' + $('#siparisFormID').val() + '&kullanici=' + $('#kullanici').val();
                    $.ajax({
                        url: '../stok-yonetimi/proccess/siparis-onayla.fi',
                        type: 'POST',
                        data: kontroldataset,
                        success: function(e) {
                            document.getElementById('preloader').style.display = 'none';
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

                $("#cikisdepo").on("change", function() {
                    document.getElementById('preloader').style.display = 'flex';
                    var kontroldataset = 'cikisdepo=' + $('#cikisdepo').val() + '&SiparisID=' + $('#SiparisID').val();
                    $.ajax({
                        url: '../stok-yonetimi/proccess/siparis-depo-kontrol.fi',
                        type: 'POST',
                        data: kontroldataset,
                        success: function(e) {
                            // $("#birimfiyati").val(e).trigger('input');
                            document.getElementById('preloader').style.display = 'none';
                            $("div#resultSiparisDepoControl").html("").html(e);
                        }
                    });
                });

            });
        </script>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    <?php
    echo '<script>
    newTitle="' . $SiparisNo . ' Numaralı Sipariş | ' . $_SESSION['Firma'] . '";
    document.title = newTitle;
    document.getElementById("page-title-main").innerHTML = "' . $SiparisNo . '";
    </script>';
    include("../src/footer-alt.php");
} else {
    header("Location: ../stok-yonetimi/siparis.php");
    exit();
} ?>
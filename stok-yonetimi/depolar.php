<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div id="depo-listesi" class="col-lg-10">
                    <div class="row">
                        <?php
                        $yetkiSinif = $_SESSION['yetki'];
                        $kullaniciID = $_SESSION['KID'];
                        if ($yetkiSinif == 0 || $yetkiSinif == 6) {
                           $deposrogusu = "SELECT depo.*, udet.Adi, udet.Soyadi, udet.TelefonNo, udet.Mail
                           FROM fimy_depolar depo, fimy_user_details udet
                           WHERE depo.sorumlu_id = udet.User_ID ORDER BY depo.ID DESC";
                        } else if ($yetkiSinif == 7) {

                            $deposrogusu = "SELECT depo.*, udet.Adi, udet.Soyadi, udet.TelefonNo, udet.Mail
                           FROM fimy_depolar depo, fimy_user_details udet
                           WHERE depo.sorumlu_id = {$kullaniciID} AND depo.sorumlu_id = udet.User_ID ORDER BY depo.ID DESC";
                        }
                        $depolar = $vt->ozellistele($deposrogusu);
                        if ($depolar != null) foreach ($depolar as $depo) {

                        ?>
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="text-center card-body">
                                        <div>
                                            <img src="<?php echo $logo; ?>" width="150px;" class="mb-2" alt="profile-image">
                                            <h3> <?php echo $depo['depo_adi']; ?> </h3>
                                            <div class="text-start">
                                                <p class="text-muted font-13"><strong>Depo Sorumlusu :</strong> <span class="ms-2"><?php echo $depo['Adi'] . " " . $depo['Soyadi']; ?></span></p>
                                                <p class="text-muted font-13"><strong>Telefon :</strong><span class="ms-2"><?php echo $depo['TelefonNo']; ?></span></p>
                                                <p class="text-muted font-13"><strong>Email :</strong> <span class="ms-2"><?php echo $depo['Mail']; ?></span></p>
                                            </div>

                                            <a href="depo-detay.php?DepoID=<?php echo $depo['ID']; ?>&DepoName=<?php echo $depo['depo_adi']; ?>" class="btn btn-primary rounded-pill waves-effect waves-light col-lg-8"> <i class="fe-arrow-up-right"></i> Detay </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div id="deposayfasibutonlar" class="card">
                        <div class="card-body">
                            <button class="btn btn-block btn-success col-lg-12" data-bs-toggle="modal" data-bs-target="#depoekleme" data-animation="fadein" data-plugin="depoekleme" data-overlayspeed="200" data-overlaycolor="#36404a">
                                Yeni Depo Oluştur
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->


        </div> <!-- container -->

    </div> <!-- content -->

    <div class="modal fade" id="depoekleme" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Depo Ekle</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label" for="depoadi">Depo Adı <b>(*)</b></label>
                        <input type="text" class="form-control" id="depoadi" placeholder="">
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="deposorumlusu">Depo Sorumlusu <b>(*)</b></label>
                                <select id="deposorumlusu" class="form-select">
                                    <option value="0"></option>
                                    <?php
                                    $fimy_menus = $vt->ozellistele("select fu.ID, fu.kullaniciadi from fimy_user fu, fimy_user_access fua where fu.ID=fua.User_ID and fua.Access_Level != 0");
                                    if ($fimy_menus != null) foreach ($fimy_menus as $menu) {
                                        echo '<option value="' . $menu['ID'] . '">' . $menu['kullaniciadi'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button id="depo-olustur" class="btn btn-success waves-effect waves-light col-lg-12">Oluştur</button>
                    <div id="sonucdepoekle"></div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script>
        $(document).ready(function() {

            var depoListesiDiv = document.getElementById("depo-listesi");
            var depoListesiYukseklik = depoListesiDiv.clientHeight;
            var deposayfasiButonlarDiv = document.getElementById("deposayfasibutonlar");
            deposayfasiButonlarDiv.style.height = depoListesiYukseklik + "px";

            $("#depo-olustur").on("click", function() {
                var depoinfo = 'depoadi=' + $("#depoadi").val() + '&deposorumlusu=' + $("#deposorumlusu").val();
                $.ajax({
                    url: '../stok-yonetimi/proccess/depoekle-process.fi',
                    type: 'POST',
                    data: depoinfo,
                    success: function(e) {
                        $("div#sonucdepoekle").html("").html(e);
                    }
                });
            });
        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
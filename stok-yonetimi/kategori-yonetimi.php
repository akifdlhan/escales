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
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="mb-0"> <input class="form-control" type="text" name="kategoriadi" id="kategoriadi"> </h4>
                                    <p class="text-muted">Kategori Adı</p>
                                </div>
                                <div class="col-lg-6">
                                    <h4 class="mb-0"> <button id="kategoriEkle" class="btn btn-block btn-success col-lg-12"> Kategori Ekle </button> </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="urunstoklistesi" class="table table-bordered dt-responsive table-responsive">
                                <thead>
                                    <tr>
                                        <th> </th>
                                        <th> Kategori </th>
                                        <th> Eklenme Tarihi </th>
                                        <th> ### </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fimy_kategoriler = $vt->listele("fimy_kategoriler", "ORDER BY ID DESC");
                                    if ($fimy_kategoriler != null) foreach ($fimy_kategoriler as $kat) {
                                        if ($kat['ID'] == 1) {
                                            $sil = '';
                                            $duzenle = '';
                                        } else {
                                            $sil = '<a href="../stok-yonetimi/proccess/kategori-add-proccess.php?ID=' . $kat["ID"] . '"> Sil </a>';
                                            $duzenle = '<a href="?ID=' . $kat['ID'] . '"> Düzenle </a>';
                                        }
                                    ?>
                                        <tr>
                                            <td> <?php echo $kat['ID']; ?> </td>
                                            <td> <?php echo $kat['KategoriAdi']; ?> </td>
                                            <td> <?php echo $kat['ProccessDate']; ?> </td>
                                            <td> <?php echo $sil; ?> | <?php echo $duzenle; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
    <?php
    if ($_GET) {
        if ($_GET['ID']) {
            $ID =  $_GET['ID'];
            $fimy_kategoriler = $vt->listele("fimy_kategoriler", "WHERE ID={$ID}");
            if ($fimy_kategoriler != null) foreach ($fimy_kategoriler as $kat) {
                $kategoriAdi = $kat['KategoriAdi'];
            }
            echo '<input id="kategoriID" type="hidden" value="' . $ID . '">';
            echo "<script>
            $(document).ready(function() {
                $('#kategoriEkle').attr('id', 'kategoriDuzenle');
                $('#kategoriDuzenle').text('Kategori Düzenle');
                $('#kategoriadi').val('" . $kategoriAdi . "');
            });
            </script>";
        }
    }
    ?>
    <script>
        $(document).ready(function() {
            $("#kategoriDuzenle").on("click", function() {

                var kategoriInfo = 'ID=' + $('#kategoriID').val() +
                    '&kategoriadi=' + $('#kategoriadi').val() + '&Guncelleme=1';
                $.ajax({
                    url: '../stok-yonetimi/proccess/kategori-add-proccess.fi',
                    type: 'POST',
                    data: kategoriInfo,
                    success: function(e) {
                        var responses = JSON.parse(e);
                        var RefreshChechk = responses[0].refresh;
                        if (RefreshChechk == 0) {

                            toastr[responses[0].status](responses[0].message);

                        } else {

                            toastr[responses[0].status](responses[0].message);

                            setTimeout(function() {
                                var currentUrl = window.location.href;
                                if (currentUrl.indexOf('?') !== -1) {
                                    var baseUrl = currentUrl.split('?')[0];
                                    window.location.href = baseUrl;
                                } else {
                                    window.location.href = currentUrl;
                                }
                            }, 800);

                        }
                    }
                });

            });
            $("#kategoriEkle").on("click", function() {

                var kategoriadi =
                    '&kategoriadi=' + $('#kategoriadi').val() + '&Guncelleme=0';

                $.ajax({
                    url: '../stok-yonetimi/proccess/kategori-add-proccess.fi',
                    type: 'POST',
                    data: kategoriadi,
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

            });

        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
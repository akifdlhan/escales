<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-9">
                    <div id="urun-listesi" class="card">
                        <div class="card-body">
                            <div style="margin:2px;" id="dugmeler"></div>
                            <div class="table-responsive">
                                <table id="urunstoklistesi" class="table table-bordered dt-responsive">
                                    <thead>
                                        <tr>
                                            <th> </th>
                                            <th> </th>
                                            <th> Barkod </th>
                                            <th> Stok Kodu </th>
                                            <th> Ürün Adı </th>
                                            <th> Stok Miktarı </th>
                                            <th> Kategori </th>
                                            <th> Satış Fiyatı </th>
                                            <th> Eklenme Tarihi </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div id="urunsayfasibutonlar" style="height:250px;" class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="../stok-yonetimi/urun-ekle.php" class="btn btn-block btn-blue col-lg-12"> <i class="ti-target"></i> Ürün Ekle </a>
                                </div>
                                <div class="col-lg-12">
                                    <a style="margin-top: 5px; margin-bottom: 5px;" href="./marka-ekleme.php" class="btn btn-success col-lg-12"> <i class="ti-shopping-cart"></i> Marka Ekleme </a>
                                </div>
                                <div class="col-lg-12">
                                    <a style="margin-bottom: 5px;" href="./model-ekleme.php" class="btn btn-success col-lg-12"> <i class="ti-shopping-cart-full"></i> Model Ekleme </a>
                                </div>
                                <div class="col-lg-12">
                                    <a style="margin-bottom: 5px;" href="./kategori-yonetimi.php" class="btn btn-blue col-lg-12"> <i class="ti-menu"></i> Kategori Yönetimi </a>
                                </div>
                                <div class="col-lg-12">
                                    <?php
                                    $timestamp = md5(time());
                                    ?>
                                    <a target="_blank" href="../stok-yonetimi/proccess/tumurunbarkod.fi?Escales=<?php echo $timestamp; ?>" class="btn btn-block btn-secondary col-lg-12"> <i class="ti-envelope"></i> Toplu Barkod Bas </a>
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
            var table = $('#urunstoklistesi').DataTable({
                // "lengthMenu": [50, 100, 150, 250, 300],
                lengthMenu: [[50, 100, 250], [50, 100, 250]],
                order: [
                    [0, 'desc']
                ],
                dom: '<"top"lf<"wrapper"B>>rtip',
                buttons: ["copy", "excel", "pdf"],
                ajax: {
                    url: '../stok-yonetimi/UrunCekmeServisi.fi',
                    type: 'GET',
                    data: function(d) {
                        d.start = d.start || 0;
                        d.length = d.length || 10;
                        d.draw = d.draw || 1;
                        return d;
                    }
                },
                columns: [{
                        data: 'ID'
                    },
                    {
                        data: 'link',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'barkod'
                    },
                    {
                        data: 'StokKodu'
                    },
                    {
                        data: 'urun_adi'
                    },
                    {
                        data: 'stok_miktari'
                    },
                    {
                        data: 'KategoriAdi'
                    },
                    {
                        data: 'SatisFiyati'
                    },
                    {
                        data: 'proccess_date'
                    }
                ],
                serverSide: true,
                paging: true,
                searching: true
            });
            $('#dugmeler').append($('.dt-buttons'));



        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
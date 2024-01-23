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
                            <table id="urunstoklistesi" class="table table-bordered dt-responsive table-responsive">
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
                                    <?php
                                    $ParaBirimi = 2;
                                    $fimy_urunler = $vt->listele("fimy_urunler", "ORDER BY ID DESC");
                                    if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
                                        $fimy_urun_stok_depo = $vt->ozellistele("SELECT SUM(stok_miktari) as stok_miktari FROM fimy_urun_stok_depo WHERE UrunID={$urun['ID']};");
                                        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                                            $stok_miktari = $usd['stok_miktari'];
                                        }
                                        $fimy_urun_fiyat = $vt->listele("fimy_urun_fiyat", "WHERE UrunID={$urun['ID']};");
                                        if ($fimy_urun_fiyat != null) foreach ($fimy_urun_fiyat as $uf) {
                                            $SatisFiyati = $uf['SatisFiyati'];
                                            $ParaBirimi = $uf['ParaBirimi'];
                                        }

                                        $fimy_kategoriler = $vt->listele("fimy_kategoriler", "WHERE ID={$urun['KategoriID']};");
                                        if ($fimy_kategoriler != null) foreach ($fimy_kategoriler as $kat) {
                                            $KategoriAdi = $kat['KategoriAdi'];
                                        }
                                        $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE ID={$ParaBirimi}");
                                        if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $pb) {
                                            $ParaBirimi = $pb['ParaBirimi'];
                                            $ParaSimgesi = $pb['Aciklama'];
                                        }
                                        echo '  <tr>
                                                <td class="text-center" >
                                                <a href="urun-karti.php?UrunID=' . $urun['ID'] . '">
                                                <i style="font-size:16px; color:darkblue;" class="ti-layout-tab" ></i> 
                                                </a>
                                                </td>
                                                <td>' . $urun['ID'] . '</td>
                                                <td>' . $urun['barkod'] . '</td>
                                                <td>' . $urun['StokKodu'] . '</td>
                                                <td>' . $urun['urun_adi'] . '</td>
                                                <td>' . $stok_miktari . '</td>
                                                <td>' . $KategoriAdi . '</td>
                                                <td>' . number_format($SatisFiyati, 2, ',', '.') . ' ' . $ParaSimgesi . '</td>
                                                <td>' . $urun['proccess_date'] . '</td>
                                                </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div id="urunsayfasibutonlar" class="card">
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
            var urunlistesidiv = document.getElementById("urun-listesi");
            var urunlerYukseklik = urunlistesidiv.clientHeight;
            var urunsayfasibutonlarDiv = document.getElementById("urunsayfasibutonlar");
            urunsayfasibutonlarDiv.style.height = urunlerYukseklik + "px";

            var urunstoklistesi = $("#urunstoklistesi").DataTable({
                buttons: ["copy", "excel", "pdf"],
                "lengthMenu": [50, 100, 150, 250, 300]
            });
            urunstoklistesi.buttons().container().appendTo("#dugmeler");
        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
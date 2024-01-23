<?php include("../src/access.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');
if ($_GET) {
    //include('../src/vendor/autoload.php');
    require_once('../src/vendor/autoload.php');
    //require_once '../src/vendor/picqer/php-barcode-generator/src/BarcodeGeneratorPNG.php';

    if ($_GET['UrunID']) {
        $UrunID = $_GET['UrunID'];
        $fimy_urunler = $vt->listele("fimy_urunler", "WHERE ID={$UrunID} ORDER BY ID DESC");
        if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
            $fimy_urun_stok_depo = $vt->ozellistele("SELECT SUM(stok_miktari) as stok_miktari FROM fimy_urun_stok_depo WHERE UrunID={$urun['ID']};");
            if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                $stok_miktari = $usd['stok_miktari'];
            }
            $fimy_urun_fiyat = $vt->listele("fimy_urun_fiyat", "WHERE UrunID={$urun['ID']};");
            if ($fimy_urun_fiyat != null) foreach ($fimy_urun_fiyat as $uf) {
                $BirimFiyati = $uf['BirimFiyati'];
                $SatisFiyati = $uf['SatisFiyati'];
                $ParaBirimi = $uf['ParaBirimi'];
            }
        }
?>
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <script>
            $(document).ready(function() {
                equalizeHeight();
                $(window).resize(function() {
                    equalizeHeight();
                });
            });

            function equalizeHeight() {
                var maxHeight = 0;
                $('#equal-height-row .card').each(function() {
                    var colheader = $(this).find('.card-header').outerHeight();
                    var colbody = $(this).find('.card-body').outerHeight();
                    colHeight = colheader + colbody + 20;
                    maxHeight = Math.max(maxHeight, colHeight);
                });
                $('#equal-height-row .card').css('height', maxHeight + 'px');
                //console.log(maxHeight);
            }
        </script>
        <style>
            .urungorseli {
                border: 2px solid #ccc;
                box-shadow: 2px 2px 5px #888;
                height: 70%;
                max-height: 200px;
            }

            @media only screen and (max-width: 600px) {
                .urungorseli {
                    height: 350%;
                    max-height: 200px;
                }
            }
        </style>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <input type="hidden" id="UserGondermelik" value="<?php echo $_SESSION['KID']; ?>">
                    <div id="equal-height-row" class="row d-flex align-items-stretch">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <a href="../stok-yonetimi/yeni-siparis.php" class="btn btn-block btn-blue col-lg-12"> Sipariş Oluştur </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <a data-bs-toggle="modal" data-bs-target="#stokekle" class="btn btn-block btn-warning col-lg-12"> Stok Ekle </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <a href="../stok-yonetimi/urun-duzenle.php?UrunID=<?php echo $urun['ID']; ?>" class="btn btn-block btn-info col-lg-12"> Düzenle </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <a target="_blank" href="../stok-yonetimi/proccess/barkodbas.fi?ID=<?php echo $urun['ID']; ?>&Adi=<?php echo $urun['urun_adi']; ?>&Barkod=<?php echo $urun['barkod']; ?>" class="btn btn-block btn-secondary col-lg-12"> Barkod Bas </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $yetkili = $_SESSION['yetki'];
                                    if ($yetkili == 0 || $yetkili == 6) {
                                    ?>
                                        <div class="col-lg-12">
                                            <a href="../stok-yonetimi/proccess/urun-sil-proccess.fi?ID=<?php echo $urun['ID']; ?>&Adi=<?php echo $urun['urun_adi']; ?>&UserID=<?php echo $_SESSION['KID']; ?>" class="btn btn-block btn-danger col-lg-12"> Ürünü Sil </a>
                                        </div>
                                    <?php
                                    } else {
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card urunicerigi">
                                <div class="card-header">
                                    <center>
                                        <h4> <?php echo $urun['urun_adi']; ?> </h4>
                                    </center>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <?php 
                                        $urunGorseli = $urun['urun_gorseli'];
                                        if ($urunGorseli == null) {
                                            $fimy_appoptions = $vt->listele("fimy_appoptions", "WHERE ID=1;");
                                            if ($fimy_appoptions != null) foreach ($fimy_appoptions as $app) {
                                                $urunGorseli = $app['Logo'];
                                            }
                                        } else {
                                            $urunGorseli;
                                        }
                                        ?>
                                        <div class="col-lg-12">
                                            <img style="max-width: 100%; height: auto; object-fit: contain; max-height: 100%;" src="<?php echo $urunGorseli; ?>" alt="<?php echo $urun['urun_adi']; ?>" class="urungorseli">
                                        </div>
                                        <div class="col-lg-12">
                                            <center>
                                                <h4 class="mb-0">
                                                    <?php $barkod = $urun['barkod'];
                                                    if ($barkod != "") {
                                                        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                                        echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barkod, $generator::TYPE_CODE_128)) . '">';
                                                    }
                                                    ?>
                                            </center>
                                            </h4>
                                            <p class="text-muted"><?php echo $barkod;  ?></p>
                                        </div>
                                        <?php
                                        if ($urun['marka'] == 0 || $urun['model'] == 0) {
                                            $marka = "";
                                            $model = "";
                                        } else {
                                            $markamodel = $vt->ozellistele("SELECT marka.marka, model.model FROM fimy_model model, fimy_marka marka where marka.marka_id=model.marka_id and marka.marka_id={$urun['marka']} and model.model_id={$urun['model']}");
                                            if ($markamodel != null) foreach ($markamodel as $mm) {
                                                $marka = $mm['marka'];
                                                $model = $mm['model'];
                                            }
                                        }

                                        ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card urunicerigi">
                                <div class="card-header">
                                    <center>
                                        <h4> Özellikler </h4>
                                    </center>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-lg-6">
                                            <h4 class="mb-0"><?php echo $marka; ?></h4>
                                            <p class="text-muted">Marka</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4 class="mb-0"><?php echo $model; ?></h4>
                                            <p class="text-muted">Model</p>
                                        </div>
                                        <div class="col-lg-12">
                                            <h4 class="mb-0"><?php
                                                                $fimy_kategoriler = $vt->listele("fimy_kategoriler", "WHERE ID={$urun['KategoriID']};");
                                                                if ($fimy_kategoriler != null) foreach ($fimy_kategoriler as $k) {
                                                                    $kategoriler = $k['KategoriAdi'];
                                                                }
                                                                echo $kategoriler; ?></h4>
                                            <p class="text-muted">Kategori</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4 class="mb-0"><?php echo $urun['StokKodu']; ?></h4>
                                            <p class="text-muted">Stok Kodu</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <?php
                                            $fimy_olcubirimi = $vt->listele("fimy_olcubirimi", "WHERE ID={$urun['OlcuBirimi']};");
                                            if ($fimy_olcubirimi != null) foreach ($fimy_olcubirimi as $ob) {
                                                $OlcuBirimi = $ob['OlcuBirimi'];
                                            }
                                            ?>
                                            <h4 class="mb-0"><?php echo $stok_miktari . " " . $OlcuBirimi; ?></h4>
                                            <p class="text-muted">Stok Miktarı</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4 class="mb-0">
                                                <?php
                                                $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE ID={$ParaBirimi};");
                                                if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $pb) {
                                                    $ParaBirimi = $pb['ParaBirimi'];
                                                    $ParaSimgesi = $pb['Aciklama'];
                                                }

                                                echo $ParaBirimi . " (" . $ParaSimgesi . ")";
                                                ?>
                                            </h4>
                                            <p class="text-muted">Para Birimi</p>
                                        </div>
                                        <?php
                                        $yetkili = $_SESSION['yetki'];
                                        $satis_col = 6;
                                        if ($yetkili == 0 || $yetkili == 6) {
                                            $satis_col = 12;
                                        ?>
                                            <div class="col-lg-6">
                                                <h4 class="mb-0"><?php echo number_format($BirimFiyati, 2, ',', '.'); ?> $ </h4>
                                                <p class="text-muted">Birim Fiyatı</p>
                                            </div>
                                        <?php
                                        } else {
                                            $satis_col = 6;
                                        }
                                        ?>
                                        <div class="col-lg-<?php echo $satis_col; ?>">
                                            <h4 class="mb-0"><?php echo number_format($SatisFiyati, 2, ',', '.'); ?> $ </h4>
                                            <p class="text-muted">Satış Fiyatı</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card urunicerigi">
                                <div class="card-header">
                                    <center>
                                        <h4> Depolar </h4>
                                    </center>
                                </div>
                                <div class="card-body">

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th> </th>
                                                <th> Depo </th>
                                                <th> Stok Miktarı </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $fimy_urun_stok_depo = $vt->ozellistele("SELECT usd.*, depo.depo_adi FROM fimy_urun_stok_depo usd, fimy_depolar depo WHERE usd.bulundugu_depo=depo.ID and UrunID={$UrunID};");
                                            if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                                                $bulundugu_depo = $usd['depo_adi'];
                                                $stok_miktari = $usd['stok_miktari'];
                                                $yetkili = $_SESSION['yetki'];
                                                if ($yetkili == 0 || $yetkili == 6) {
                                                    $depoStokDuzenle = " <button class='btn btn-primary modal-trigger' data-toggle='modal' data-target='#myModal' data-bs-toggle='modal' data-bs-target='#myModal' data-id='{$usd['ID']}'>Düzenle</button>";
                                                } else {
                                                    $depoStokDuzenle = "";
                                                }

                                                echo "<tr>
                                                        <td>{$usd['ID']}</td>
                                                        <td>{$bulundugu_depo}</td>
                                                        <td>{$stok_miktari}</td>
                                                        <td>
                                                           " . $depoStokDuzenle . "
                                                        </td>
                                                    </tr>";
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

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
            <!-- Bootstrap Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Stok Düzenle</h5>
                        </div>
                        <div id="modalStokDuzenle" class="modal-body">
                            <input type="hidden" id="modalInput">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Stok Ekle - Modal -->
            <div class="modal fade" id="stokekle" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myCenterModalLabel">Stok Ekle</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="hidden" name="UrunID" id="UrunID" value="<?php echo $urun['ID']; ?>">
                                        <label class="form-label" for="depolar">Depo <b>(*)</b></label>
                                        <select id="depolar" class="form-select">
                                            <option value="0">Depo Seçiniz..</option>
                                            <?php
                                            $fimy_depolar = $vt->listele("fimy_depolar");
                                            if ($fimy_depolar != null) foreach ($fimy_depolar as $depo) {
                                                echo '<option value="' . $depo['ID'] . '">' . $depo['depo_adi'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="adet">Adet <b>(*)</b></label>
                                        <input type="text" class="form-control" id="adet" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <button id="stokeklesubmit" class="btn btn-success waves-effect waves-light me-1 col-lg-12">Stok Ekle</button>
                            <div id="son"></div>

                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <script>
                $(document).ready(function() {
                    $(document).on('click', '.modal-trigger', function() {
                        var productId = $(this).data('id');
                        $('#modalInput').val(productId);
                        var stokinfo = 'UrunStokDepo=' + productId + '&UserID=' + $("#UserGondermelik").val();
                        $.ajax({
                            url: '../stok-yonetimi/proccess/stok-duzenle-proccess.fi',
                            type: 'POST',
                            data: stokinfo,
                            success: function(e) {
                                $("div#modalStokDuzenle").html("").html(e);
                            }
                        });
                    });
                    $("#stokeklesubmit").on("click", function() {
                        if ($("#depolar").val() <= 0 || $("#adet").val() <= 0) {
                            toastr["warning"]("Depo seçimi ve Stok Adetini Kontrol Ediniz..");
                        } else {
                            var stokinfo = 'depolar=' + $("#depolar").val() + '&adet=' + $("#adet").val() + '&UrunID=' + $("#UrunID").val();
                            $.ajax({
                                url: '../stok-yonetimi/proccess/stok-ekle-process.fi',
                                type: 'POST',
                                data: stokinfo,
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
                });
            </script>
    <?php
    }
} else {
    echo '<script>
    toastr["error"]("Ürün kartı çekilemedi..!");
    setTimeout(function() {
        window.location.href = "./";
    }, 800);
    </script>';
}
include("../src/footer-alt.php"); ?>
<?php
include("../src/access.php");
if ($_GET) {
    $SiparisID = $_GET['ID'];
    $fimy_siparis_formu = $vt->listele("fimy_siparis_formu", "WHERE ID={$SiparisID} ORDER BY ID DESC");
    if ($fimy_siparis_formu != null) foreach ($fimy_siparis_formu as $mst) {
        $SiparisNo = $mst['SiparisNo'];
        $onaybutonu = "";
        $teslimbuton = '';
        $yetkiSinif = $_SESSION['yetki'];
        if ($yetkiSinif == 0 || $yetkiSinif == 6) {
            if ($mst['Onay'] == 0) {
                $teslimbuton = '<a class="btn btn-success waves-effect waves-light" href="../stok-yonetimi/siparis-onayla.php?Siparis=' . $mst['SiparisNo'] . '&ID=' . $mst['ID'] . '&Onay=0&User=' . $_SESSION['KID'] . '">Onayla</a>';
            } else if ($mst['Onay'] == 1) {
                $teslimbuton = '<a href="../stok-yonetimi/siparis-teslim-et.php?SiparisNo=' . $mst['SiparisNo'] . '&ID=' . $SiparisID . '&User=' . $_SESSION['KID'] . '" class="btn btn-success waves-effect waves-light">Sipariş Teslim Et</a>';
            } else if ($mst['Onay'] == 2) {
                $teslimbuton = '';
            }
        }
        if ($mst['Onay'] == 0) {
            $onaybutonu = 'Onaylanmadı';
        } else if ($mst['Onay'] == 1) {
            $onaybutonu = 'Onaylandı';
            $teslimbuton = '<a href="../stok-yonetimi/siparis-teslim-et.php?SiparisNo=' . $mst['SiparisNo'] . '&ID=' . $SiparisID . '" class="btn btn-success waves-effect waves-light">Sipariş Teslim Et</a>';
        } else if ($mst['Onay'] == 2) {
            $onaybutonu = 'Teslim Edildi';
        }

        $fimy_cari_hesap = $vt->listele("fimy_cari_hesap", "WHERE ID={$mst['MusteriID']};");
        if ($fimy_cari_hesap != null) foreach ($fimy_cari_hesap as $cari) {
            $musteriBilgi = $cari['Adi'] . " " . $cari['Soyadi'];
            $musteriTelefon = $cari['Tel'];
            $musteriAdres = $cari['Adres'];
            $Kurumsal = $cari['Kurumsal'];
            $cariFirmaAdi = "";
            $fimy_siparis_butce = $vt->listele("fimy_siparis_butce", "WHERE SiparisID={$mst['ID']};");
            if ($fimy_siparis_butce != null) foreach ($fimy_siparis_butce as $sbtc) {
                $siparisGenelToplam = $sbtc['GenelToplam'];
            }
            if ($Kurumsal == 1) {
                $fimy_cari_kurumsal = $vt->listele("fimy_cari_kurumsal", "WHERE CariID={$mst['ID']};");
                if ($fimy_cari_kurumsal != null) foreach ($fimy_cari_kurumsal as $carikur) {
                    $cariFirmaAdi = $carikur['FirmaAdi'];
                }
            }
        }
        $fimy_user_details = $vt->listele("fimy_user_details", "WHERE User_ID={$mst['SiparisAlan']};");
        if ($fimy_user_details != null) foreach ($fimy_user_details as $user) {
            $useradi = $user['Adi'];
            $usersoyadi = $user['Soyadi'];
            $useradisoyadi = $useradi . " " . $usersoyadi;
        }
    }
    else {
        header("Location: ../stok-yonetimi/siparis.php");
        exit();
    }
?>
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printableArea,
            #printableArea * {
                visibility: visible;
            }

            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div id="printableArea" class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="panel-body">
                                    <div class="clearfix">
                                        <div class="float-start">
                                            <h3>
                                                <span class="logo-lg">
                                                    <img src="<?php echo $logo; ?>" alt="" height="97">
                                                </span>
                                            </h3>
                                        </div>
                                        <div class="float-end">
                                            <h4>Sipariş No # <br>
                                                <strong><?php echo $SiparisNo; ?></strong>
                                            </h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="float-start mt-3">
                                                <address>
                                                    <strong><?php echo $cariFirmaAdi; ?></strong><br>
                                                    <?php echo $musteriBilgi; ?><br>
                                                    <?php echo $musteriAdres; ?><br>
                                                    <?php echo $musteriTelefon; ?>
                                                </address>
                                            </div>
                                            <div class="float-end mt-3">
                                                <p><strong>Sipariş Tarihi: </strong> <?php echo $mst['OlusturmaTarihi']; ?></p>
                                                <p><strong>Onay Durumu: </strong> <span class="label label-pink"><?php echo $onaybutonu; ?></span></p>
                                                <p><strong>Sipariş ID: </strong> #0000<?php echo $mst['ID']; ?></p>
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th class="text-center">Görsel</th>
                                                            <th>Ürün</th>
                                                            <th>Adet</th>
                                                            <th>Birim Fiyat</th>
                                                            <th class="text-end">Ara Toplam</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $IDSay = 1;
                                                        $fimy_sf_urun = $vt->listele("fimy_sf_urun", "WHERE SiparisFormID={$mst['ID']};");
                                                        if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sf) {
                                                            $SipForID = $sf['ID'];
                                                            $fimy_urunler = $vt->listele("fimy_urunler", "WHERE ID={$sf['UrunID']};");
                                                            if ($fimy_urunler != null) foreach ($fimy_urunler as $uf) {
                                                                $urunGorseli = $uf['urun_gorseli'];
                                                                $urunAdi = $uf['urun_adi'];
                                                                $urunStokKodu = $uf['StokKodu'];
                                                                $barkod = $uf['barkod'];
                                                                $ParaBirimim = 2;
                                                                $fimy_urun_fiyat = $vt->listele("fimy_urun_fiyat", "WHERE UrunID={$sf['UrunID']};");
                                                                if ($fimy_urun_fiyat != null) foreach ($fimy_urun_fiyat as $app) {
                                                                    $ParaBirimim = $app['ParaBirimi'];
                                                                    $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE ID={$ParaBirimim};");
                                                                    if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $pb) {
                                                                        $ParaBirimiSimgesi = $pb['Aciklama'];
                                                                    }
                                                                }

                                                                if ($urunGorseli == null) {
                                                                    $fimy_appoptions = $vt->listele("fimy_appoptions", "WHERE ID=1;");
                                                                    if ($fimy_appoptions != null) foreach ($fimy_appoptions as $app) {
                                                                        $urunGorseli = $app['Logo'];
                                                                    }
                                                                } else {
                                                                    $urunGorseli;
                                                                }
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $IDSay; ?></td>
                                                                <td class="text-center">
                                                                    <img src="<?php echo $urunGorseli; ?>" width="50px">
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    if ($mst['Onay'] == 0) {
                                                                    ?>
                                                                        <a href="#" class="open-modal" data-sipforid="<?php echo $SipForID; ?>" data-bs-toggle="modal" data-bs-target="#SiparisForModal">
                                                                            <?php echo $barkod . " | " . $urunStokKodu . " | " . $urunAdi; ?>
                                                                        </a>
                                                                    <?php
                                                                    } else if ($mst['Onay'] == 1) {
                                                                        echo $barkod . " | " . $urunStokKodu . " | " . $urunAdi;
                                                                    } else if ($mst['Onay'] == 2) {
                                                                        echo $barkod . " | " . $urunStokKodu . " | " . $urunAdi;
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $sf['Adet']; ?></td>
                                                                <td><?php echo number_format($sf['BirimFiyati'], 2, ',', '') . " " . $ParaBirimiSimgesi; ?></td>
                                                                <td class="text-end"><?php echo number_format($sf['AraToplam'], 2, ',', '') . " " . $ParaBirimiSimgesi; ?></td>
                                                            </tr>
                                                        <?php
                                                            $IDSay++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-6">
                                            <div class="clearfix mt-4">
                                                <h5 class="small text-dark fw-normal">SİPARİŞ NOTU</h5>

                                                <small>
                                                    <?php echo $mst['SiparisNot']; ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-6 offset-xl-3">
                                            <p class="text-end"><b>Ara Toplam:</b> <?php echo number_format($siparisGenelToplam, 2, ',', '.') . " " . $ParaBirimiSimgesi; ?> </p>
                                            <p class="text-end"><b>KDV (%20):</b> <?php $yuzdeYirmi = ($siparisGenelToplam * 20) / 100;
                                                                                    echo number_format($yuzdeYirmi, 2, ',', '.') . " " . $ParaBirimiSimgesi; ?> </p>
                                            <hr>
                                            <h3 class="text-end"><?php echo number_format(($siparisGenelToplam + $yuzdeYirmi), 2, ',', '.') . " " . $ParaBirimiSimgesi; ?> </h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-print-none">
                                        <div class="float-end">
                                            <!-- <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light"><i class="fa fa-print"></i></a> -->
                                            <button onclick="printDiv()" class="btn btn-dark waves-effect waves-light"><i class="fa fa-print"></i></button>
                                            <?php echo $teslimbuton; ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
        <!-- Sipariş Formu İçerisindeki Ürün Düzelt Modal -->
        <div class="modal fade" id="SiparisForModal" tabindex="-1" aria-labelledby="SiparisForModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body text-center" id="SiparisForModalBody">

                    </div>
                    <div class="modal-footer">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <button type="button" class="btn btn-danger col-lg-12" id="SiparistenSil">SİL</button>
                                </div>
                                <div class="col-lg-4">
                                    <button type="button" class="btn btn-warning col-lg-12" id="tekrarhesapla">Tekrar Hesapla</button>
                                </div>
                                <div class="col-lg-4">
                                    <button type="button" class="btn btn-success col-lg-12" id="formdan-urun-guncelle">Güncelle</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {

                $('.open-modal').on('click', function(e) {
                    e.preventDefault();

                    var sipForID = $(this).data('sipforid');

                    $.ajax({
                        url: '../stok-yonetimi/proccess/urun-stok-form-edit.fi',
                        type: 'POST',
                        data: {
                            SipForID: sipForID
                        },
                        success: function(response) {
                            // Modal içeriğini güncelle
                            $('#SiparisForModalBody').html(response);
                        }
                    });
                });
                $('#formdan-urun-guncelle').on('click', function(e) {
                    var sipForID = $('#sipforid').val();
                    birimfiyati = $('#birimfiyati').val();
                    urunadet = $('#urunadet').val();
                    araToplam = $('#araToplam').val();
                    urun = $('#urun').val();
                    $.ajax({
                        url: '../stok-yonetimi/proccess/formdan-urun-guncelle.fi',
                        type: 'POST',
                        data: {
                            SipForID: sipForID,
                            birimfiyati: birimfiyati,
                            urunadet: urunadet,
                            araToplam: araToplam,
                            islem: 1
                        },
                        success: function(response) {
                            $('#SiparisForModalBody').html(response);
                            setTimeout(function() {
                                window.location.href = window.location.href;
                            }, 800);
                        }
                    });
                });

                $('#SiparistenSil').on('click', function(e) {
                    var sipForID = $('#sipforid').val();
                    urun = $('#urun').val();

                    $.ajax({
                        url: '../stok-yonetimi/proccess/formdan-urun-guncelle.fi',
                        type: 'POST',
                        data: {
                            SipForID: sipForID,
                            islem: 0
                        },
                        success: function(response) {
                            $('#SiparisForModalBody').html(response);
                            setTimeout(function() {
                                window.location.href = window.location.href;
                            }, 800);
                        }
                    });
                });
            });
        </script>
        <script>
            function printDiv() {
                var printContents = document.getElementById("printableArea").innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    <?php
}
include("../src/footer-alt.php");
echo '<script>
    newTitle="' . $SiparisNo . ' Numaralı Sipariş | ' . $_SESSION['Firma'] . '";
    document.title = newTitle;
    document.getElementById("page-title-main").innerHTML = "' . $SiparisNo . '";
    </script>';
    ?>
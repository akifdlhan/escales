<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <center>
                                <h3> Ürün Ara </h3>
                            </center>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-6 mb-3  text-center">
                                    <input class="form-check-input" type="radio" name="UrunTuruSec" id="1" checked="">
                                    <label class="form-check-label" for="1">Barkod</label>
                                    <input class="form-check-input" type="radio" name="UrunTuruSec" id="2">
                                    <label class="form-check-label" for="2">Ürün Adı</label>
                                    <input class="form-check-input" type="radio" name="UrunTuruSec" id="3">
                                    <label class="form-check-label" for="3">Stok Kodu</label>
                                </div>
                                <div class="col-lg-6 mb-3  text-center">
                                    <input type="text" class="form-control" name="barkodNo" id="barkodNo" placeholder="Barkod No">
                                </div>
                                <div class="col-lg-6 mb-3 text-center">
                                    <input type="submit" value="ARA" class="btn btn-blue col-lg-12 ">
                                </div>
                                <div class="col-lg-6 mb-3  text-center">
                                    <input type="submit" value="TARA" class="btn btn-blue col-md-12" data-bs-toggle="modal" data-bs-target="#barcodeScannerModal">
                                </div>
                                <div class="col-lg-12">
                                    <div id="urunDetayVer" class="card-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $yetkili = $_SESSION['yetki'];
                if ($yetkili == 0 || $yetkili == 2 || $yetkili == 6) {
                ?>
                    <div class="col-xl-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mt-0 mb-4">Depo Özetleri</h4>
                                <?php
                                $fimy_urun_stok_depo = $vt->ozellistele("SELECT SUM(stok_miktari) as stok_miktari FROM fimy_urun_stok_depo");
                                if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                                    $toplam_stok_miktari = $usd['stok_miktari'];
                                }
                                $deposayisi = 0;
                                $fimy_urun_stok_depo = $vt->ozellistele("SELECT bulundugu_depo,SUM(stok_miktari) as stok_miktari FROM fimy_urun_stok_depo GROUP BY bulundugu_depo");
                                if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                                    $deposayisi++;
                                    $bulundugu_depo = $usd['bulundugu_depo'];
                                    $stok_miktari = $usd['stok_miktari'];
                                    $fimy_depolar = $vt->listele("fimy_depolar", "WHERE ID={$bulundugu_depo}");
                                    if ($fimy_depolar != null) foreach ($fimy_depolar as $depo) {
                                        $bulundugu_depo_Adi = $depo['depo_adi'];
                                    }

                                    $fimy_urun_stok_depo = $vt->ozellistele("SELECT bulundugu_depo,SUM(stok_miktari) as stok_miktari FROM fimy_urun_stok_depo WHERE bulundugu_depo = {$bulundugu_depo} GROUP BY bulundugu_depo");
                                    if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                                        $bulundugu_depo = $usd['bulundugu_depo'];
                                        $stok_miktari = $usd['stok_miktari'];
                                        // echo '<td>' . number_format($stok_miktari, 0, '', '.') . '</td>';
                                    }
                                    $maxvalue = $toplam_stok_miktari;
                                    $oran = ($stok_miktari / $maxvalue) * 100;
                                ?>
                                    <h5 class="mt-0"> <?php echo  $bulundugu_depo_Adi; ?> <span class="text-secondary float-center"><?php echo number_format($stok_miktari, 0, '', '.'); ?></span> <span class="text-primary float-end"> % <?php echo number_format($oran, 2, ',', '.'); ?></span></h5>
                                    <div class="progress progress-bar-alt-primary progress-sm mt-0 mb-3">
                                        <div class="progress-bar bg-primary progress-animated wow animated animated" role="progressbar" aria-valuenow="<?php echo $stok_miktari; ?>" aria-valuemin="0" aria-valuemax="<?php echo $toplam_stok_miktari; ?>" style="width: <?php echo $oran; ?>%; visibility: visible; animation-name: animationProgress;">
                                        </div>
                                    </div>

                                <?php }


                                echo '<h5 class="mt-0 text-end"> Tüm Depoların Toplamı..:  </h5>  
                                <h3> <span class="text-primary float-end">' . number_format($toplam_stok_miktari, 0, '', '.') . '</span></h3>';
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card card-draggable">
                            <div class="card-body">
                                <h4 class="card-title">Borçlular</h4>
                                <table class="table dt-responsive table-responsive">
                                    <thead>
                                        <th> İsim Soyisim </th>
                                        <th> Cari Tipi </th>
                                        <th> Borç Tutarı </th>
                                        <th> </th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $fimy_cari_hesap = $vt->ozellistele("SELECT fch.ID, fch.Adi, fch.Soyadi, fch.Kurumsal, fba.BorcAlacak, fba.Tutar FROM fimy_cari_hesap fch, fimy_borc_alacak fba where fba.MID=fch.ID and BorcAlacak=1 and fba.Tutar>0 limit 5;");
                                        if ($fimy_cari_hesap != null) foreach ($fimy_cari_hesap as $cari) {
                                            if ($cari['Kurumsal'] == 1) {
                                                $kurumsal = "Kurumsal";
                                            } else {
                                                $kurumsal = "Bireysel";
                                            }
                                            echo '<tr>
                                    <td>' . $cari['Adi'] . ' ' . $cari['Soyadi'] . '</td>
                                    <td>' . $kurumsal . '</td>
                                    <td>' . number_format($cari['Tutar'], 2, ',', '.') . ' ₺ </td>
                                    <td>
                                    <center>
                                    <a class="btn btn-info" href="../muhasebe/musteri-detay.fi?MusteriID=' . $cari['ID'] . '">
                                    <i class="ti-layers-alt"></i> 
                                    Detay
                                    </a>
                                    </center>
                                    </td>
                                    </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="card card-draggable">
                            <div class="card-body">
                                <h4 class="card-title">Alacaklılar</h4>
                                <table class="table dt-responsive table-responsive">
                                    <thead>
                                        <th> İsim Soyisim </th>
                                        <th> Cari Tipi </th>
                                        <th> Borç Tutarı </th>
                                        <th> </th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $fimy_cari_hesap = $vt->ozellistele("SELECT fch.ID, fch.Adi, fch.Soyadi, fch.Kurumsal, fba.BorcAlacak, fba.Tutar FROM fimy_cari_hesap fch, fimy_borc_alacak fba where fba.MID=fch.ID and BorcAlacak=2 and fba.Tutar>0 limit 5;");
                                        if ($fimy_cari_hesap != null) foreach ($fimy_cari_hesap as $cari) {
                                            if ($cari['Kurumsal'] == 1) {
                                                $kurumsal = "Kurumsal";
                                            } else {
                                                $kurumsal = "Bireysel";
                                            }
                                            echo '<tr>
                                    <td>' . $cari['Adi'] . ' ' . $cari['Soyadi'] . '</td>
                                    <td>' . $kurumsal . '</td>
                                    <td>' . number_format($cari['Tutar'], 2, ',', '.') . ' ₺ </td>
                                    <td>
                                    <center>
                                    <a class="btn btn-info" href="../muhasebe/musteri-detay.fi?MusteriID=' . $cari['ID'] . '">
                                    <i class="ti-layers-alt"></i> 
                                    Detay
                                    </a>
                                    </center>
                                    </td>
                                    </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                }
                ?>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h4 class="mb-10">Gider Kaydı Oluştur</h4>
                                </div>

                                <div class="col-lg-6">
                                    <h5 class="text-muted">Gider Tarihi</h5>
                                    <h6 class="mb-0"><input type="text" id="gidertarihi" class="form-control" placeholder="Gider Tarihi"></h6>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="text-muted">Gider Tipi</h5>
                                    <h6 class="mb-0"><select id="gidertipi" name="gidertipi" class="form-select">
                                            <option value="0">Gider Tipi</option>
                                            <?php
                                            $fimy_gidertipi = $vt->listele("fimy_gidertipi");
                                            if ($fimy_gidertipi != null) foreach ($fimy_gidertipi as $gt) {
                                                echo '<option value="' . $gt['ID'] . '">' . $gt['GiderAdi'] . '</option>';
                                            }
                                            ?>
                                        </select></h6>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="text-muted">Tutar</h5>
                                    <h6 class="mb-0"><input type="text" id="tutar" class="form-control" placeholder="Fatura Tutarı"></h6>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="text-muted">Ödeme Durumu</h5>
                                    <h6 class="mb-0">
                                        <input type="radio" value="0" id="odendi" name="OdemeKontrol" class="form-check-input" checked>
                                        <label class="form-check-label" for="customRadio1">Ödendi</label>
                                    </h6>
                                    <h6 class="mb-0">
                                        <input type="radio" value="1" id="odenmedi" name="OdemeKontrol" class="form-check-input">
                                        <label class="form-check-label" for="customRadio2">Ödenmedi</label>
                                    </h6>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="text-muted">Fatura Seri No</h5>
                                    <h6 class="mb-0"><input type="text" id="serino" class="form-control" placeholder="Fatura Seri No"></h6>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="text-muted">Açıklama</h5>
                                    <h6 class="mb-0"><input type="text" id="aciklama" class="form-control" placeholder="Açıklama"></h6>
                                </div>
                                <div class="col-lg-12">
                                    <h5 class="text-muted">Son Ödeme Tarihi</h5>
                                    <h6 class="mb-0"><input type="text" id="sonodeme" class="form-control" placeholder="Son Ödeme Tarihi"></h6>
                                </div>
                                <div id="kasadetayi" class="col-lg-12">
                                    <h5 class="text-muted">Kasa</h5>
                                    <h6 class="mb-0">
                                        <select id="kasa" name="kasa" class="form-select">
                                            <option value="0">Kasa</option>
                                            <?php
                                            $fimy_kasa = $vt->listele("fimy_kasa");
                                            if ($fimy_kasa != null) foreach ($fimy_kasa as $ka) {
                                                echo '<option value="' . $ka['ID'] . '">' . $ka['KasaAdi'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </h6>
                                </div>
                                <div class="col-lg-12">
                                    <h6 class="mb-0"><button id="giderkaydet" class="btn btn-block btn-success col-lg-12"> Kaydet </button></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- Row -->


        </div> <!-- container -->

    </div> <!-- content -->
    <!-- Modal -->
    <div class="modal fade" id="barcodeScannerModal" tabindex="-1" aria-labelledby="barcodeScannerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barcodeScannerModalLabel">Barkod Tarayıcı</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="qr-reader" style="width: 100%; height: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- draggable init -->
    <script src="https://unpkg.com/quagga@0.12.1/dist/quagga.min.js"></script>
    <script>
        $(document).ready(function() {

            setTimeout(function() {
                document.getElementById("barkodNo").focus();
            }, 500);

            var permissionGranted = false;

            function onScanSuccess(result) {
                if (result.codeResult.code) {
                    var barkodno = result.codeResult.code;
                    // alert("Barkod Okundu: " + result.codeResult.code);
                    //$("#barkodNo").val(barkodno);
                    $("#barkodNo").val(barkodno).trigger('input');
                    // İsteğe bağlı olarak başka bir işlem yapabilirsiniz.
                    // Örneğin, modal'ı kapatmak için aşağıdaki satırı ekleyebilirsiniz:
                    $('#barcodeScannerModal').modal('hide');
                }
            }

            function requestCameraPermission() {
                return new Promise((resolve, reject) => {
                    navigator.permissions.query({
                            name: 'camera'
                        })
                        .then(permissionStatus => {
                            if (permissionStatus.state === 'granted') {
                                resolve();
                            } else if (permissionStatus.state === 'prompt') {
                                navigator.mediaDevices.getUserMedia({
                                        video: true
                                    })
                                    .then(() => {
                                        permissionGranted = true;
                                        resolve();
                                    })
                                    .catch(error => reject(error));
                            } else {
                                reject("Kamera izni reddedildi.");
                            }
                        })
                        .catch(error => reject(error));
                });
            }


            // Butona tıklandığında modalı aç
            $('#barcodeScannerModal').on('show.bs.modal', function() {
                requestCameraPermission()
                    .then(() => {
                        if (!permissionGranted) {
                            Quagga.init({
                                inputStream: {
                                    name: "Live",
                                    type: "LiveStream",
                                    target: document.querySelector("#qr-reader"),
                                    constraints: {
                                        width: 100,
                                        height: 400,
                                        facingMode: "environment"
                                    },
                                },
                                decoder: {
                                    readers: ["code_128_reader"]
                                }
                            }, function(err) {
                                if (err) {
                                    console.log(err);
                                    return
                                }
                                Quagga.start();
                            });

                            Quagga.onDetected(onScanSuccess);
                        }
                    })
                    .catch(error => console.error(error));
            });

            // Modal kapandığında kamera durdur
            $('#barcodeScannerModal').on('hide.bs.modal', function() {
                Quagga.stop();
            });
        });
    </script>
    <?php echo "<script> var kullanici=" . $_SESSION['KID'] . ";</script>"; ?>
    <script>
        $(document).ready(function() {
            $("#barkodNo").on("input change", function() {
                document.getElementById('preloader').style.display = 'flex';
                var turSelected = $("input[name='UrunTuruSec']:checked").attr("id");
                //var ds = 'barkodNo=' + $('#barkodNo').val() + '&turSelected=' + turSelected + '&yetkili=<?php echo $_SESSION['yetki']; ?>' + '&sayfa=1';
                var ds = 'barkodNo=' + encodeURIComponent($('#barkodNo').val()) + '&turSelected=' + turSelected + '&yetkili=<?php echo $_SESSION['yetki']; ?>';
                $.ajax({
                    url: '../stok-yonetimi/proccess/urun-bul-proccess.fi',
                    type: 'GET',
                    data: ds,
                    success: function(e) {
                        $("div#urunDetayVer").html("").html(e);
                        document.getElementById('preloader').style.display = 'none';
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
                    [1, 'desc']
                ],
                "lengthMenu": [15, 20, 50, 100, 200]
            });

        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
<?php include("../src/access.php");
if ($_GET) {
    require '../src/vendor/autoload.php';
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
            }

            /* echo '  <tr>
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
                                                <td>' . number_format($BirimFiyati, 2, ',', '.') . ' ₺</td>
                                                <td>' . $urun['proccess_date'] . '</td>
                                                </tr>';*/
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

                    <div id="equal-height-row" class="row d-flex align-items-stretch">
                        <div class="col-lg-4">
                            <div class="card urunicerigi">
                                <div class="card-header">
                                    <center>
                                        <input type="hidden" name="UrunID" id="UrunID" value="<?php echo $UrunID; ?>">
                                        <h4> <?php echo $urun['urun_adi']; ?> </h4>
                                    </center>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-lg-12">
                                            <img src="<?php echo $urun['urun_gorseli']; ?>" alt="<?php echo $urun['urun_adi']; ?>" class="urungorseli" id="urungorselimiz">
                                            <br>
                                            <br>
                                            <input class="form-control col-lg-6" type="file" name="urungorseli" id="urungorseli" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card urunicerigi">
                                <div class="card-header">
                                    <center>
                                        <h4> <input class="form-control" type="text" name="urunadi" id="urunadi" value="<?php echo $urun['urun_adi']; ?>"> </h4>
                                    </center>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-lg-6">
                                            <h4 class="mb-0">
                                                <select class="form-control" name="marka" id="marka">
                                                    <?php
                                                    $fimy_marka = $vt->listele("fimy_marka");
                                                    if ($fimy_marka != null) foreach ($fimy_marka as $marka) {
                                                        $Marka = $marka['marka'];
                                                        $MarkaID = $marka['marka_id'];
                                                        echo '<option value="' . $MarkaID . '">' . $Marka . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </h4>
                                            <p class="text-muted">Marka</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4 class="mb-0">
                                                <select class="form-control" name="model" id="model">
                                                    <?php
                                                    $fimy_model = $vt->listele("fimy_model");
                                                    if ($fimy_model != null) foreach ($fimy_model as $model) {
                                                        $Model = $model['model'];
                                                        $ModelID = $model['model_id'];
                                                        echo '<option value="' . $ModelID . '">' . $Model . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </h4>
                                            <p class="text-muted">Model</p>
                                        </div>
                                        <div class="col-lg-12">
                                            <select class="form-control" name="kategoriID" id="kategoriID">
                                                <?php
                                                $fimy_kategoriler = $vt->listele("fimy_kategoriler");
                                                if ($fimy_kategoriler != null) foreach ($fimy_kategoriler as $kat) {
                                                    echo '<option value="' . $kat['ID'] . '">' . $kat['KategoriAdi'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            </h4>
                                            <p class="text-muted">Kategori</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4 class="mb-0">
                                                <input class="form-control" type="text" name="StokKodu" id="StokKodu" value="<?php echo $urun['StokKodu']; ?>">
                                            </h4>
                                            <p class="text-muted">Stok Kodu</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4 class="mb-0">
                                                <select class="form-control" name="olcubirimi" id="olcubirimi">
                                                    <?php
                                                    $fimy_olcubirimi = $vt->listele("fimy_olcubirimi");
                                                    if ($fimy_olcubirimi != null) foreach ($fimy_olcubirimi as $ob) {
                                                        $OlcuBirimi = $ob['OlcuBirimi'];
                                                        echo '<option value="' . $ob['ID'] . '">' . $OlcuBirimi . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </h4>
                                            <p class="text-muted">Ölçü Birimi</p>
                                        </div>
                                        <?php
                                        $yetkili = $_SESSION['yetki'];
                                        $satis_col = 6;
                                        if ($yetkili == 0 || $yetkili == 6) {
                                            $satis_col = 6;
                                        ?>
                                        <div class="col-lg-6">
                                            <h4 class="mb-0">
                                                <input class="form-control" type="text" name="birimfiyati" id="birimfiyati" value="<?php echo number_format($BirimFiyati, 2, ',', ''); ?>">
                                            </h4>
                                            <p class="text-muted">Birim Fiyatı</p>
                                        </div>
                                        <?php 
                                        }else{
                                            $satis_col = 12;
                                            echo '<input type="hidden" name="birimfiyati" id="birimfiyati" value="'.number_format($BirimFiyati, 2, ',', '').'">';
                                        }
                                        ?>
                                        <div class="col-lg-<?php echo $satis_col; ?>">
                                            <h4 class="mb-0">
                                                <input class="form-control" type="text" name="satisfiyati" id="satisfiyati" value="<?php echo number_format($SatisFiyati, 2, ',', ''); ?>">
                                            </h4>
                                            <p class="text-muted">Satış Fiyatı</p>
                                        </div>
                                        <div class="col-lg-12">
                                            <button id="urunGuncelle" class="btn btn-success col-lg-12"> Güncelle </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div id="test"></div>

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
            <script>
                $(document).ready(function() {
                    $("#marka").val(<?php echo $urun['marka']; ?>);
                    $("#model").val(<?php echo $urun['model']; ?>);
                    $("#olcubirimi").val(<?php echo $urun['OlcuBirimi']; ?>);
                    $("#kategoriID").val(<?php echo $urun['KategoriID']; ?>);

                    $('#birimfiyati').mask('00000000000,00', {
                        reverse: true
                    });
                    $('#satisfiyati').mask('00000000000,00', {
                        reverse: true
                    });
                    $("#marka").on("change", function() {
                        var ds = 'markaID=' + $('#marka').val();
                        $.ajax({
                            url: '../stok-yonetimi/proccess/markamodel.fi',
                            type: 'POST',
                            data: ds,
                            success: function(e) {
                                $("select#model").html("").html(e);
                                //console.log(e);
                            }
                        });

                    });
                    $('#urungorseli').change(function() {
                        var fileInput = this;
                        if (fileInput.files && fileInput.files[0]) {
                            var fileName = fileInput.files[0].name;
                            var fileExtension = fileName.split('.').pop().toLowerCase();
                            if ($.inArray(fileExtension, ['jpg', 'jpeg', 'png', 'webp']) === -1) {
                                alert('Sadece jpg, jpeg, png, veya webp uzantılı dosyaları seçebilirsiniz.');
                                $('#urungorseli').val('');
                            } else {
                                var formData = new FormData();
                                formData.append('file', fileInput.files[0]);
                                formData.append('UrunID', $("#UrunID").val());
                                $.ajax({
                                    type: 'POST',
                                    url: '../stok-yonetimi/proccess/urun-gorsel-proccess.fi',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        console.log(response);
                                        var image = new Image();
                                        image.src = URL.createObjectURL(fileInput.files[0]);
                                        image.onload = function() {
                                            var width = this.width;
                                            $('#urungorselimiz').attr('src', this.src);
                                        };
                                        $("div#test").html("").html(response);
                                    },
                                    error: function(error) {
                                        console.error('Dosya yükleme hatası:', error);
                                    }
                                });

                            }
                        }
                    });
                    $("#urunGuncelle").on("click", function() {
                        var inputValues = {
                            'UrunID': $("#UrunID").val(),
                            'urunadi': $("#urunadi").val(),
                            'marka': $("#marka").val(),
                            'model': $("#model").val(),
                            'kategori': $("#kategoriID").val(),
                            'StokKodu': $("#StokKodu").val(),
                            'olcubirimi': $("#olcubirimi").val(),
                            'birimfiyati': $("#birimfiyati").val(),
                            'satisfiyati': $("#satisfiyati").val()
                        };
                        $.ajax({
                            url: '../stok-yonetimi/proccess/urun-duzenle-proccess.fi',
                            type: 'POST',
                            data: inputValues,
                            success: function(e) {
                                console.log(e);
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
    <?php
    }
} else {
    echo '<script>
    toastr["error"]("Ürün Bilgileri Çekilemedi..!");
    setTimeout(function() {
        window.location.href = "./";
    }, 800);
    </script>';
}
include("../src/footer-alt.php"); ?>
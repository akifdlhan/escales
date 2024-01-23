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
                    <div class="card">
                        <div class="card-body">
                            <form id="urunEkleForm">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <img src="#" alt="Yeni Ürün Görseli" class="form-control" src="#" width="250px" id="urungosterimi" name="urungosterimi">
                                        <h4 class="mb-0"> <input class="form-control col-lg-6" type="file" name="urungorseli" id="urungorseli" /> </h4>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4 class="mb-0"> <input class="form-control" type="text" name="urunadi" id="urunadi"> </h4>
                                        <p class="text-muted">Ürün Adı</p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4 class="mb-0"> <input class="form-control" type="text" name="stokkodu" id="stokkodu"> </h4>
                                        <p class="text-muted">Stok Kodu</p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4 class="mb-0">
                                            <select class="form-control" name="olcubirimi" id="olcubirimi">
                                                <option value="0"> Ölçü Birimi..</option>
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
                                    <div class="col-lg-6">
                                        <h4 class="mb-0">
                                            <select class="form-control" name="marka" id="marka">
                                                <option value="0">Marka..</option>
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
                                                <option value="0"> Model.. </option>
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
                                        <h4 class="mb-0">
                                            <select class="form-control" name="kategori" id="kategori">
                                                <option value="0">Kategori..</option>
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
                                        <h4 class="mb-0"> <input class="form-control" type="text" name="birimfiyati" id="birimfiyati"> </h4>
                                        <p class="text-muted">Birim Fiyatı</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="mb-0"> <input class="form-control" type="text" name="satisfiyati" id="satisfiyati"> </h4>
                                        <p class="text-muted">Satış Fiyatı</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="mb-0">
                                            <select class="form-control" name="depo" id="depo">
                                                <option value="0"> Depo.. </option>
                                                <?php
                                                $fimy_depolar = $vt->listele("fimy_depolar");
                                                if ($fimy_depolar != null) foreach ($fimy_depolar as $depo) {
                                                    $Depo = $depo['depo_adi'];
                                                    $DepoID = $depo['ID'];
                                                    echo '<option value="' . $DepoID . '">' . $Depo . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </h4>
                                        <p class="text-muted">Depo</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="mb-0"> <input class="form-control" type="text" name="stokmiktari" id="stokmiktari"> </h4>
                                        <p class="text-muted">Stok Miktarı</p>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <input type="submit" class="btn btn-success col-lg-12" value=" + Ekle">
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <!-- end row -->


        </div> <!-- container -->

    </div> <!-- content -->
    <script>
        $(document).ready(function() {
            $('#birimfiyati').mask('00000000000,00', {
                reverse: true
            });
            $('#satisfiyati').mask('00000000000,00', {
                reverse: true
            });
            $('#stokmiktari').mask('000000000000', {});
            $("#marka").on("change", function() {
                var ds = 'markaID=' + $('#marka').val();
                $.ajax({
                    url: '../stok-yonetimi/proccess/markamodel.fi',
                    type: 'POST',
                    data: ds,
                    success: function(e) {
                        $("select#model").html("").html(e);
                        console.log(e);
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
                        var image = new Image();
                        image.src = URL.createObjectURL(fileInput.files[0]);
                        image.onload = function() {
                            // $('#urungosterimi').attr('src', this.src);
                            var width = this.width;
                            if (width >= 100) {
                                $('#urungosterimi').attr('src', this.src);
                            } else {
                                alert('Görsel genişiliği 100px\'den küçük olmalıdır.');
                                $('#urungorseli').val('');
                            }
                        };
                    }
                }
            });
            $("#urunEkleForm").submit(function(event) {
                event.preventDefault(); // Formun normal submit işlemini engelle

                // Formdaki değerleri topla
                var formData = new FormData(this);

                // AJAX isteği gönder
                $.ajax({
                    url: '../stok-yonetimi/proccess/urun-ekle-proccess.fi',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        var responses = JSON.parse(response);
                        var refreshCheck = responses[0].refresh;

                        if (refreshCheck == 0) {
                            toastr[responses[0].status](responses[0].message);
                        } else {
                            toastr[responses[0].status](responses[0].message);

                            setTimeout(function() {
                                window.location.href = window.location.href;
                            }, 800);
                        }
                    },
                    error: function(error) {
                        toastr.error("Bir hata oluştu.");
                    }
                });
            });
        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
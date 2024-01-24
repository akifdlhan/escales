<?php include("../src/access.php"); ?>

<style>
    .select2 {
        display: block !important;
        width: 100%;
        padding: 0.45rem 0.9rem;
        font-size: .9rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--ct-input-color);
        background-color: var(--ct-input-bg);
        background-clip: padding-box;
        border: 1px solid var(--ct-input-border-color);
        -webkit-appearance: none;
        appearance: none;
        border-radius: 0.2rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    
    .select2-container {
        display: block !important;
        width: 100%;
        padding: 0.45rem 0.9rem;
        font-size: .9rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--ct-input-color);
        background-color: var(--ct-input-bg);
        background-clip: padding-box;
        border: 1px solid var(--ct-input-border-color);
        -webkit-appearance: none;
        appearance: none;
        border-radius: 0.2rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>Personel Bilgiler</h5>
                                <div class="col-lg-6">
                                    <label for="TC">TC</label>
                                    <input class="form-control" placeholder="TC" id="TC" name="TC" required type="text">
                                </div>
                                <div class="col-lg-8"></div>
                                <div class="col-lg-6">
                                    <label for="Adi"><p class="mg-b-10" style="margin-top:2px;">Adı</p></label>
                                    <input type="text" placeholder="Adı" name="Adi" id="Adi" class="form-control" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="Soyadi"><p class="mg-b-10" style="margin-top:2px;">Soyadı</p></label>
                                    <input type="text" name="Soyadi" placeholder="Soyadı" id="Soyadi" class="form-control">
                                </div>
                                <div class="col-lg-6">
                                    <label for="Telefon"><p class="mg-b-10" style="margin-top:2px;">Telefon</p></label>
                                    <input type="text" name="Telefon" class="form-control" placeholder="(000)000-0000" id="Telefon" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="Cinsiyet"><p class="mg-b-10" style="margin-top:2px;">Cinsiyet</p></label>
                                    <select class="form-control" id="Cinsiyet" name="Cinsiyet">
                                        <option value="Erkek">Erkek</option>
                                        <option value="Kadın">Kadın</option>
                                    </select><br>
                                </div>
                                <div class="col-lg-6">
                                    <label for="Departman" class="form-label" for="Departman">Departman</label>
                                    <input class="form-control" placeholder="Departman" id="Departman" required type="text">
                                </div>
                                <div class="col-lg-3">
                                    <label for="BaslamaTarihi" class="form-label" for="BaslamaTarihi">Başlama Tarihi:</label>
                                    <input type="text" id="BaslamaTarihi" class="form-control" placeholder="BaslamaTarihi">
                                </div>

                                <div class="row row-sm">
                                    <div class="col-lg-12">
                                        <div class="az-content-label mg-b-5">
                                            <h5>Adres Bilgileri</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mg-b-0">
                                            <select id="il" class="form-control select2">
                                                <option value="il">İl..</option>
                                                <?php
                                                $ils = $vt->listele("fimy_il");
                                                if ($ils != null)
                                                    foreach ($ils as $il) {
                                                        echo '<option value="' . $il['ID'] . '">' . $il['il'] . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div><!-- form-group -->
                                    </div><!-- col-lg-6 -->
                                    <div class="col-lg-6">
                                        <div class="form-group mg-b-0">
                                            <select id="ilce" class="form-control select2">
                                                <option value="ilce">İlçe..</option>
                                                <?php
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group has-success mg-b-0">
                                            <p class="mg-b-10" style="margin-top:5px;">
                                                <label for="Adres">Adres:</label>
                                                <textarea class="form-control" rows="3" placeholder="Adres" id="Adres" name="Adres" required type="text"></textarea>
                                        </div>
                                    </div>
                                    <input type="button" value="Kaydet" id="submitButton" class="scroll-button" name="button">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="successMessage"></div>

                <style>
                    .scroll-button {
                        width: 60px;
                        height: 60px;
                        background-color: #09e00d;
                        color: white;
                        font-size: 12px;
                        font-weight: bold;
                        border: none;
                        border-radius: 50%;
                        position: fixed;
                        top: 72px;
                        right: 30px;
                        cursor: pointer;
                        transition: bottom 0.3s ease;
                    }
                </style>
            </div>

            <script>
                flatpickr("#BaslamaTarihi", {
                    maxDate: "today",
                    dateFormat: "Y-m-d"
                });

                $(document).ready(function () {
                    $('#TC').on('input', function () {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });

                    $('#Telefon').on('input', function () {
                        this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value.length === 1 && this.value === '0') {
                        this.value = '';
                    }
                    });
                    $("#submitButton").click(function () {
                        var TC = $("#TC").val().trim();
                        var Adi = $("#Adi").val().trim();
                        var Soyad = $("#Soyadi").val().trim();
                        var Telefon = $("#Telefon").val().trim();
                        var Cinsiyet = $("#Cinsiyet").val().trim();
                        var Departman = $("#Departman").val().trim();
                        var Adres = $("#Adres").val().trim();
                        var il = $("#il").val().trim();
                        var ilce = $("#ilce").val().trim();
                        var BaslamaTarihi = $("#BaslamaTarihi").val().trim();

                        if (TC === '' || Adi === '' || Soyad === '' || Departman === '' || BaslamaTarihi === '') {
                            alert("TC, Ad, Soyad, Departman ve Başlama Tarihi alanları doldurmak zorundasınız");
                            return;
                        }

                        var formData = {
                            TC: TC,
                            Adi: Adi,
                            Soyad: Soyad,
                            Telefon: Telefon,
                            Cinsiyet: Cinsiyet,
                            Departman: Departman,
                            Adres: Adres,
                            il: il,
                            ilce: ilce,
                            BaslamaTarihi: BaslamaTarihi
                        };

                        $.ajax({
                            url: 'personel-add.fi',
                            type: 'POST',
                            data: formData, // Tüm form verilerini gönderiyoruz
                            success: function (response) {
                                alert(response);
                            },
                            error: function (xhr, status, error) {
                                alert("Ajax isteği sırasında bir hata oluştu: " + error);
                            }
                        });
                    });

                    $("#il").select2();
                    $("#ilce").select2();
                    $("#il").on("change", function () {
                        var ds = 'ilID=' + $('#il').val();
                        $.ajax({
                            url: '../muhasebe/process/ililce_filtre.fi',
                            type: 'POST',
                            data: ds,
                            success: function (e) {
                                $("select#ilce").html("").html(e);
                            }
                        });
                    });
                });
            </script>

            <?php include("../src/footer-alt.php"); ?>

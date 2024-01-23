<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style>
    .select2 {
        display: block !important;
        max-width: 100%;
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

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4"> <a target="_blank" href="../muhasebe/yeni-musteri.php" class="btn btn-blue col-lg-12"> Müşteri Oluştur </a> </div>
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4"> <button id="siparisolustur" class="btn btn-success col-lg-12"> Siparişi Oluştur </button> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mg-b-0">
                                        <input type="hidden" name="OlusturanKullanici" id="OlusturanKullanici" value="<?php echo $_SESSION['KID']; ?>">
                                        <label class="form-label" for="musteri">Müşteri</label>
                                        <select id="musteri" class="form-control select2">
                                            <option value="0">Müşteri..</option>
                                            <?php
                                            $fimy_cari_hesap = $vt->listele("fimy_cari_hesap", "ORDER BY Olusturma DESC");
                                            if ($fimy_cari_hesap != null) foreach ($fimy_cari_hesap as $ch) {
                                                echo '<option value="' . $ch['ID'] . '">' . $ch['Adi'] . ' ' . $ch['Soyadi'] .  '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-6">
                                    <label class="form-label" for="tahminiteslim">Tahmini Teslim Tarihi</label>
                                    <input type="text" id="tahminiteslim" class="form-control" placeholder="Tahmini Teslim Tarihi">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <label class="form-label" for="siparisNotu">Sipariş Notu</label>
                            <textarea class="form-control" name="siparisNotu" id="siparisNotu" cols="10" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label" for="urun">Ürün</label>
                                        <select id="urun" class="form-control select2">
                                            <option value="0">Ürün Seçiniz..</option>
                                            <?php
                                            $fimy_urunler = $vt->listele("fimy_urunler", "ORDER BY ID DESC");
                                            if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
                                                echo '<option value="' . $urun['ID'] . '">' . $urun['StokKodu'] . ' | ' . $urun['urun_adi'] .  '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-2">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label" for="birimfiyati">Birim Fiyatı</label>
                                        <input type="text" id="birimfiyati" class="form-control" placeholder="Birim Fiyatı">
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-2">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label" for="urunadet">Adet</label>
                                        <input type="text" id="urunadet" class="form-control" placeholder="Adet">
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-2">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label" for="araToplam">Ara Toplam</label>
                                        <input type="text" id="araToplam" class="form-control" placeholder="Ara Toplam">
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-2">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label" for="urunekle"> <button id="tekrarhesapla" class="btn btn-warning col-lg-12"> Tekrar Hesapla </button> </label>
                                        <button id="urunekle" class="btn btn-success col-lg-12"> + Ürün Ekle</button>
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="tempUrunListesi" class="table text-center">
                                <thead>
                                    <th class="text-start"> Ürün </th>
                                    <th> Adet </th>
                                    <th> Birim Fiyatı </th>
                                    <th> Ara Toplam </th>
                                </thead>
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
    <script>
        $(document).ready(function() {
            $('#urunadet').mask('00000000000', {});
            $('#birimfiyati').mask('00000000000.00', {
          reverse: true
        });
            $("#musteri").select2();
            $("#urun").select2();
            flatpickr("#tahminiteslim", {
                minDate: "today",
                dateFormat: "Y-m-d"
            });

            $("#tekrarhesapla").on("click", function() {
                if ($('#birimfiyati').val() == 0 || $('#birimfiyati').val() == "") {
                    toastr["warning"]("Lütfen ürünlere ait alanalrı kontrol ediniz..");
                } else {
                    var ds = 'urunadet=' + $('#urunadet').val() + '&birimfiyati=' + $('#birimfiyati').val() + '&islemSec=0';
                    $.ajax({
                        url: '../stok-yonetimi/proccess/urun-birim-fiyat.fi',
                        type: 'POST',
                        data: ds,
                        success: function(e) {
                            var responses = JSON.parse(e);
                            var aratoplam = responses[0].toastrac;
                            if (aratoplam == 0) {
                                $("#araToplam").val(responses[0].satisfiyati).trigger('input');
                            }
                        }
                    });
                }

            });

            $("#urunadet").on("input", function() {
                var ds = 'urunadet=' + $('#urunadet').val() + '&birimfiyati=' + $('#birimfiyati').val() + '&islemSec=0';
                $.ajax({
                    url: '../stok-yonetimi/proccess/urun-birim-fiyat.fi',
                    type: 'POST',
                    data: ds,
                    success: function(e) {
                        var responses = JSON.parse(e);
                        var stoksayisi = responses[0].stoksayisi;

                        var aratoplam = responses[0].toastrac;
                        if (aratoplam == 0) {
                            $("#araToplam").val(responses[0].satisfiyati).trigger('input');
                        }

                    }
                });
            });

            $("#urun").on("change", function() {
                var ds = 'urun=' + $('#urun').val() + '&islemSec=1';
                $.ajax({
                    url: '../stok-yonetimi/proccess/urun-birim-fiyat.fi',
                    type: 'POST',
                    data: ds,
                    success: function(e) {
                        var responses = JSON.parse(e);
                        var stoksayisi = responses[0].stoksayisi;
                        if (stoksayisi <= 0) {
                            toastr["error"]("Ürün için yeterli stok mevcut değildir..");
                            $("#birimfiyati").val("0,00").trigger('input');
                            $('#urun').val(0);
                        } else {
                            toastr["warning"]("Tüm depolarda " + responses[0].stoksayisi + " adet ürün mevcuttur.");
                            $("#birimfiyati").val(responses[0].satisfiyati).trigger('input');
                        }
                        // $("#birimfiyati").val(e).trigger('input');

                    }
                });
            });

            $("#urunadet").on("change", function() {
                var ds = 'urunadet=' + $('#urunadet').val() + '&urun=' + $('#urun').val() + '&birimfiyati=' + $('#birimfiyati').val() + '&islemSec=2';
                $.ajax({
                    url: '../stok-yonetimi/proccess/urun-birim-fiyat.fi',
                    type: 'POST',
                    data: ds,
                    success: function(e) {
                        console.log(e);
                        var responses = JSON.parse(e);
                        var urun = responses[0].urun;
                        var stoksayisi = responses[0].stoksayisi;
                        var urunadeti = $('#urunadet').val();
                        // tempUrunList
                        var mevcutUrunIndex = -1;
                        for (var i = 0; i < tempUrunList.length; i++) {
                            if (tempUrunList[i].urun === urun) {
                                mevcutUrunIndex = i;
                                break;
                            }
                        }
                        // Eğer ürün varsa, miktarı stok miktarından çıkar
                        if (mevcutUrunIndex !== -1) {
                            var Dizistoksayisi = tempUrunList[mevcutUrunIndex].adet;
                            stoksayisi = stoksayisi - Dizistoksayisi;
                        }
                        // tempUrunList
                        // console.log(Dizistoksayisi);
                        if (stoksayisi < 0) {
                            $('#urun').val(0).trigger('change');
                            $("#birimfiyati").val("0,00").trigger('input');
                            $("#urunadet").val("0").trigger('input');
                            $("#araToplam").val("0,00").trigger('input');
                            toastr["error"]("Ürün için yeterli stok mevcut değildir..");
                        } else {
                            if (stoksayisi >= urunadeti) {
                                stoksayisimiz = stoksayisi - urunadeti;
                                toastr["warning"]("Tüm depolarda kullanılabilir " + stoksayisimiz + " adet ürün mevcuttur.");
                                $("#birimfiyati").val(responses[0].satisfiyati).trigger('input');
                            } else if (stoksayisi == 0) {
                                $('#urun').val(0).trigger('change');
                                $("#birimfiyati").val("0,00").trigger('input');
                                $("#urunadet").val("0").trigger('input');
                                $("#araToplam").val("0,00").trigger('input');
                                toastr["error"]("Ürün için yeterli stok mevcut değildir..");
                            } else {
                                $('#urun').val(0).trigger('change');
                                $("#birimfiyati").val("0,00").trigger('input');
                                $("#urunadet").val("0").trigger('input');
                                $("#araToplam").val("0,00").trigger('input');
                                toastr["error"]("Ürün için yeterli stok mevcut değildir..");
                            }
                            // toastr["warning"]("Tüm depolarda " + responses[0].stoksayisi + " adet ürün mevcuttur.");
                            // $("#birimfiyati").val(responses[0].satisfiyati).trigger('input');
                        }
                        // $("#birimfiyati").val(e).trigger('input');

                    }
                });
            });

            var tempUrunList = [];

            $('#urunekle').on('click', function() {
                // var musteri = $('#musteri').val();
                // var OlusturanKullanici = $('#OlusturanKullanici').val();
                // var tahminiteslim = $('#tahminiteslim').val();
                var urunSelect = $('#urun');
                var urun = urunSelect.val();
                var urunText = urunSelect.find('option:selected').text();
                var birimfiyati = $('#birimfiyati').val();
                var urunadet = $('#urunadet').val();
                var siparisNotu = $('#siparisNotu').val();
                var araToplam = $('#araToplam').val();

                if (urun == 0 || birimfiyati == 0 || urunadet == 0) {
                    toastr['warning']('Ürün, Birim Fiyatı ve Adet Bilgilerini Kontrol Ediniz..');
                } else {

                    // tempUrunList.push({
                    //     urun: urun,
                    //     adet: urunadet,
                    //     birimfiyati: birimfiyati,
                    //     araToplam: araToplam
                    // });
                    var urunIndex = -1;
                    for (var i = 0; i < tempUrunList.length; i++) {
                        if (tempUrunList[i].urun === urun) {
                            urunIndex = i;
                            break;
                        }
                    }

                    // Eğer ürün daha önce eklenmişse güncelle, yoksa ekle
                    if (urunIndex !== -1) {
                        // Ürün daha önce eklenmişse adet, birim fiyat ve ara toplamı güncelle
                        tempUrunList[urunIndex].adet += parseInt(urunadet);
                        tempUrunList[urunIndex].birimfiyati = parseFloat(birimfiyati);
                        tempUrunList[urunIndex].araToplam += parseFloat(araToplam);
                    } else {
                        // Ürün daha önce eklenmemişse yeni bir öğe olarak ekle
                        tempUrunList.push({
                            urunText: urunText,
                            urun: urun,
                            adet: parseInt(urunadet),
                            birimfiyati: parseFloat(birimfiyati),
                            araToplam: parseFloat(araToplam)
                        });
                        // console.log(tempUrunList);
                    }
                    $('#tempUrunListesi').empty(); // Önce tabloyu temizle
                    // tempUrunList içindeki her bir öğeyi tabloya ekle
                    tempUrunList.forEach(function(item) {
                        birimfiyati = item.birimfiyati;
                        araToplam = item.araToplam;
                        var birimfiyati = birimfiyati.toLocaleString('tr-TR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        var araToplam = araToplam.toLocaleString('tr-TR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $('#tempUrunListesi').append('<tr><td class="text-start">' + item.urunText + '</td><td>' + birimfiyati + '</td><td>' + item.adet + '</td><td>' + araToplam + '</td></tr>');
                    });
                    // $('#tempUrunListesi').append('<tr><td class="text-start">' + urunText + '</td><td>' + urunadet + '</td><td>' + birimfiyati + '</td><td>' + araToplam + '</td></tr>');
                    updateTotal();
                    $('#birimfiyati').val("0,00");
                    $('#urunadet').val("0");
                    $('#araToplam').val("0,00");
                    $('#urun').val(0);

                    function updateTotal() {
                        var total = parseFloat(0);
                        for (var i = 0; i < tempUrunList.length; i++) {
                            // araToplamTopla = tempUrunList[i].araToplam.replace(/\./g, '').replace(/,/g, '.');
                            araToplamTopla = tempUrunList[i].araToplam;
                            total += parseFloat(araToplamTopla);
                            // total += tempUrunList[i].araToplam;
                        }
                        var total = total.toLocaleString('tr-TR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $('#tempUrunListesiTotal').remove();
                        $('#tempUrunListesi').append('<tr id="tempUrunListesiTotal"><td class="text-end" colspan="3"><strong>Total:</strong></td><td><strong>' + total + '</strong></td></tr>');
                    }
                    $('#urun').val(0).trigger('change');
                }

                //console.log(tempUrunList);
            });
            var tempCustomerinfo = [];
            $('#siparisolustur').on('click', function() {
                var musteri = $('#musteri').val();
                var OlusturanKullanici = $('#OlusturanKullanici').val();
                var tahminiteslim = $('#tahminiteslim').val();
                var siparisNotu = $('#siparisNotu').val();
                tempCustomerinfo.push({
                    musteri: musteri,
                    tahminiteslim: tahminiteslim,
                    OlusturanKullanici: OlusturanKullanici,
                    siparisNotu: siparisNotu
                });
                //console.log(tempCustomerinfo);
                $.ajax({
                    url: '../stok-yonetimi/proccess/siparis-formu-procces.fi',
                    type: 'POST',
                    data: {
                        UrunList: tempUrunList,
                        tempCustomerinfo: tempCustomerinfo
                    },
                    success: function(e) {
                        console.log(e);
                        var responses = JSON.parse(e);
                        var refreshCheck = responses[0].refresh;

                        if (refreshCheck == 0) {
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
    <?php include("../src/footer-alt.php"); ?>
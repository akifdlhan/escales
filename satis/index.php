<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <input style="height: 60px; font-size:40px; color:black; text-align:center;" type="text" name="barkodNo" id="barkodNo" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table">
                                        <table class="table table-responsive">
                                            <thead class="text-center">
                                                <th> Adet </th>
                                                <th> Ürün Adı </th>
                                                <th> Barkod </th>
                                                <th> Birim Fiyatı </th>
                                                <th> </th>
                                            </thead>
                                            <tbody id="satis-gecmisi" class="text-center">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Toplam Fiyatlar Tablosu -->
                                    <div class="table">
                                        <table class="table table-responsive text-end">
                                            <tbody id="total-prices">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    marka - model - stokkodu {ara}
                    <div class="card">
                        <div class="card-body">
                            <div id="product-container" class="row">

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
            setTimeout(function() {
                document.getElementById("barkodNo").focus();
            }, 500);

            var page = 1; // Başlangıç sayfası
            var loading = false; // İçeriğin yüklenip yüklenmediğini kontrol etmek için kullanılır

            function loadContent() {
                if (loading) {
                    return;
                }

                loading = true;

                $.ajax({
                    url: '../satis/proccess/satis-urun-proccess.fi', // Ajax içeriğini getirecek PHP dosyanızın adını ve yolunu belirtin
                    method: 'GET',
                    data: {
                        page: page
                    },
                    success: function(response) {
                        if (response.trim() != '') {
                            $('#product-container').append(response); // Yeni içeriği sayfaya ekle
                            page++; // Bir sonraki sayfa için sayacı artır
                        }
                    },
                    complete: function() {
                        loading = false;
                    }
                });
            }

            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $('#product-container').height() - 100) {
                    loadContent();
                }
            });

            var temporaryProducts = [];

            function addToCart(product) {
                temporaryProducts.push(product);
                updateCartTable();
            }
            window.updateAdet = function(barkod, newValue) {
                var index = temporaryProducts.findIndex(product => product.barkod === barkod);

                if (index !== -1) {
                    temporaryProducts[index].adet = parseInt(newValue, 10);
                    updateCartTable(); // Adet değeri güncellendikten sonra tabloyu yenile
                }
            }
            window.removeFromCart = function(barkod) {
                var indexToRemove = findIndexByBarkod(barkod);

                if (indexToRemove !== -1) {
                    var product = temporaryProducts[indexToRemove];

                    // Eğer ürün adeti 1'den büyükse, sadece adeti eksilt
                    if (product.adet > 1) {
                        product.adet--;
                    } else {
                        // Eğer ürün adeti 1 ise, ürünü tamamen kaldır
                        temporaryProducts.splice(indexToRemove, 1);
                    }

                    // mergedProducts nesnesini güncelle
                    updateMergedProducts();

                    updateCartTable();
                } else {
                    console.log('Ürün bulunamadı. Barkod: ' + barkod);
                }
            }

            function findIndexByBarkod(barkod) {
                for (var i = 0; i < temporaryProducts.length; i++) {
                    if (temporaryProducts[i] && temporaryProducts[i].barkod === barkod) {
                        return i;
                    }
                }
                return -1; // Barkod bulunamadı
            }




            function updateMergedProducts() {
                // mergedProducts nesnesini sıfırla
                mergedProducts = {};

                // temporaryProducts dizisini dön
                temporaryProducts.forEach(function(product) {
                    var barkod = product.barkod;

                    // Eğer mergedProducts içinde aynı barkod varsa, adeti topla
                    if (mergedProducts[barkod]) {
                        mergedProducts[barkod].adet += product.adet;
                    } else {
                        // Eğer yoksa, yeni bir ürün olarak ekle
                        mergedProducts[barkod] = {
                            adet: product.adet,
                            name: product.name,
                            barkod: barkod,
                            fiyat: product.fiyat
                        };
                    }
                });
            }


            function calculateTotalPrices() {
                var totalPriceTableBody = $('#total-prices'); // Toplam fiyatları gösterecek tablonun tbody'si

                // Toplam fiyatı tutacak bir değişken oluştur
                var totalPrice = 0;

                // temporaryProducts dizisini dön
                temporaryProducts.forEach(function(product) {
                    totalPrice += parseFloat(product.fiyat) * product.adet;
                });

                var kdvTutari = 0;
                var iskontoTutari = 0;

                // Ara toplamı hesapla
                var araToplam = totalPrice + kdvTutari - iskontoTutari;

                // Tabloyu temizle
                totalPriceTableBody.empty();

                // Toplam fiyatları tabloya ekle
                var row = '<tr>' +
                    '<th>Ara Toplam</th>' +
                    '<td><input id="aratoplam" class="form-control" type="text" value="' + araToplam.toFixed(2) + '"</td>' +
                    '</tr>';
                totalPriceTableBody.append(row);
            }

            

            function updateCartTable() {
                var cartTableBody = $('#satis-gecmisi');
                var mergedProducts = {};

                temporaryProducts.forEach(function(product, index) {
                    var barkod = product.barkod;

                    if (mergedProducts[barkod]) {
                        mergedProducts[barkod].adet += product.adet;
                    } else {
                        mergedProducts[barkod] = {
                            adet: product.adet,
                            name: product.name,
                            barkod: barkod,
                            fiyat: product.fiyat
                        };
                    }
                });

                cartTableBody.empty();

                Object.values(mergedProducts).forEach(function(mergedProduct, index) {
                    var row = '<tr>' +
                        '<td><input type="number" class="adet-input" id="adet-input-' + mergedProduct.barkod + '" value="' + mergedProduct.adet + '" onchange="updateAdet(\'' + mergedProduct.barkod + '\', this.value)"></td>' +
                        '<td>' + mergedProduct.name + '</td>' +
                        '<td>' + mergedProduct.barkod + '</td>' +
                        '<td>' + mergedProduct.fiyat + '</td>' +
                        '<td><button class="btn btn-danger" onclick="removeFromCart(\'' + mergedProduct.barkod + '\')">Kaldır</button></td>' +
                        '</tr>';
                    cartTableBody.append(row);
                });

                calculateTotalPrices();
            }



            // Barkod numarası girildiğinde çağrılan fonksiyon
            function onBarkodNoEntered() {
                var barkodNo = $('#barkodNo').val();

                // AJAX isteği
                $.ajax({
                    url: '../satis/proccess/satis-listesi.fi',
                    method: 'GET',
                    data: {
                        barkodNo: barkodNo
                    },
                    success: function(response) {
                        var product = JSON.parse(response);
                        if (product.varyok == 1) {
                            $('#barkodNo').val("");
                            addToCart(product);
                        } else {
                            toastr["warning"]('Ürün bulunamadı.');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX hatası:', error);
                    }
                });
            }

            // BarkodNo inputunda değişiklik olduğunda çağrılacak fonksiyon
            $('#barkodNo').on('input', function() {
                onBarkodNoEntered();
            });

            // Sayfa yüklendiğinde başlangıçta bir kere içeriği yükle
            loadContent();
        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
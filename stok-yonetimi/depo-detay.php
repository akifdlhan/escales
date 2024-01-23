<?php
include("../src/access.php");
if (isset($_GET['DepoID']) && !empty($_GET['DepoID'])) {
    $DepoID = $_GET['DepoID'];

    // Depo bilgilerini ve sorumlu kullanıcının detaylarını al
    $query = "SELECT depo.*, udet.User_ID as SorumluID, udet.Adi, udet.Soyadi, udet.TelefonNo, udet.Mail 
              FROM fimy_depolar depo, fimy_user_details udet
              WHERE depo.sorumlu_id = udet.User_ID
              AND depo.ID = $DepoID";
    $depoDetail = $vt->ozellistele($query);
    if ($depoDetail) {
        // Veritabanından gelen verileri kullanmak için döngüyü başlat
        foreach ($depoDetail as $depo) {
            $DepoAdi = $depo['depo_adi'];
            $SorumID = $depo['SorumluID'];
            $SatisDeposu = $depo['SatisDeposu'];
            $SorumluAdi = $depo['Adi'];
            $SorumluSoyadi = $depo['Soyadi'];
            $SorumluTelefon = $depo['TelefonNo'];
            $SorumluMail = $depo['Mail'];
            echo '<script>
        newTitle="' . $DepoAdi . ' | ' . $_SESSION['Firma'] . '";
        document.title = newTitle;
        document.getElementById("page-title-main").innerHTML = "' . $DepoAdi . '";
        </script>';
?>
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-center"><?php echo $DepoAdi; ?></h3>
                                        <p>Sorumlu Adı: <?php echo $SorumluAdi; ?></p>
                                        <p>Sorumlu Soyadı: <?php echo $SorumluSoyadi; ?></p>
                                        <p>Sorumlu Telefon: <?php echo $SorumluTelefon; ?></p>
                                        <p>Sorumlu E-posta: <?php echo $SorumluMail; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                        $fimy_urun_stok_depo = $vt->ozellistele("SELECT SUM(stok_miktari) as stok_miktari FROM fimy_urun_stok_depo WHERE bulundugu_depo={$DepoID};");
                                        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                                            $stok_miktari = $usd['stok_miktari'];
                                        }
                                        ?>
                                        <h3 class="text-center"> Depo Özet </h3>
                                        <p> Ürün Sayısı.: <b> <?php echo number_format($stok_miktari, 0, '', '.'); ?> </b> </p>
                                        <p> <button data-bs-toggle="modal" data-bs-target="#statics" class="btn btn-info"> Marka & Modele Göre İstatistik </button> </p>
                                        <p> <?php
                                            if ($SatisDeposu == 1) {
                                                $s = "<button class='btn btn-success'>Satış Deposu</button>";
                                            } else {
                                                $s = "<button class='btn btn-danger'>Satış Deposu Değil</button>";
                                            }
                                            echo $s;
                                            ?> </p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <button data-bs-toggle="modal" data-bs-target="#stokaktar" class="btn btn-bordered-success col-lg-12"> Ürün Aktar </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <button data-bs-toggle="modal" data-bs-target="#aktarimOnaylari" class="btn btn-bordered-info col-lg-12"> <i class="ti-check-box"></i> Aktarım Onayları </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <button data-bs-toggle="modal" data-bs-target="#depoDuzenle" class="btn btn-bordered-blue col-lg-12"> <i class="ti-pencil-alt"></i> Düzenle </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <a target="_blank" href="../stok-yonetimi/proccess/depobazlitoplubarkod.fi?EscalesDepoID=<?php echo $DepoID; ?>" class="btn btn-block btn-secondary col-lg-12"> <i class="ti-envelope"></i> Toplu Barkod Bas </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-12">
                                <div style="margin:2px;" id="dugmeler"></div>
                                <table id="urunstoklistesi" class="table table-bordered dt-responsive table-responsive">
                                    <thead>
                                        <tr>
                                            <th> </th>
                                            <th> </th>
                                            <th> Barkod </th>
                                            <th> Stok Kodu </th>
                                            <th> Ürün Adı </th>
                                            <th> Marka </th>
                                            <th> Model </th>
                                            <th> Stok Miktarı </th>
                                            <th> Kategori </th>
                                            <th> Birim Fiyatı </th>
                                            <th> Eklenme Tarihi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE bulundugu_depo={$DepoID} ORDER BY ID DESC");
                                        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $depourun) {
                                            $fimy_urunler = $vt->listele("fimy_urunler", "WHERE ID={$depourun['UrunID']} ORDER BY ID DESC");
                                            if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
                                                $fimy_urun_stok_depo = $vt->ozellistele("SELECT SUM(stok_miktari) as stok_miktari FROM fimy_urun_stok_depo WHERE bulundugu_depo={$DepoID} and UrunID={$urun['ID']};");
                                                if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                                                    $stok_miktari = $usd['stok_miktari'];
                                                }
                                                $fimy_urun_fiyat = $vt->listele("fimy_urun_fiyat", "WHERE UrunID={$urun['ID']};");
                                                if ($fimy_urun_fiyat != null) foreach ($fimy_urun_fiyat as $uf) {
                                                    $BirimFiyati = $uf['BirimFiyati'];
                                                }
                                                $fimy_kategoriler = $vt->listele("fimy_kategoriler", "WHERE ID={$urun['KategoriID']};");
                                                if ($fimy_kategoriler != null) foreach ($fimy_kategoriler as $kat) {
                                                    $KategoriAdi = $kat['KategoriAdi'];
                                                }
                                                $fimy_marka = $vt->listele("fimy_marka", "WHERE marka_id={$urun['marka']};");
                                                if ($fimy_marka != null) foreach ($fimy_marka as $marka) {
                                                    $Marka = $marka['marka'];
                                                }
                                                $fimy_model = $vt->listele("fimy_model", "WHERE model_id={$urun['model']};");
                                                if ($fimy_model != null) foreach ($fimy_model as $model) {
                                                    $Model = $model['model'];
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
                                                <td>' . $Marka . '</td>
                                                <td>' . $Model . '</td>
                                                <td>' . $stok_miktari . '</td>
                                                <td>' . $KategoriAdi . '</td>
                                                <td>' . number_format($BirimFiyati, 2, ',', '.') . ' ₺</td>
                                                <td>' . $urun['proccess_date'] . '</td>
                                                </tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end row -->
                    </div> <!-- container -->
                </div> <!-- content -->
                <!-- Stok Aktar - Modal -->
                <div class="modal fade" id="statics" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myCenterModalLabel">Depo Sayıları</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                $markalar = array();
                                $modeller = array();
                                $kategoriler = array();
                                $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE bulundugu_depo={$DepoID}");
                                if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $urunsd) {
                                    // $urunIDler[] = $urunsd['UrunID'];
                                    // $birlesmisUrunIDler = implode(',', $urunIDler);
                                    $fimy_urunler = $vt->listele("fimy_urunler", "WHERE ID={$urunsd['UrunID']}");
                                    if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
                                        $marka = $urun['marka'];
                                        $model = $urun['model'];
                                        $kategori = $urun['KategoriID'];
                                        // Marka bilgisini hesapla
                                        if (!isset($markalar[$marka])) {
                                            $markalar[$marka] = 0;
                                        }
                                        $markalar[$marka] += $urunsd['stok_miktari'];

                                        // Model bilgisini hesapla
                                        if (!isset($modeller[$model])) {
                                            $modeller[$model] = 0;
                                        }
                                        $modeller[$model] += $urunsd['stok_miktari'];

                                        // Kategori bilgisini hesapla
                                        if (!isset($kategoriler[$kategori])) {
                                            $kategoriler[$kategori] = 0;
                                        }
                                        $kategoriler[$kategori] += $urunsd['stok_miktari'];
                                    }
                                }
                                ?>
                                <ul class="nav nav-tabs nav-bordered nav-justified">
                                    <li class="nav-item">
                                        <a href="#marka" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                            Marka
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#markamodel" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                            Marka-Model
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#kategori" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                            Kategori
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="marka">
                                        <div style="margin:2px;" id="markabutonlari"></div>
                                        <table id="markatablosu" class="table table-responsive-xl table-responsive">
                                            <thead>
                                                <tr>
                                                    <th> Marka ID </th>
                                                    <th> Marka </th>
                                                    <th> Depoda Bulunan Adet </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($markalar as $marka => $sayi) {
                                                    // $markamodel = $vt->ozellistele("SELECT marka.marka, model.model FROM fimy_model model, fimy_marka marka where marka.marka_id=model.marka_id and marka.marka_id={$marka}");
                                                    $markamodel = $vt->listele("fimy_marka", "where marka_id={$marka}");
                                                    if ($markamodel != null) foreach ($markamodel as $mm) {
                                                        $markaAdi = $mm['marka'];
                                                    }
                                                    echo '<tr>
                                                    <td>' . $marka . '</td>
                                                    <td>' . $markaAdi . '</td>
                                                    <td>' . number_format($sayi, 0, '', '.') . '</td>
                                                </tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="markamodel">
                                        <div style="margin:2px;" id="markamodelbutonlari"></div>
                                        <table id="markamodeltablosu" class="table table-responsive-xl table-responsive">
                                            <thead>
                                                <tr>
                                                    <th> Marka </th>
                                                    <th> Model </th>
                                                    <th> Depoda Bulunan Adet </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($modeller as $model => $sayi) {
                                                    $markamodel = $vt->ozellistele("SELECT marka.marka, model.model FROM fimy_model model, fimy_marka marka where marka.marka_id=model.marka_id and model.model_id={$model}");
                                                    if ($markamodel != null) foreach ($markamodel as $mm) {
                                                        $markaAdi = $mm['marka'];
                                                        $modelAdi = $mm['model'];
                                                    }
                                                    echo '<tr>
                                                    <td>' . $markaAdi . '</td>
                                                    <td>' . $modelAdi . '</td>
                                                    <td>' . number_format($sayi, 0, '', '.') . '</td>
                                                </tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="kategori">
                                        <div style="margin:2px;" id="kategoributonlari"></div>
                                        <table id="kategoritablosu" class="table table-responsive-xl table-responsive">
                                            <thead>
                                                <tr>
                                                    <th> Kategori </th>
                                                    <th> Depoda Bulunan Adet </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($kategoriler as $kategori => $sayi) {
                                                    $fimy_kategoriler = $vt->listele("fimy_kategoriler", "WHERE ID={$kategori};");
                                                    if ($fimy_kategoriler != null) foreach ($fimy_kategoriler as $kat) {
                                                        $KategoriAdi = $kat['KategoriAdi'];
                                                    }
                                                    echo '<tr>
                                                    <td>' . $KategoriAdi . '</td>
                                                    <td>' . number_format($sayi, 0, '', '.') . '</td>
                                                </tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- Stok Aktar - Modal -->
            <div class="modal fade" id="stokaktar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myCenterModalLabel">Stok Aktar</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <form id="StokAktarmaFormu" name="StokAktarmaFormu">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="hidden" name="CikisDepoID" id="CikisDepoID" value="<?php echo $DepoID; ?>">
                                            <label class="form-label" for="AliciDepo">Depo <b>(*)</b></label>
                                            <select id="AliciDepo" name="AliciDepo" class="form-select">
                                                <option value="0">Depo Seçiniz..</option>
                                                <?php
                                                $fimy_depolar = $vt->listele("fimy_depolar", "WHERE ID <> {$DepoID}");
                                                if ($fimy_depolar != null) foreach ($fimy_depolar as $depo) {
                                                    echo '<option value="' . $depo['ID'] . '">' . $depo['depo_adi'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="urunID">Ürün <b>(*)</b></label>
                                            <select id="urunID" name="urunID" class="form-select">
                                                <option value="0">Depo Seçiniz..</option>
                                                <?php
                                                $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE bulundugu_depo={$DepoID} ORDER BY ID DESC");
                                                if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $depourun) {
                                                    $fimy_urunler = $vt->listele("fimy_urunler", "WHERE ID={$depourun['UrunID']} ORDER BY ID DESC");
                                                    if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
                                                        echo '<option value="' . $urun['ID'] . '">' . $urun['StokKodu'] . '|' . $urun['urun_adi'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="aktarimAdet">Adet <b>(*)</b></label>
                                            <input type="text" class="form-control" id="aktarimAdet" name="aktarimAdet" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <input type="submit" id="stokeklesubmit" name="stokeklesubmit" class="btn btn-success waves-effect waves-light me-1 col-lg-12" value=">> Stok Aktar">
                                <div id="son"></div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- Aktarım Onayla - Modal -->
            <div class="modal fade" id="aktarimOnaylari" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myCenterModalLabel">Tarafınıza Aktarılan Stoklar</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <div style="margin:2px;" id="dugmelerStokAktarim"></div>
                            <table id="urunStokAktarim" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th> Çıkış Yapan Depo </th>
                                        <th> Çıkış Yapan Personel</th>
                                        <th> Ürün Adı </th>
                                        <th> Stok Miktarı </th>
                                        <th> Onay Durumu </th>
                                        <th> İşlem Tarihi </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fimy_depo_transfer = $vt->listele("fimy_depo_transfer", "WHERE depo_giris_id={$DepoID} ORDER BY ID DESC");
                                    if ($fimy_depo_transfer != null) foreach ($fimy_depo_transfer as $depourun) {
                                        $fimy_depolar = $vt->listele("fimy_depolar", "WHERE ID={$depourun['depo_cikis_id']} ORDER BY ID DESC");
                                        if ($fimy_depolar != null) foreach ($fimy_depolar as $depogo) {
                                            $gonderenDepo = $depogo['depo_adi'];
                                        }
                                        $fimy_urunler = $vt->listele("fimy_urunler", "WHERE ID={$depourun['urun_id']} ORDER BY ID DESC");
                                        if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
                                            if ($depourun['Onay'] == 0) {
                                                $onaybutonu = '<div class="badge bg-danger float-start">
                                                    <a style="color:white;" href="../stok-yonetimi/proccess/aktarim-onayla.php?TransferID=' . $depourun['ID'] . '&Adet=' . $depourun['miktar'] . '&Depo=' . $DepoID . '&UrID=' . $depourun['urun_id'] . '&Onay=0&User=' . $_SESSION['KID'] . '">Onaysız</a>
                                                    </div>';
                                            } else if ($depourun['Onay'] == 1) {
                                                $onaybutonu = '<div class="badge bg-soft-success float-start">
                                                    <a style="color:white;" href="#">Onaylandı</a>
                                                    </div>';
                                            } else {
                                                $onaybutonu = '<div class="badge bg-success float-start">
                                                    <a style="color:white;" href="#">Hata!depodetayfi#003</a>
                                                    </div>';
                                            }
                                            echo '  <tr>
                                                <td>' . $gonderenDepo . '</td>
                                                <td>' . $SorumluAdi . ' ' . $SorumluSoyadi . '</td>
                                                <td>' . $urun['urun_adi'] . '</td>
                                                <td>' . $depourun['miktar'] . '</td>
                                                <td>' . $onaybutonu . '</td>
                                                <td>' . $depourun['proccess_date'] . '</td>
                                                </tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- Duzenle - Modal -->
            <div class="modal fade" id="depoDuzenle" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myCenterModalLabel">Depo Düzenle</h4>
                            <button type="button" class="btn btn-block btn-success col-lg-5" id="depodetayGuncelle"> Güncelle </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="mb-3">
                                        <input type="hidden" id="depoID" value="<?php echo $DepoID; ?>">
                                        <label class="form-label" for="depoadi">Depo Adı <b>(*)</b></label>
                                        <input type="text" class="form-control" id="depoadiupd" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label" for="deposorumlusu">Depo Sorumlusu <b>(*)</b></label>
                                        <select id="deposorumlusuupd" class="form-select">
                                            <option value="0"></option>
                                            <?php
                                            $fimy_menus = $vt->ozellistele("select fu.ID, fu.kullaniciadi from fimy_user fu, fimy_user_access fua where fu.ID=fua.User_ID and fua.Access_Level != 0");
                                            if ($fimy_menus != null) foreach ($fimy_menus as $menu) {
                                                echo '<option value="' . $menu['ID'] . '">' . $menu['kullaniciadi'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label" for="depoadi">Satış Deposu </label>
                                        <div style class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="satisdepoupd" checked>
                                            <label class="form-check-label" for="notice-active">Pasif/Aktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="sonucdepoekle"></div>
                            </div>

                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
            <script>
                $(document).ready(function() {
                    $("#depoadiupd").val("<?php echo $DepoAdi; ?>");
                    $("#deposorumlusuupd").val(<?php echo $SorumID; ?>);
                    $('#satisdepoupd').prop('checked', <?php echo $SatisDeposu; ?>);
                    var urunstoklistesi = $("#urunstoklistesi").DataTable({
                        buttons: ["copy", "excel", "pdf"],
                        "lengthMenu": [50, 100, 150, 250, 300]
                    });
                    urunstoklistesi.buttons().container().appendTo("#dugmeler");

                    var urunStokAktarim = $("#urunStokAktarim").DataTable({
                        buttons: ["excel", "pdf"],
                        "lengthMenu": [25, 100, 150, 250, 300]
                    });
                    urunStokAktarim.buttons().container().appendTo("#dugmelerStokAktarim");

                    var markatablosu = $("#markatablosu").DataTable({
                        buttons: ["excel", "pdf"],
                        "lengthMenu": [15, 100, 150, 250, 300]
                    });
                    markatablosu.buttons().container().appendTo("#markabutonlari");
                    var markamodeltablosu = $("#markamodeltablosu").DataTable({
                        buttons: ["excel", "pdf"],
                        "lengthMenu": [15, 100, 150, 250, 300]
                    });
                    markamodeltablosu.buttons().container().appendTo("#markamodelbutonlari");
                    var kategoritablosu = $("#kategoritablosu").DataTable({
                        buttons: ["excel", "pdf"],
                        "lengthMenu": [15, 100, 150, 250, 300]
                    });
                    kategoritablosu.buttons().container().appendTo("#kategoributonlari");

                    $("#StokAktarmaFormu").submit(function(event) {
                        event.preventDefault();
                        var formData = new FormData(this);
                        $("#stokeklesubmit").prop("disabled", true);
                        $.ajax({
                            url: '../stok-yonetimi/proccess/stok-aktar-proccess.fi',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                // console.log(response);
                                var responses = JSON.parse(response);
                                var refreshCheck = responses[0].refresh;

                                if (refreshCheck == 0) {
                                    toastr[responses[0].status](responses[0].message);
                                    $("#stokeklesubmit").prop("disabled", false);
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
                    $("#depodetayGuncelle").on("click", function() {
                        var depoinfo = 'depoadiupd=' + $("#depoadiupd").val() +
                            '&deposorumlusuupd=' + $("#deposorumlusuupd").val() +
                            '&satisdepoupd=' + $("#satisdepoupd").is(':checked') +
                            '&depoID=' + $("#depoID").val();
                        $.ajax({
                            url: '../stok-yonetimi/proccess/depo-duzenle-process.fi',
                            type: 'POST',
                            data: depoinfo,
                            success: function(e) {
                                $("div#sonucdepoekle").html("").html(e);
                            }
                        });
                    });

                });
            </script>
<?php }
    }
} else {
    echo '<script>
    toastr["error"]("Kasa bilgisi çekilemedi..!");
    setTimeout(function() {
        window.location.href = "./";
    }, 800);
    </script>';
}
include("../src/footer-alt.php"); ?>
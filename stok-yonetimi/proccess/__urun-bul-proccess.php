<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    $count = 0;
    $fimy_urunler = $vt->listele("fimy_urunler", "WHERE barkod='{$barkodNo}' ORDER BY ID DESC");
    if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
        $count++;
    }
    if ($count > 0) {


        //echo $barkodNo;
        $fimy_urunler = $vt->listele("fimy_urunler", "WHERE barkod='{$barkodNo}' ORDER BY ID DESC");
        if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
            $UrunID = $urun['ID'];
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
        <div class="row">


            <div class="col-lg-4">
                <div class="card urunicerigi">
                    <div class="card-header">
                        <center>
                            <h4> <?php echo $urun['urun_adi']; ?> </h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <img style="max-width: 100%; height: auto; object-fit: contain; max-height: 100%;" src="<?php echo $urun['urun_gorseli']; ?>" alt="<?php echo $urun['urun_adi']; ?>" class="urungorseli">

                            </div>
                            <div class="col-lg-12">
                                <center>
                                    <h4 class="mb-0">
                                        <?php $barkod = $urun['barkod'];
                                        if ($barkod != "") {
                                            // $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                            // echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barkod, $generator::TYPE_CODE_128)) . '">';
                                        }
                                        ?>
                                </center>
                                </h4>
                                <p class="text-muted"><?php echo $barkod;  ?></p>
                            </div>
                            <?php
                            $markamodel = $vt->ozellistele("SELECT marka.marka, model.model FROM fimy_model model, fimy_marka marka where marka.marka_id=model.marka_id and marka.marka_id={$urun['marka']} and model.model_id={$urun['model']}");
                            if ($markamodel != null) foreach ($markamodel as $mm) {
                                $marka = $mm['marka'];
                                $model = $mm['model'];
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
                            //$yetkili = $_SESSION['yetki'];
                            $satis_col= 6;
                            if ($yetkili == 0 || $yetkili == 6) {
                                $satis_col= 6;
                            ?>
                                <div class="col-lg-6">
                                    <h4 class="mb-0"><?php echo number_format($BirimFiyati, 2, ',', '.'); ?> $ </h4>
                                    <p class="text-muted">Birim Fiyatı</p>
                                </div>
                            <?php
                            } else {
                                $satis_col= 12;
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
                                    echo "<tr>
                                                      <td>{$bulundugu_depo}</td>
                                                      <td>{$stok_miktari}</td>
                                                      </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="../stok-yonetimi/yeni-siparis.php" class="btn btn-success col-lg-12"> Sipariş Oluştur </a>
                    </div>
                </div>
            </div>
        </div>

<?php
    } else {
        echo "Böyle bir BARKOD mevcut değildir.";
    }
}
?>
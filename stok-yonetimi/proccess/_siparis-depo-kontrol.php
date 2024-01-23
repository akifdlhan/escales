<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    $TeslimeAcKapa = 0;
    $SiparisFormuUrunSayisi = 0;
    echo '<table class="table table-hover table-responsive-lg">';
    echo '<thead>
    <tr>
        <th> Ürün </th>
        <th>  </th>
        <th> Stok Durumu </th>
        <th> Çıkış İşlemi </th>
    </tr>
</thead>
<tbody>';
    $fimy_sf_urun = $vt->listele("fimy_sf_urun", "WHERE SiparisFormID={$SiparisID}");
    if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sfurun) {
        $fimy_siparis_butce = $vt->listele("fimy_siparis_butce", "WHERE SiparisID={$SiparisID}");
        if ($fimy_siparis_butce != null) foreach ($fimy_siparis_butce as $butce) {
            $butceToplam = $butce['GenelToplam'];
        }
        echo '<tr>';
        $SiparisFormuUrunSayisi++;
        $UrunIDS = $sfurun['UrunID'];
        $SiparisFormuAdet = $sfurun['Adet'];
        $fimy_urunler = $vt->listele("fimy_urunler", "WHERE ID={$UrunIDS}");
        if ($fimy_urunler != null) foreach ($fimy_urunler as $urr) {
            $UrunAdi = $urr['urun_adi'];
        }
        $DepoSay = 0;
        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE UrunID={$UrunIDS} and bulundugu_depo={$cikisdepo}");
        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $sd) {
            $DepoStokAdet = $sd['stok_miktari'];
            $DepoSay++;
        }
        if ($DepoSay == 0) {
            echo '<td> ' . $UrunAdi . ' </td>';
            echo '<td>'; ?>
            <?php
            echo '<table style="font-size:8px;">
            <tr>
                                                <th> Depo </th>
                                                <th> Stok Miktarı </th>
                                            </tr>
            ';
            $fimy_urun_stok_depo = $vt->ozellistele("SELECT usd.*, depo.depo_adi FROM fimy_urun_stok_depo usd, fimy_depolar depo WHERE usd.bulundugu_depo=depo.ID and UrunID={$UrunIDS};");
            if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                $bulundugu_depo = $usd['depo_adi'];
                $stok_miktari = $usd['stok_miktari'];

                echo "<tr>
                         <td>{$bulundugu_depo}</td>
                         <td class='text-center'>{$stok_miktari}</td>
                     </tr>";
            }
            echo '</table>';
            ?>
<?php echo ' </td>';
            echo '<td> Depoda Ürün Bulunmamaktadır. </td>';
            echo '<td><span style="font-size: 12px;" class="badge bg-danger rounded-pill col-lg-12"> <i class="mdi mdi-flag text-white"></i> Çıkış Yapılamaz </span></td>';
        } else {
            if ($SiparisFormuAdet > $DepoStokAdet) {
                $EksikStok = $SiparisFormuAdet - $DepoStokAdet;
                echo '<td> ' . $UrunAdi . ' </td>';
                echo '<td>   </td>';
                echo '<td> Depoda yeterli stok bulunmamaktadır, <span style="font-size: 12px;" class="badge bg-danger rounded-pill">' . $EksikStok . '</span> adet ürün eksiktir. </td>';
                echo '<td><span style="font-size: 12px;" class="badge bg-danger rounded-pill col-lg-12"> <i class="mdi mdi-flag text-white"></i> Çıkış Yapılamaz </span></td>';
            } else {
                $TeslimeAcKapa++;
                echo '<td> ' . $UrunAdi . ' </td>';
                echo '<td>  </td>';
                echo '<td> Yeterli Stok Mevcut.';
                echo '<td><span style="font-size: 12px;" class="badge bg-success rounded-pill col-lg-12"> <i class="mdi mdi-share text-white"></i> Çıkış Yapılabilir. </span></td>';
            }
        }
        echo '</tr>';
    }
    echo "</tbody>
    </table>";
    if ($SiparisFormuUrunSayisi == $TeslimeAcKapa) {
        echo "<center> <h4> Sipariş çıkış işlemleri yapılabilir.. </h4> </center>";
        echo '<div class="row">
        <div class="col-lg-3">
        <input type="hidden" id="GenelToplam" value="' . number_format($butceToplam, 2, '.', '') . '">
        <input class="form-control" type="hidden" name="KalanTutar" id="KalanTutar" value="' . number_format($butceToplam, 2, '.', '') . '">
        </div>
    </div><br>';
        echo '<button style="font-size: 16px;" id="siparis-cikart" class="btn btn-success col-lg-12"> <i class="mdi mdi-flag text-white"></i> Siparişin Çıkışını Yap </button>';
    } else {
        echo "<center> <h4>  Yetersiz stok veya hiç bulunmayan ürün olduğundan dolayı çıkış işlemi yapılamaz.. </h4> </center>";
    }
}
?>
<div id="depoCikisYap"></div>
<script>
    $(document).ready(function() {
        $('#onOdeme').mask('00000000000.00', {
            reverse: true
        });
        $("#siparis-cikart").on("click", function() {
            var kontroldataset = 'cikisdepo=<?php echo $cikisdepo; ?>' +
                '&SiparisID=<?php echo $SiparisID; ?>' +
                '&KalanTutar=' + $('#KalanTutar').val();
            $.ajax({
                url: '../stok-yonetimi/proccess/siparis-cikis-yap.fi',
                type: 'POST',
                data: kontroldataset,
                success: function(e) {
                    //console.log(e);
                    //$("div#depoCikisYap").html("").html(e);
                    //window.location.href = "../stok-yonetimi/siparis.fi";
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
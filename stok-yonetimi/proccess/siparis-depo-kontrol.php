<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    $TeslimeAcKapa = 0;
    $SiparisFormuUrunSayisi = 0;
    echo '<div class="col-lg-12" id="toplucikisbutonalani"></div>';
    echo '<table class="table table-hover table-responsive-lg">';
    echo '<thead>
    <tr>
        <th> Ürün </th>
        <th> Adet </th>
        <th>  </th>
        <th> Stok Durumu </th>
        <th> Çıkış Yapılan Depo </th>
        <th> Çıkış İşlemi </th>
    </tr>
</thead>
<tbody>';
    $araBant = 1;
    $topluCikis = "";
    $fimy_sf_urun = $vt->listele("fimy_sf_urun", "WHERE SiparisFormID={$SiparisID} ORDER BY CikisDurumu ASC");
    if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sfurun) {
        $sfID = $sfurun['ID'];
        echo '<tr>';
        $SiparisFormuUrunSayisi++;
        $UrunIDS = $sfurun['UrunID'];
        $SiparisFormuAdet = $sfurun['Adet'];
        $CikisYapilanDepo = $sfurun['CikisYapilanDepo'];
        $CikisDurumu = $sfurun['CikisDurumu'];
        $fimy_urunler = $vt->listele("fimy_urunler", "WHERE ID={$UrunIDS}");
        if ($fimy_urunler != null) foreach ($fimy_urunler as $urr) {
            $UrunAdi = $urr['urun_adi'];
            $StokKodu = $urr['StokKodu'];
            $barkod = $urr['barkod'];
        }

        $DepoSay = 0;
        $DepoSay = $vt->verisay("fimy_urun_stok_depo", "WHERE UrunID={$UrunIDS} and bulundugu_depo={$cikisdepo}");
        $fimy_urun_stok_depo = $vt->listele("fimy_urun_stok_depo", "WHERE UrunID={$UrunIDS} and bulundugu_depo={$cikisdepo}");
        if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $sd) {
            $DepoStokAdet = $sd['stok_miktari'];
        }

        if ($CikisDurumu == 0) { // Ürünlerin hala çıkışı yapılmadıysa.

            if ($DepoSay == 0) {
                echo '<td> ' . $UrunAdi . ' | ' . $StokKodu . ' </td>';
                echo   '<td> ' . $SiparisFormuAdet . ' </td>';
                echo   '<td>';
                echo   '<table style="font-size:8px;">
                <tr>
                    <th> Depo </th>
                    <th> Stok Miktarı </th>
                </tr>';
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
                echo ' </td>';
                echo '<td> Depoda Ürün Bulunmamaktadır. </td>';
                echo '<td> ' . $CikisYapilanDepo . ' </td>';
                echo '<td><span style="font-size: 12px;" class="badge bg-danger rounded-pill col-lg-12"> <i class="mdi mdi-flag text-white"></i> Çıkış Yapılamaz </span></td>';
            } else {
                if ($SiparisFormuAdet > $DepoStokAdet) {
                    $EksikStok = $SiparisFormuAdet - $DepoStokAdet;
                    echo '<td> ' . $UrunAdi . ' | ' . $StokKodu . ' </td>';
                    echo '<td> ' . $SiparisFormuAdet . ' </td>';
                    echo '<td>   </td>';
                    echo '<td> Depoda yeterli stok bulunmamaktadır, <span style="font-size: 12px;" class="badge bg-danger rounded-pill">' . $EksikStok . '</span> adet ürün eksiktir. </td>';
                    echo '<td> ' . $CikisYapilanDepo . ' </td>';
                    echo '<td><span style="font-size: 12px;" class="badge bg-danger rounded-pill col-lg-12"> <i class="mdi mdi-flag text-white"></i> Çıkış Yapılamaz </span></td>';
                } else {
                    $TeslimeAcKapa++;
                    $topluCikis .= $sfID.",";
                    echo '<td> ' . $UrunAdi . ' | ' . $StokKodu . ' </td>';
                    echo  '<td> ' . $SiparisFormuAdet . ' </td>';
                    echo  '<td>  </td>';
                    echo  '<td> Yeterli Stok Mevcut.';
                    echo  '<td> ' . $CikisYapilanDepo . ' </td>';
                    echo '<td><button style="font-size: 12px;" class="badge bg-warning rounded-pill col-lg-12 cikis-yap" data-id="' . $sfurun['ID'] . '"> <i class="mdi mdi-share text-white"></i> Çıkış Yapılabilir. </button></td>';

                }
            }
        } else if ($CikisDurumu == 1) { // Ürünlerin çıkışı yapıldıysa.
            if ($araBant == 1) {
                echo '<tr> 
                 <td class="bg-success text-center" colspan="6"> <h5> Çıkışı Yapılan Ürünler </h5> </td>
                 </tr>';
                $araBant = 0;
            }
            $fimy_depolar = $vt->listele("fimy_depolar", "WHERE ID={$CikisYapilanDepo}");
            if ($fimy_depolar != null) foreach ($fimy_depolar as $dep) {
                $CikisYapilanDepo = $dep['depo_adi'];
            }
            echo '<td> ' . $UrunAdi . ' | ' . $StokKodu .  ' </td>';
            echo '<td> ' . $SiparisFormuAdet . ' </td>';
            echo '<td>  </td>';
            echo '<td>  </td>';
            echo '<td> ' . $CikisYapilanDepo . ' </td>';
            echo '<td><span style="font-size: 12px;" class="badge bg-success rounded-pill col-lg-12"> <i class="mdi mdi-share text-white"></i> Çıkış Yapılmıştır. </span></td>';
        } else {
            // Hatalı çıktı.
        }
        echo '</tr>';
    }
    echo "</tbody>
    </table>";
    $topluCikisButonu = "Bu depo toplu çıkışa uygun ürün mevcut değildir.";
    if(empty($topluCikis)){
        $CikisSay = 0;
    }else{
        $CikisSay = $vt->verisay("fimy_sf_urun", "WHERE ID in (".substr($topluCikis, 0, -1).")");
    }
    if($CikisSay > 0){
        echo '<input type="hidden" name="topluCikisIDs" id="topluCikisIDs" value="'.substr($topluCikis, 0, -1).'">';
        $topluCikisButonu = '<button id="topluCikisYap" class="btn btn-block btn-success col-lg-6"> '.$CikisSay.' Ürünün Çıkışını Yap </button>';
    }
    

    if ($SiparisFormuUrunSayisi == $TeslimeAcKapa) {
    //     echo "<center> <h4> Sipariş çıkış işlemleri yapılabilir.. </h4> </center>";
    //     echo '<div class="row">
    //     <div class="col-lg-3">
    //     <input type="hidden" id="GenelToplam" value="' . number_format($butceToplam, 2, '.', '') . '">
    //     <input class="form-control" type="hidden" name="KalanTutar" id="KalanTutar" value="' . number_format($butceToplam, 2, '.', '') . '">
    //     </div>
    // </div><br>';
    //     echo '<button style="font-size: 16px;" id="siparis-cikart" class="btn btn-success col-lg-12"> <i class="mdi mdi-flag text-white"></i> Siparişin Çıkışını Yap </button>';
    } else {
        echo "<center> <h4>  Yetersiz stok veya hiç bulunmayan ürün olduğundan dolayı çıkış işlemi yapılamaz.. </h4> </center>";
    }
}
?>
<div id="depoCikisYap"></div>
<script>
    $(document).ready(function() {
        $('#toplucikisbutonalani').html('<?php echo $topluCikisButonu; ?>');
        $('#onOdeme').mask('00000000000.00', {
            reverse: true
        });
        //#topluCikisYap
        $('#topluCikisYap').click(function() {
            var sfurunID = $("#topluCikisIDs").val();
            var cikisdepo = $('#cikisdepo').val();
            onylCikisYap = 'UrunSfID=' + sfurunID + '&CikisYapacak=' + cikisdepo;
            $.ajax({
                url: '../stok-yonetimi/proccess/siparis-cikis-yap.fi',
                type: 'POST',
                data: onylCikisYap,
                success: function(e) {
                    //console.log(e);
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
        $('.cikis-yap').click(function() {
            var sfurunID = $(this).data('id');
            var cikisdepo = $('#cikisdepo').val();
            onylCikisYap = 'UrunSfID=' + sfurunID + '&CikisYapacak=' + cikisdepo;
            $.ajax({
                url: '../stok-yonetimi/proccess/siparis-cikis-yap.fi',
                type: 'POST',
                data: onylCikisYap,
                success: function(e) {
                    //console.log(e);
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
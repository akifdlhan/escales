<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_GET) {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $itemsPerPage = 15; // Sayfadaki ürün sayısı

    $start = ($page - 1) * $itemsPerPage;
    $output = "";
    $fimy_urunler = $vt->listele("fimy_urunler", "ORDER BY ID DESC LIMIT $start, $itemsPerPage");
    if ($fimy_urunler != null) foreach ($fimy_urunler as $uruni) {
        $fimy_urun_fiyat = $vt->listele("fimy_urun_fiyat", "WHERE UrunID={$uruni['ID']};");
        if ($fimy_urun_fiyat != null) foreach ($fimy_urun_fiyat as $uf) {
            $BirimFiyati = $uf['BirimFiyati'];
        }
        if ($uruni['urun_gorseli'] == null) {
            $fimy_appoptions = $vt->listele("fimy_appoptions", "WHERE ID=1;");
            if ($fimy_appoptions != null) foreach ($fimy_appoptions as $app) {
                $urunigorseli = $app['Logo'];
            }
        } else {
            $urunigorseli = $uruni['urun_gorseli'];
        }
        
        $output .= '<div class="col-lg-4">';
        $output .= '<span id="' . $uruni['barkod'] . '" class="spanBarkod">';
        $output .= '<div style="border: 4px solid #f7f7f7;" class="card" onclick="updateBarkodNo(\'' . $uruni['barkod'] . '\');">';
        $output .= '<div class="card-body">';
        $output .= '<center>';
        $output .= '<img width="100px" height="50px" src="' . $urunigorseli. '" alt="' . $uruni['urun_adi'] . '">';
        $output .= '</center>';
        $output .= '</div>';
        $output .= '<div class="card-footer"> <center>';
        $output .=  $uruni['StokKodu'] .'|'. $uruni['urun_adi'] . ' | ' . $BirimFiyati . ' TL';
        $output .= '</center></div>';
        $output .= '</div>';
        $output .= '</div>';
    }


    echo $output;
}
?>

<script>
    function updateBarkodNo(barkodNo) {
        //document.getElementById('barkodNo').value = barkodNo;
        $("#barkodNo").val(barkodNo).trigger('input');
    }
</script>
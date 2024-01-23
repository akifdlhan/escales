<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    $alicikasam = $vt->listele("fimy_kasa", "WHERE ID={$alicikasa}");
    if ($alicikasam != null) foreach ($alicikasam as $AK) {
        $ABakiye = $AK['Bakiye'];
        $AKasaAdi = $AK['KasaAdi'];
        $AParaB = $AK['ParaBirimi'];
    }
    $VericiKasam = $vt->listele("fimy_kasa", "WHERE ID={$VericiKasa}");
    if ($VericiKasam != null) foreach ($VericiKasam as $VK) {
        $VBakiye = $VK['Bakiye'];
        $VKasaAdi = $VK['KasaAdi'];
        $VParaB = $VK['ParaBirimi'];
    }
    if ($AParaB == $VParaB) {
        $kurkarsila = $VirmanTutar;
        $readonly = "readonly";
    } else if ($VParaB == 1) {
        $kurkarsila = (float)$VirmanTutar / (float)$kurkarsiligi;
        $kurkarsila = number_format($kurkarsila, 4, ',', '');
        $readonly = "";
    } else {
        $readonly = "";
        if ($kurkarsiligi > 0) {
            $kurkarsila = (float)$kurkarsiligi * (float)$VirmanTutar;
            $kurkarsila = number_format($kurkarsila, 4, ',', '');
        } else {
            $kurkarsila = 1;
        }
    }
}
?>
<h6 class="mg-b-10">Virman Yapılacak Tutar</h6>
<input class="form-control" type="text" name="sontutar" id="sontutar" value="<?php echo $kurkarsila; ?>" <?php echo $readonly; ?>>
<hr>
<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {

    $alicikasa = $vt->listele("fimy_kasa", "WHERE ID={$alicikasa}");
    if ($alicikasa != null) foreach ($alicikasa as $alici) {
        $AliciKasaPb = $alici['ParaBirimi'];
    }

    $vericikasa = $vt->listele("fimy_kasa", "WHERE ID={$KasaID}");
    if ($vericikasa != null) foreach ($vericikasa as $verici) {
        $VericiKasaPb = $verici['ParaBirimi'];
    }

    if ($AliciKasaPb == $VericiKasaPb) {
        echo "";
    } else {
        if ($AliciKasaPb == 1) {
            $icrm_pb = $vt->listele("fimy_parabirimi", "WHERE ID='" . $VericiKasaPb . "'");
            if ($icrm_pb != null) foreach ($icrm_pb as $pb) {
                $exentedpb = $pb['ParaBirimi'];
            }
            $fimy_dovizcifti = $vt->listele("fimy_dovizcifti", "WHERE PB1={$VericiKasaPb}");
            if ($fimy_dovizcifti != null) foreach ($fimy_dovizcifti as $df) {
                $dovizcifti = $df['ID'];
            }
            $fimy_dovizkurlari = $vt->listele("fimy_dovizkurlari", "WHERE DovizID={$dovizcifti}");
            if ($fimy_dovizkurlari != null) foreach ($fimy_dovizkurlari as $dk) {
                $aliskuru = $dk['Alis'];
                $satiskuru = $dk['Satis'];
            }

?>
            <h6 class="mg-b-10">Kur</h6>
            <input class="form-control" type="text" name="kurkarsiligi" id="kurkarsiligi" value="<?php echo $satiskuru; ?>">

        <?php
        } else if ($VericiKasaPb == 1) {
            $fimy_dovizcifti = $vt->listele("fimy_dovizcifti", "WHERE PB1={$AliciKasaPb}");
            if ($fimy_dovizcifti != null) foreach ($fimy_dovizcifti as $df) {
                $dovizcifti = $df['ID'];
            }
            $fimy_dovizkurlari = $vt->listele("fimy_dovizkurlari", "WHERE DovizID={$dovizcifti}");
            if ($fimy_dovizkurlari != null) foreach ($fimy_dovizkurlari as $dk) {
                $aliskuru = $dk['Alis'];
                $satiskuru = $dk['Satis'];
            }
        ?>
            <h6 class="mg-b-10">Kur</h6>
            <input class="form-control" type="text" name="kurkarsiligi" id="kurkarsiligi" value="<?php echo $satiskuru; ?>">
<?php
        } else if ($VericiKasaPb != 1 || $AliciKasaPb != 1) {
            $fimy_dovizcifti = $vt->listele("fimy_dovizcifti", "WHERE PB1={$AliciKasaPb}");
            if ($fimy_dovizcifti != null) foreach ($fimy_dovizcifti as $df) {
                $dovizcifti = $df['ID'];
            }
            $fimy_dovizkurlari = $vt->listele("fimy_dovizkurlari", "WHERE DovizID={$dovizcifti}");
            if ($fimy_dovizkurlari != null) foreach ($fimy_dovizkurlari as $dk) {
                $aliskuru = $dk['Alis'];
                $alicisatiskuru = $dk['Satis'];
            }
            $fimy_dovizciftiv = $vt->listele("fimy_dovizcifti", "WHERE PB1={$VericiKasaPb}");
            if ($fimy_dovizciftiv != null) foreach ($fimy_dovizciftiv as $df) {
                $dovizciftiv = $df['ID'];
            }
            $fimy_dovizkurlari = $vt->listele("fimy_dovizkurlari", "WHERE DovizID={$dovizciftiv}");
            if ($fimy_dovizkurlari != null) foreach ($fimy_dovizkurlari as $dk) {
                $aliskuru = $dk['Alis'];
                $vericisatiskuru = $dk['Satis'];
            }
            $satiskuru = (float)$vericisatiskuru / (float)$alicisatiskuru;
        ?>
            <h6 class="mg-b-10">Kur</h6>
            <input class="form-control" type="text" name="kurkarsiligi" id="kurkarsiligi" value="<?php echo $satiskuru; ?>">
<?php
        }  else {
            echo "Para birimleri farklı dönüştürme olacak";
        }
    }
}

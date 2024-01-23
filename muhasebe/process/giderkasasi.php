<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {

?>
    <div class="col-lg-6">
        <h5 class="text-muted">Kasa</h5>
        <h6 class="mb-0">
            <select id="kasa" name="kasa" class="form-select">
                <option value="0">Kasa</option>
                <?php
                $fimy_kasa = $vt->listele("fimy_kasa");
                if ($fimy_kasa != null) foreach ($fimy_kasa as $ka) {
                    echo '<option value="' . $ka['ID'] . '">' . $ka['KasaAdi'] . '</option>';
                }
                ?>
            </select>
        </h6>
    </div>
<?php

}
?>

<script>
    $("#kasa").select2();
</script>
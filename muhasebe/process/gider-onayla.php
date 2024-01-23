<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {

    $fimy_gider = $vt->listele("fimy_gider", "WHERE ID={$GiderID}");
    if ($fimy_gider != null) foreach ($fimy_gider as $gider) {
        $fimy_user_details = $vt->listele("fimy_user_details", "WHERE User_ID={$gider['Kullanici']}");
        if ($fimy_user_details != null) foreach ($fimy_user_details as $user) {
            $as = $user['Adi'] . " " . $user['Soyadi'];
        }
        $fimy_gidertipi = $vt->listele("fimy_gidertipi", "WHERE ID={$gider['GiderTipi']}");
        if ($fimy_gidertipi != null) foreach ($fimy_gidertipi as $gt) {
            $gtt = $gt['GiderAdi'];
        }
        if ($gider['Kasa'] == 0) {
            $kss = "";
        } else {
            $fimy_kasa = $vt->listele("fimy_kasa", "WHERE ID={$gider['Kasa']}");
            if ($fimy_kasa != null) foreach ($fimy_kasa as $ks) {
                $kss = $ks['KasaAdi'];
            }
        }
        
        echo '
        <div class="row">
            <div class="col-lg-6">
                <div class="col-lg-12">
                    <h4 class="mb-0">' . $as . '</h4>
                    <p class="text-muted">Oluşturan</p>
                </div>
                <div class="col-lg-12">
                    <h4 class="mb-0">' .  date("d.m.Y", strtotime($gider['GiderTarihi'])) . '</h4>
                    <p class="text-muted">Gider Tarihi</p>
                </div>
                <div class="col-lg-12">
                    <h4 class="mb-0">' .  number_format($gider['FaturaTutari'], 2, ',', '.')  . '</h4>
                    <p class="text-muted">Tutarı</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="col-lg-12">
                    <h4 class="mb-0">' . $gider['FaturaSeriNo'] . '</h4>
                    <p class="text-muted">Seri No</p>
                </div>
                <div class="col-lg-12">
                <h4 class="mb-0">' . $gtt .  '</h4>
                <p class="text-muted">Gider Tipi</p>
                </div>
                <div class="col-lg-12">
                    <h4 class="mb-0">
                        <select id="GiderKasa" name="kasa" class="form-select">
                            <option value="0">Kasa</option>';
                            $fimy_kasa = $vt->listele("fimy_kasa","WHERE ParaBirimi=1");
                            if ($fimy_kasa != null) foreach ($fimy_kasa as $ka) {
                                echo '<option value="' . $ka['ID'] . '">' . $ka['KasaAdi'] . '</option>';
                            }
                            echo '
                            <input type="hidden" id="GiderIDOnay" value="'.$gider['ID'].'">
                            <input type="hidden" id="GiderTutarOnay" value="'.$gider['FaturaTutari'].'">
                            <input type="hidden" id="GiderOnayVeren" value="'.$_SESSION['KID'].'">
                        </select>
                    </h4>
                    <p class="text-muted"> Kasa </p>
                </div>
            </div>
        </div>';

    }
}

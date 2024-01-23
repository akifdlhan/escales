<?php
include("../../src/iconlibrary.php");
require '../../src/private_custom.php';
$vt = new veritabani();
$fislash = new fislash();
extract($_POST);
if ($_POST) {
?>
    <table class="table">
        <thead>
            <tr>
                <th> </th>
                <th> Depo </th>
                <th> Stok Miktarı </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $fimy_urun_stok_depo = $vt->ozellistele("SELECT usd.*, depo.depo_adi FROM fimy_urun_stok_depo usd, fimy_depolar depo WHERE usd.bulundugu_depo=depo.ID and usd.ID={$UrunStokDepo};");
            if ($fimy_urun_stok_depo != null) foreach ($fimy_urun_stok_depo as $usd) {
                $bulundugu_depo = $usd['depo_adi'];
                $stok_miktari = $usd['stok_miktari'];
                echo "<tr>
        <td>{$usd['ID']}</td>
        <td>{$bulundugu_depo}</td>
        <td>{$stok_miktari}</td>
    </tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="col-lg-12">
        <p class="text-muted">Yeni Stok Miktarı</p>
        <input type="hidden" id="usdID" value="<?php echo $UrunStokDepo; ?>">
        <input type="hidden" id="UserID" value="<?php echo $UserID; ?>">
        <input type="text" class="form-control" name="StokMiktari" id="StokMiktari" value="<?php echo $stok_miktari; ?>">
    </div>
    <div style="margin: 1px;" class="col-lg-12">
        <button id="StokGuncelle" class="btn btn-block btn-success col-lg-12"> Güncelle </button>
    </div>
    <div style="margin: 1px;" class="col-lg-12">
        <a href="../stok-yonetimi/proccess/stok-depo-sil.php?UserID=<?php echo $UserID; ?>&usdID=<?php echo $UrunStokDepo; ?>" class="btn btn-block btn-danger col-lg-12"> Stok Sil </a>
    </div>
    <script>
        $(document).ready(function() {
            $('#StokMiktari').mask('000000000000', {});

            $("#StokGuncelle").on("click", function() {
                if ($("#StokMiktari").val() <= 0) {
                    toastr["warning"]("Stok Adetini Kontrol Ediniz..");
                } else {
                    var stokinfo = 'usdID=' + $("#usdID").val() + '&StokMiktari=' + $("#StokMiktari").val() + '&UserID=' + $("#UserID").val();
                    $.ajax({
                        url: '../stok-yonetimi/proccess/stok-depo-bazli-proccess.fi',
                        type: 'POST',
                        data: stokinfo,
                        success: function(e) {
                           // console.log(e);
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
                }
            });
        });
    </script>
<?php
}

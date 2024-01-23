<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    // echo $SipForID;
    $fimy_sf_urun = $vt->listele("fimy_sf_urun", "WHERE ID={$SipForID};");
    if ($fimy_sf_urun != null) foreach ($fimy_sf_urun as $sf) {

        $fimy_urun_fiyat = $vt->listele("fimy_urun_fiyat", "WHERE UrunID={$sf['UrunID']};");
        if ($fimy_urun_fiyat != null) foreach ($fimy_urun_fiyat as $uf) {
            $ParaBirimim = $uf['ParaBirimi'];
            $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE ID={$ParaBirimim};");
            if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $pb) {
                $ParaBirimiSimgesi = $pb['Aciklama'];
            }
        }
?>
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="sipforid" id="sipforid" value="<?php echo $SipForID; ?>">
                <input type="hidden" name="urun" id="urun" value="<?php echo $sf['UrunID']; ?>">
                <label class="form-label" for="birimfiyati">Birim Fiyatı</label>
                <div class="input-group mb-3">
                    <input type="text" id="birimfiyati" class="form-control" value="<?php echo number_format($sf['BirimFiyati'], 2, '.', '.'); ?>">
                    <div class="input-group-append">
                        <span class="input-group-text"><?php echo $ParaBirimiSimgesi; ?></span>
                    </div>
                </div><!-- form-group -->
            </div><!-- col-lg-6 -->
            <div class="col-lg-12">
                <div class="form-group mb-3">
                    <label class="form-label" for="urunadet">Adet</label>
                    <input type="text" id="urunadet" class="form-control" value="<?php echo $sf['Adet']; ?>">
                </div><!-- form-group -->
            </div><!-- col-lg-6 -->
            <div class="col-lg-12">
                <label class="form-label" for="araToplam">Ara Toplam</label>
                <div class="input-group mb-3">
                    <input type="text" id="araToplam" class="form-control" value="<?php echo $sf['AraToplam']; ?>">
                    <div class="input-group-append">
                        <span class="input-group-text"><?php echo $ParaBirimiSimgesi; ?></span>
                    </div>
                </div><!-- form-group -->
            </div><!-- col-lg-6 -->
        </div>
<?php
    }
}

?>

<script>
    $('#urunadet').mask('00000000000', {});
    $('#birimfiyati').mask('00000000000.00', {
          reverse: true
        });

    $("#tekrarhesapla").on("click", function() {
        if ($('#birimfiyati').val() == 0 || $('#birimfiyati').val() == "") {
            toastr["warning"]("Lütfen ürünlere ait alanalrı kontrol ediniz..");
        } else {
            var ds = 'urunadet=' + $('#urunadet').val() + '&birimfiyati=' + $('#birimfiyati').val() + '&islemSec=0';
            $.ajax({
                url: '../stok-yonetimi/proccess/urun-birim-fiyat.fi',
                type: 'POST',
                data: ds,
                success: function(e) {
                    var responses = JSON.parse(e);
                    var aratoplam = responses[0].toastrac;
                        if(aratoplam == 0){
                            $("#araToplam").val(responses[0].satisfiyati).trigger('input');
                        }
                   // $("#araToplam").val(e).trigger('input');
                }
            });
        }

    });
    $("#urunadet").on("input", function() {
        var ds = 'urunadet=' + $('#urunadet').val() + '&birimfiyati=' + $('#birimfiyati').val() + '&islemSec=0';
        $.ajax({
            url: '../stok-yonetimi/proccess/urun-birim-fiyat.fi',
            type: 'POST',
            data: ds,
            success: function(e) {
                var responses = JSON.parse(e);
                var stoksayisi = responses[0].stoksayisi;

                var aratoplam = responses[0].toastrac;
                if (aratoplam == 0) {
                    $("#araToplam").val(responses[0].satisfiyati).trigger('input');
                }

            }
        });
    });
    $("#urunadet").on("change", function() {
        var ds = 'urunadet=' + $('#urunadet').val() + '&urun=' + $('#urun').val() + '&birimfiyati=' + $('#birimfiyati').val() + '&islemSec=2';
        $.ajax({
            url: '../stok-yonetimi/proccess/urun-birim-fiyat.fi',
            type: 'POST',
            data: ds,
            success: function(e) {
                console.log(e);
                var responses = JSON.parse(e);
                var urun = responses[0].urun;
                var stoksayisi = responses[0].stoksayisi;
                var urunadeti = $('#urunadet').val();
                // console.log(Dizistoksayisi);
                if (stoksayisi < 0) {
                    $('#urun').val(0).trigger('change');
                    $("#birimfiyati").val("0,00").trigger('input');
                    $("#urunadet").val("0").trigger('input');
                    $("#araToplam").val("0,00").trigger('input');
                    toastr["error"]("Ürün için yeterli stok mevcut değildir..");
                } else {
                    if (stoksayisi >= urunadeti) {
                        stoksayisimiz = stoksayisi - urunadeti;
                        toastr["warning"]("Tüm depolarda kullanılabilir " + stoksayisimiz + " adet ürün mevcuttur.");
                        $("#birimfiyati").val(responses[0].satisfiyati).trigger('input');
                    } else if (stoksayisi == 0) {
                        $("#birimfiyati").val("0,00").trigger('input');
                        $("#urunadet").val("0").trigger('input');
                        $("#araToplam").val("0,00").trigger('input');
                        toastr["error"]("Ürün için yeterli stok mevcut değildir..");
                    } else {
                        $("#birimfiyati").val("0,00").trigger('input');
                        $("#urunadet").val("0").trigger('input');
                        $("#araToplam").val("0,00").trigger('input');
                        toastr["error"]("Ürün için yeterli stok mevcut değildir..");
                    }
                    // toastr["warning"]("Tüm depolarda " + responses[0].stoksayisi + " adet ürün mevcuttur.");
                    // $("#birimfiyati").val(responses[0].satisfiyati).trigger('input');
                }
                // $("#birimfiyati").val(e).trigger('input');

            }
        });
    });
</script>
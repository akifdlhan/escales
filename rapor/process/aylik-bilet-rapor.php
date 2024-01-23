<?php
session_start();
ob_start();
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
      $BugununTarihi = $bitis;
      $OncesiTarih = $baslangic;
      $BugununTarihi = date($bitis." 23:59:59");
      $OncesiTarih = date($baslangic." 00:00:00");
      $before = $BugununTarihi;
      $after = $OncesiTarih;
?>

      <div class="row">
            <h5 class="text-center"> <?php echo $after . " - " . $before . " Tarihleri Arasına Ait Hareketler"; ?> </h5>
            <?php
            $BiletlerOzet = $vt->ozellistele("SELECT COUNT(bb.ID) as biletsayisi, sum(bo.KomisyonTutari) as komisyontoplam, sum(bo.TotalUcret) as toplam FROM fimy_biletodeme bo, fimy_biletbilgisi bb, fimy_aracifirma af
                                        WHERE bo.BiletID=bb.ID
                                        and bb.AraciFirma=af.ID
                                        and bo.Proccess_Date > '" . $after . "' and bo.Proccess_Date <= '" . $before . "';");
            if ($BiletlerOzet != null) foreach ($BiletlerOzet as $bb) {
                  $biletsayisi = $bb['biletsayisi'];
                  $komisyontoplam = $bb['komisyontoplam'];
                  $toplam = $bb['toplam'];
            }
            ?>
            <div class="col-lg-4 text-center">
                  <h4>Toplam Bilet Sayısı</h4>
                  <h4> <?php echo $biletsayisi; ?> </h4>
            </div>
            <div class="col-lg-4 text-center">
                  <h4>Toplam Bilet Tutarı</h4>
                  <h4> <?php echo number_format($toplam, 2, ',', '.'); ?> </h4>
            </div>
            <div class="col-lg-4 text-center">
                  <h4>Toplam Komisyon Tutarı</h4>
                  <h4> <?php echo number_format($komisyontoplam, 2, ',', '.'); ?> </h4>
            </div>
      </div>
      <div class="table-responsive">
            <table id="aylikbilet" class="table mg-b-0">
                  <thead>
                        <tr>
                              <th>Oluşturma Tarihi</th>
                              <th>FiPNR</th>
                              <th>Yolcu</th>
                              <th>Komisyon</th>
                              <th>Total Ücret</th>
                              <th>Ödeme Yöntemi</th>
                              <th>Firma</th>
                              <th>İşlemler</th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php
                        $Biletler = $vt->ozellistele("SELECT fb.ID, fb.FiPNR, fb.Proccess_Date, fu.PNR, fu.Tarih, fy.Adi, fy.Soyadi, fbi.KomisyonTutari, fbi.TotalUcret, fbi.OdemeYontemi, faf.Firma
                                                FROM fimy_biletbilgisi fb, fimy_ucus fu, fimy_yolcu fy, fimy_biletodeme fbi, fimy_aracifirma faf
                                                where fu.ID=fb.UcusID and fy.ID = fb.YolcuID and fb.ID=fbi.BiletID and faf.ID=fb.AraciFirma
                                                and fbi.Proccess_Date > '" . $after . "' and fbi.Proccess_Date <= '" . $before . "';");
                        if ($Biletler != null) foreach ($Biletler as $bilet) {
                              $odeme = "";
                              if ($bilet['OdemeYontemi'] == 1) {
                                    $odeme = "Nakit";
                              } else if ($bilet['OdemeYontemi'] == 2) {
                                    $odeme = "Kredi Kartı(Firma)";
                              } else if ($bilet['OdemeYontemi'] == 3) {
                                    $odeme = "Havale/EFT";
                              } else if ($bilet['OdemeYontemi'] == 4) {
                                    $odeme = "Kredi Kartı(Müşteri)";
                              } else if ($bilet['OdemeYontemi'] == 5) {
                                    $odeme = "Borç";
                              }
                              echo '<tr>
                                                        <td>' . date("d.m.Y H:i", strtotime($bilet['Proccess_Date'])) . '</td>
                                                        <td>' . $bilet['FiPNR'] . '</td>
                                                        <td>' . $bilet['Adi'] . ' ' . $bilet['Soyadi'] . '</td>
                                                        <td>' . number_format($bilet['KomisyonTutari'], 2, ',', '.') . ' ₺</td>
                                                        <td>' . number_format($bilet['TotalUcret'], 2, ',', '.') . ' ₺</td>
                                                        <td>' . $odeme . '</td>
                                                        <td>' . $bilet['Firma'] . '</td>
                                                        <td><a href="bilet-detay.php?ID=' . $bilet['ID'] . '">Detay</a>
                                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Ödeme Al</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Durum Güncelle</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">İptal Et</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Düzenle</a>
                                            </div>
                                        </div>
                                                        </td>
                                                        </tr>';
                        }
                        ?>

                  </tbody>
            </table>
      </div><!-- table-responsive -->

<?php
}
?>
<script>
        $(document).ready(function() {
            var aylikbilet = $("#aylikbilet").DataTable({
                lengthChange: !1,
                buttons: ["copy", "excel", "pdf"],
                "lengthMenu": [50, 100, 150, 250, 300]
            });
            aylikbilet.buttons().container().appendTo("#aylikbilet_wrapper .col-md-6:eq(0)");
        });
    </script>
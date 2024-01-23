<?php
session_start();
ob_start();
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
      $BugununTarihi = $bitis;
      $OncesiTarih = $baslangic;
      $BugununTarihi = date($bitis . " 23:59:59");
      $OncesiTarih = date($baslangic . " 00:00:00");
      $before = $BugununTarihi;
      $after = $OncesiTarih;
?>

      <thead>
            <tr>
                  <th> Kullanıcı </th>
                  <th> Kayıt Adeti </th>
                  <th> Toplam </th>
            </tr>
      </thead>
      <?php

      $gider = $vt->ozellistele("SELECT us.kullaniciadi, COUNT(gd.ID) as toplam, SUM(FaturaTutari) as toplamt
                                FROM fimy_gider gd, fimy_user us
                                WHERE us.ID=gd.Kullanici
                                and gd.ProccessDate > '" . $after . "' and gd.ProccessDate <= '" . $before . "'
                                and gd.Onay=1 GROUP by gd.Kullanici;");
      if ($gider != null) foreach ($gider as $g) {
            echo '
                                        <tr>
                                            <td> ' . $g['kullaniciadi'] . ' </td>
                                            <td> ' . $g['toplam'] . ' </td>
                                            <td> ' . number_format($g['toplamt'], 2, ',', '.') . ' ₺ </td>
                                        </tr>';
      }
      ?>
<?php
}
?>
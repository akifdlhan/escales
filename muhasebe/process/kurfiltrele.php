<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
  include("../../src/HaremGuncelle.php");
  $VarmıYokmu = 0;
  $fimy_dovizcifti = $vt->listele("fimy_dovizcifti", "WHERE PB1={$parabirimi}");
  if ($fimy_dovizcifti != null) foreach ($fimy_dovizcifti as $df) {
    $dovizcifti = $df['ID'];
    $VarmıYokmu++;
  }
  if ($VarmıYokmu > 0) {
    $fimy_dovizkurlari = $vt->listele("fimy_dovizkurlari", "WHERE DovizID={$dovizcifti}");
    if ($fimy_dovizkurlari != null) foreach ($fimy_dovizkurlari as $dk) {
      $aliskuru = $dk['Alis'];
      $satiskuru = $dk['Satis'];
    }

?>
    <table style="text-align:center;" class="table mg-b-0">
      <tr>
        <th> Alış </th>
        <th> Satış </th>
      </tr>
      <tr>
        <td> <?php echo $aliskuru; ?> </td>
        <td> <?php echo $satiskuru; ?> </td>
      </tr>
    </table>

<?php
  }
}
?>
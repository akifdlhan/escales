<?php include("../src/access.php");
if ($_GET) {
  $KasaID = $_GET['KasaID'];
  $fimy_kasa = $vt->listele("fimy_kasa", "WHERE ID={$KasaID}");
  if ($fimy_kasa != null) foreach ($fimy_kasa as $kasalar) {
    $KasaID = $kasalar['ID'];
    $Bakiye = $kasalar['Bakiye'];

    echo '<script>
        newTitle="' . $kasalar['KasaAdi'] . ' | ' . $_SESSION['Firma'] . '";
        document.title = newTitle;
        document.getElementById("page-title-main").innerHTML = "' . $kasalar['KasaAdi'] . '";
        </script>';
    $KPB = $kasalar['ParaBirimi'];
    $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE ID='" . $KPB . "'");
    if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $pb) {
      $exentedpb = $pb['ParaBirimi'];
      $DovizID = $pb['DovizID'];
    }

    if( $Bakiye > 0){
      echo '<script>
    toastr["error"]("Kasada Bakiye olduğundan dolayı silinememiştir..!");
    setTimeout(function() {
        window.location.href = "../";
    }, 800);
    </script>';

    }else{
      $sil = $vt->sil("fimy_kasa","ID={$KasaID}");
      if($sil > 0){
        echo '<script>
        toastr["success"]("Kasa başarıyla kaldırılmıştır..!");
        setTimeout(function() {
            window.location.href = "../";
        }, 800);
        </script>';
      }
    }


  }
} else {
  include("../src/footer-alt.php");
  echo '<script>
    toastr["error"]("Kasa bilgisi çekilemedi..!");
    setTimeout(function() {
        window.location.href = "../";
    }, 800);
    </script>';
}
include("../src/footer-alt.php"); ?>
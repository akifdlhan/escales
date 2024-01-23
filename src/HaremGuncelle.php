<?php


if ($_GET) {
  if (@$_GET['DovizKurGuncelle']) {
    session_start();
    ob_start();
    include("iconlibrary.php");
    $vt = new veritabani();


    $tarih = date("Y-m-d H:i:s");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.haremaltin.com/ajax/all_prices');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'X-Requested-With: XMLHttpRequest'
    ));
    $server_output = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    // echo $httpCode;
    $x = json_decode($server_output, true);
    if ($httpCode == 200) {
      //print_r($x['data']);
      $sorgu = $vt->listele("fimy_dovizcifti", "WHERE Entegrasyon=1");
      if ($sorgu != null) foreach ($sorgu as $satir) {
        $DA = $satir['DovizAdi'];
        $ID = $satir['ID'];
        $Alis = $x['data'][$DA]['alis'];
        $Satis = $x['data'][$DA]['satis'];
        $guncelle = $vt->guncelle("fimy_dovizkurlari", array("Alis" => $Alis, "Satis" => $Satis, "Tarih" => $tarih), "DovizID={$ID}");
      }
    } else {
      echo '<script> console.log("HaremAltın üzerinden doviz bilgisi güncellenemedi.. (Hata: '.$httpCode.')"); </script>';
    }


?>

    <?php
    $SayAlma = $vt->ozellistele("select count(ID) as Sayisi from fimy_dovizcifti WHERE Entegrasyon=1");
    if ($SayAlma != null) foreach ($SayAlma as $s) {
      $KayitSayisi =  $s['Sayisi'];
    }
    $ColLgCount = 12 / $KayitSayisi;
    $dc = $vt->listele("fimy_dovizcifti", "WHERE Entegrasyon=1");
    if ($dc != null) foreach ($dc as $d) {
      $fimy_dovizkurlari = $vt->listele("fimy_dovizkurlari", "WHERE DovizID={$d['ID']}");
      if ($fimy_dovizkurlari != null) foreach ($fimy_dovizkurlari as $dk) {
        //fimy_dovizkurlari
        $DovizAdi = $d['DovizAdi'];
        $Alis = $dk['Alis'];
        $Satis = $dk['Satis'];
        $Tarih = $dk['Tarih'];
    ?>
        <div class="col-xl-<?php echo $ColLgCount; ?> col-md-6">
          <div class="card">
            <div class="card-body widget-user">
              <div class="row">
                <div class="col-lg-6">
                  <div class="text-center">
                    <h2 class="fw-normal text-primary" data-plugin="counterup"><?php echo $Alis; ?></h2>
                    <h5>Alış</h5>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="text-center">
                    <h2 class="fw-normal text-primary" data-plugin="counterup"><?php echo $Satis; ?></h2>
                    <h5>Satış</h5>
                  </div>
                </div>
                <h5 class="text-center"><?php echo $DovizAdi; ?></h5>
              </div>
            </div>
          </div>
        </div>
    <?php
      }
    }
    ?>
<?php
  } else {

    $tarih = date("Y-m-d H:i:s");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.haremaltin.com/ajax/all_prices');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'X-Requested-With: XMLHttpRequest'
    ));
    $server_output = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    //echo $server_output;
    // $httpCode;
    if ($httpCode == 200) {
      $x = json_decode($server_output, true);
      //print_r($x['data']);
      $sorgu = $vt->listele("fimy_dovizcifti", "WHERE Entegrasyon=1");
      if ($sorgu != null) foreach ($sorgu as $satir) {
        $DA = $satir['DovizAdi'];
        $ID = $satir['ID'];
        $Alis = $x['data'][$DA]['alis'];
        $Satis = $x['data'][$DA]['satis'];
        $guncelle = $vt->guncelle("fimy_dovizkurlari", array("Alis" => $Alis, "Satis" => $Satis, "Tarih" => $tarih), "DovizID={$ID}");
      }
    } else {
      echo '<script> console.log("HaremAltın üzerinden doviz bilgisi güncellenemedi.."); </script>';
    }
  }
} else {
  $tarih = date("Y-m-d H:i:s");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://www.haremaltin.com/ajax/all_prices');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-Requested-With: XMLHttpRequest'
  ));

  $server_output = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  if ($httpCode == 200) {
    $x = json_decode($server_output, true);
    //print_r($x['data']);
    $sorgu = $vt->listele("fimy_dovizcifti", "WHERE Entegrasyon=1");
    if ($sorgu != null) foreach ($sorgu as $satir) {
      $DA = $satir['DovizAdi'];
      $ID = $satir['ID'];
      $Alis = $x['data'][$DA]['alis'];
      $Satis = $x['data'][$DA]['satis'];
      $guncelle = $vt->guncelle("fimy_dovizkurlari", array("Alis" => $Alis, "Satis" => $Satis, "Tarih" => $tarih), "DovizID={$ID}");
    }
  }else {
    echo '<script> console.log("HaremAltın üzerinden doviz bilgisi güncellenemedi.. (Hata: '.$httpCode.')"); </script>';
  }
}


?>
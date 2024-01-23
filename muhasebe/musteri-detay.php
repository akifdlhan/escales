<?php
include("../src/access.php");
if ($_GET) {
  if ($_GET['MusteriID']) {
    $MusteriID = $_GET['MusteriID'];

    $fimy_cari_hesap = $vt->listele("fimy_cari_hesap", "WHERE ID={$MusteriID}");
    if ($fimy_cari_hesap != null) foreach ($fimy_cari_hesap as $carihesap) {

      echo '<script>
                                newTitle="' . $carihesap['Adi'] . " " . $carihesap['Soyadi'] . ' | ' . $_SESSION['Firma'] . '";
                                document.title = newTitle;
                                document.getElementById("page-title-main").innerHTML = "' . $carihesap['Adi'] . " " . $carihesap['Soyadi'] . '";
                                </script>';


      //  1- Borc 2- Alacak
      (float)$Borc = 0;
      (float)$Alacak = 0;
      // SELECT ba.*, pb.ParaBirimi FROM fimy_borc_alacak ba, fimy_parabirimi pb WHERE MID=59 AND BorcAlacak=1 AND pb.ID=ba.ParaBirimi;
      $fimy_borc_alacak = $vt->listele("fimy_borc_alacak", "WHERE MID='" . $MusteriID . "'");
      if ($fimy_borc_alacak != null) foreach ($fimy_borc_alacak as $ba) {
        $BorcAlacak = $ba['BorcAlacak'];
        if ($BorcAlacak == 1) {
          $Borc = (float)$ba['Tutar'];
        }
        if ($BorcAlacak == 2) {
          $Alacak = (float)$ba['Tutar'];
        }
      }
      (float)$Bakiye = 0;
      $fimy_cari_hesapkarti = $vt->listele("fimy_cari_hesapkarti", "WHERE PID='" . $MusteriID . "'");
      if ($fimy_cari_hesapkarti != null) foreach ($fimy_cari_hesapkarti as $mk) {
        $Bakiye = $mk['TotalBakiye'];
      }
    }

?>
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
      <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">

          <div class="row">
            <style>
              /* Sadece kenarlığa sahip siyah yazı */
              .red-outlined-text {
                color: red;
              }

              .laci-outlined-text {
                color: #0e2d67;
              }

              .green-outlined-text {
                color: green;
              }
            </style>
            <!-- Start lg-4-->
            <div class="col-lg-4">
              <div class="card">
                <div style="margin-bottom:-20px;" class="card-title">
                  <center>
                    <h3> Borç </h3>
                  </center>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div style="margin-right:-10px;" class="col-lg-6">
                      <center>
                        <i style="font-size:62px;color:#0e2d67;" class="ti-credit-card"></i>
                      </center>
                    </div>
                    <div style="margin-top:8px;margin-left:-22px;" class="col-lg-6">
                      <center>
                        <?php
                        (float)$Borc = 0;
                        (float)$Alacak = 0;
                        // SELECT ba.*, pb.ParaBirimi FROM fimy_borc_alacak ba, fimy_parabirimi pb WHERE MID=" . $MusteriID . " AND BorcAlacak=1 AND pb.ID=ba.ParaBirimi;
                        $fimy_borc_alacak = $vt->ozellistele("SELECT ba.*, pb.ParaBirimi FROM fimy_borc_alacak ba, fimy_parabirimi pb WHERE MID='" . $MusteriID . "' AND BorcAlacak=1 AND pb.ID=ba.ParaBirimi");
                        if ($fimy_borc_alacak != null) foreach ($fimy_borc_alacak as $ba) {
                          $BorcAlacak = $ba['BorcAlacak'];
                          $Borc = (float)$ba['Tutar'];
                          echo '<h3 class="red-outlined-text">' . number_format($Borc, 2, ',', '.') . " " . $ba['ParaBirimi'] . "</h3>";
                        }
                        ?>
                      </center>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End lg-4-->
            <!-- Start lg-4-->
            <div class="col-lg-4">
              <div class="card">
                <div style="margin-bottom:-20px;" class="card-title">
                  <center>
                    <h3> Alacak </h3>
                  </center>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div style="margin-right:-10px;" class="col-lg-6">
                      <center>
                        <i style="font-size:62px;color:#0e2d67;" class="ti-credit-card"></i>
                      </center>
                    </div>
                    <div style="margin-top:8px;margin-left:-22px;" class="col-lg-6">
                      <center>
                        <?php
                        (float)$Borc = 0;
                        (float)$Alacak = 0;
                        // SELECT ba.*, pb.ParaBirimi FROM fimy_borc_alacak ba, fimy_parabirimi pb WHERE MID=" . $MusteriID . " AND BorcAlacak=1 AND pb.ID=ba.ParaBirimi;
                        $fimy_borc_alacak = $vt->ozellistele("SELECT ba.*, pb.ParaBirimi FROM fimy_borc_alacak ba, fimy_parabirimi pb WHERE MID='" . $MusteriID . "' AND BorcAlacak=2 AND pb.ID=ba.ParaBirimi");
                        if ($fimy_borc_alacak != null) foreach ($fimy_borc_alacak as $ba) {
                          $BorcAlacak = $ba['BorcAlacak'];
                          $Alacak = (float)$ba['Tutar'];
                          echo '<h3 class="blue-outlined-text">' . number_format($Alacak, 2, ',', '.') . " " . $ba['ParaBirimi'] . "</h3>";
                        }
                        ?>
                      </center>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End lg-4-->
            <!-- Start lg-4-->
            <div class="col-lg-4">
              <div class="card">
                <div style="margin-bottom:-20px;" class="card-title">
                  <center>
                    <h3> Toplam Alınan Ödemeler </h3>
                  </center>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div style="margin-right:-10px;" class="col-lg-6">
                      <center>
                        <i style="font-size:62px;color:#0e2d67;" class="ti-credit-card"></i>
                      </center>
                    </div>
                    <div style="margin-top:8px;margin-left:-22px;" class="col-lg-6">
                      <center>
                      <?php
                        (float)$Borc = 0;
                        (float)$Alacak = 0;
                        // SELECT ba.*, pb.ParaBirimi FROM fimy_borc_alacak ba, fimy_parabirimi pb WHERE MID=" . $MusteriID . " AND BorcAlacak=1 AND pb.ID=ba.ParaBirimi;
                        $fimy_cari_hesapkarti = $vt->ozellistele("SELECT ba.*, pb.ParaBirimi FROM fimy_cari_hesapkarti ba, fimy_parabirimi pb WHERE PID='" . $MusteriID . "' AND pb.ID=ba.ParaBirimi");
                        if ($fimy_cari_hesapkarti != null) foreach ($fimy_cari_hesapkarti as $hk) {
                          echo '<h3 class="green-outlined-text">' . number_format($hk['TotalBakiye'], 2, ',', '.') . " " . $hk['ParaBirimi'] . "</h3>";
                        }
                        ?>
                      </center>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End lg-4-->
          </div>
          <!-- end row -->
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div style="margin-bottom:5px;" class="col-lg-3">
                    <center>
                      <a data-animation="fadein" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a" data-bs-toggle="modal" data-bs-target="#BorcModal" style="color:white; width: 150px;" class="btn btn-warning">Borçlandır <i style="font-size:20px" class="fe-file-plus"></i></a>
                    </center>
                  </div>
                  <div style="margin-bottom:5px;" class="col-lg-3">
                    <center>
                      <a style="width: 150px;" data-bs-toggle="modal" data-bs-target="#AlacakModal" class="btn btn-danger">Alacaklandır <i style="font-size:20px" class="fe-file-minus"></i></a>
                    </center>
                  </div>
                  <div style="margin-bottom:5px;" class="col-lg-3">
                    <center>
                      <a style="width: 150px;" data-bs-toggle="modal" data-bs-target="#OdemeYap" class="btn btn-dark">Ödeme Yap <i style="font-size:20px" class="fe-log-out"></i></a>
                    </center>
                  </div>
                  <div style="margin-bottom:5px;" class="col-lg-3">
                    <center>
                      <a style="width: 150px;" data-bs-toggle="modal" data-bs-target="#OdemeAl" class="btn btn-info">Ödeme Al <i style="font-size:20px" class="fe-log-in"></i></a>
                    </center>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end col-lg-12 -->
          <style>
            .col-lg-center {
              text-align: center;
            }
          </style>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="row col-lg-center">
                  <div class="col-lg-4">
                    <h4 class="mb-0"><?php echo $carihesap['TC']; ?></h4>
                    <p class="text-muted">TC No</p>
                  </div>
                  <div class="col-lg-4">
                    <h4 class="mb-0">
                      <?php echo $carihesap['Adi'] . " " . $carihesap['Soyadi']; ?></h4>
                    <p class="text-muted">Adı Soyadı</p>
                  </div>
                  <div class="col-lg-4">
                    <h4 class="mb-0"><?php echo $carihesap['Mail']; ?></h4>
                    <p class="text-muted">Mail</p>
                  </div>
                  <div class="col-lg-4">
                    <h4 class="mb-0"><?php echo $carihesap['Tel']; ?></h4>
                    <p class="text-muted">Telefon</p>
                  </div>
                  <div class="col-lg-4">
                    <h4 class="mb-0"><?php
                                      if ($carihesap['Kurumsal'] == 1) {
                                        $kurumsal = "Kurumsal";
                                      } else {
                                        $kurumsal = "Bireysel";
                                      }
                                      echo $kurumsal;
                                      ?></h4>
                    <p class="text-muted">Hesap Tipi</p>
                  </div>
                  <div class="col-lg-4">
                    <h4 class="mb-0"><?php $kt = new DateTime($carihesap['Olusturma']);
                                      echo $kt->format('d.m.Y H:i'); ?></h4>
                    <p class="text-muted">Oluşturma Tarihi</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
          if ($carihesap['Kurumsal'] == 1) {
            $sorgu = "SELECT ck.FirmaAdi, fvd.VergiDairesi, ck.VergiNo FROM fimy_cari_kurumsal ck, fimy_cari_hesap ch, fimy_vergidairesi fvd where ck.CariID=ch.ID and ck.VergiDairesi=fvd.ID and ck.CariID=" . $carihesap['ID'] . ";";
            $fimy_cari_kurumsal = $vt->ozellistele($sorgu);
            if ($fimy_cari_kurumsal != null) foreach ($fimy_cari_kurumsal as $ck) {
            }
          ?>
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div style="position: absolute; top: 0; left: 0; background-color: #ff5b5b; color: white; padding: 5px; font-family:roboto;">
                    Kurumsal
                  </div>
                  <div class="row col-lg-center">
                    <div class="col-lg-4">
                      <h4 class="mb-0"><?php echo $ck['FirmaAdi']; ?></h4>
                      <p class="text-muted">Firma Adı</p>
                    </div>
                    <div class="col-lg-4">
                      <h4 class="mb-0">
                        <?php echo $ck['VergiDairesi']; ?></h4>
                      <p class="text-muted">Vergi Dairesi</p>
                    </div>
                    <div class="col-lg-4">
                      <h4 class="mb-0"><?php echo $ck['VergiNo']; ?></h4>
                      <p class="text-muted">Vergi No</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php

          } else {
          }
          ?>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="col-lg-12">
                  <center>
                    <h5>
                      Ödeme Hareketleri
                    </h5>
                  </center>
                </div>
                <div class="table-responsive">
                  <table class="table mg-b-0">
                    <thead>
                      <tr>
                        <th>Al - Ver</th>
                        <th>Tutar</th>
                        <th>Kasa Adı</th>
                        <th>Para Birimi</th>
                        <th>Kur</th>
                        <th>TL Karşılığı</th>
                        <th>Açıklama</th>
                        <th>Tarih</th>
                        <th> </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $icrm_bahareket = $vt->listele("fimy_m_odemehareket", "WHERE MID={$MusteriID} ORDER BY ID DESC LIMIT 5");
                      if ($icrm_bahareket != null) foreach ($icrm_bahareket as $bah) {
                        $Tur = "";
                        if ($bah['AlVer'] == 1) {
                          $Tur = "Ödeme Yapıldı";
                        } else if ($bah['AlVer'] == 2) {
                          $Tur = "Ödeme Alındı";
                        } else {
                          $Tur = "SystemErrorICON_OdemeListeme228";
                        }
                        $KA = $bah['KasaID'];
                        $PB = $bah['PBID'];
                        $icrm_kasalar = $vt->listele("fimy_kasa", "WHERE ID='" . $KA . "'");
                        if ($icrm_kasalar != null) foreach ($icrm_kasalar as $f) {
                          $KasaAdi = $f['KasaAdi'];
                        }
                        $icrm_pb = $vt->listele("fimy_parabirimi", "WHERE ID='" . $PB . "'");
                        if ($icrm_pb != null) foreach ($icrm_pb as $pb) {
                          $exentedpb = $pb['Aciklama'];
                        }
                      ?>
                        <tr>
                          <td><?php echo $Tur; ?></td>
                          <td><?php echo number_format($bah['Tutar'], 2, ',', '.')." ".$exentedpb; ?>  </td>
                          <td><?php echo $KasaAdi; ?></td>
                          <td><?php echo $exentedpb; ?></td>
                          <td><?php echo number_format($bah['Kur'], 5, ',', '.'); ?> TL </td>
                          <td> <?php echo number_format(($bah['Tutar'] * $bah['Kur']), 2, ',', '.'); ?> TL </td>
                          <td><?php echo $bah['Aciklama']; ?></td>
                          <td><?php $kt = new DateTime($bah['Tarih']);
                              echo $kt->format('d.m.Y H:i'); ?></td>
                          <?php
                          if ($bah['AlVer'] == 1) {
                            echo '<td></td>';
                          } else if ($bah['AlVer'] == 2) {
                          ?>
                            <td> <a target="_blank" href="../muhasebe/odeme-makbuzu.fi?OdemeNo=<?php echo $bah['ID']; ?>" style="font-size:10px;" class="btn btn-info"> Makbuz </a> </td>
                          <?php
                          } else {
                            $Tur = "SystemErrorICON_OdemeListeme228";
                          }
                          ?>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div><!-- table-responsive -->

              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="col-lg-12">
                  <center>
                    <h5>
                      Borç - Alacak Hareketleri
                    </h5>
                  </center>
                </div>
                <div class="table-responsive">
                  <table class="table mg-b-0">
                    <thead>
                      <tr>
                        <th>Borç - Alacak</th>
                        <th>Tutar</th>
                        <th>Kur</th>
                        <th>TL Karşılığı</th>
                        <th>Açıklama</th>
                        <th>Tarih</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $icrm_bahareket = $vt->listele("fimy_ba_hareket", "WHERE MID={$MusteriID} ORDER BY ID DESC LIMIT 5");
                      if ($icrm_bahareket != null) foreach ($icrm_bahareket as $bah) {
                        $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE Aktif=1 and ID={$bah['ParaBirimi']}");
                        if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $pb) {
                          $ParaBirimi = $pb['ParaBirimi'];
                        }
                        $Tur = "";
                        if ($bah['BorcAlacak'] == 1) {
                          $Tur = "Borç";
                        } else if ($bah['BorcAlacak'] == 2) {
                          $Tur = "Alacak";
                        } else {
                          $Tur = "SystemErrorICON";
                        }
                      ?>
                        <tr>
                          <td><?php echo $Tur; ?></td>
                          <td><?php echo number_format($bah['Tutar'], 2, ',', '.')." ".$ParaBirimi; ?> </td>
                          <td><?php echo number_format($bah['Kur'], 5, ',', '.'); ?> TL </td>
                          <td><?php echo number_format(($bah['Tutar'] * $bah['Kur']), 2, ',', '.'); ?> TL </td>
                          <td><?php echo $bah['Aciklama']; ?></td>
                          <td><?php $kt = new DateTime($bah['Tarih']);
                              echo $kt->format('d.m.Y H:i'); ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div><!-- table-responsive -->


              </div>
            </div>
          </div>



        </div> <!-- container -->

      </div> <!-- content -->

      <!-- ============================================================== -->
      <!-- End Page content -->
      <!-- ============================================================== -->
      <!-- Borclandir -->
      <div id="BorcModal" class="modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <h4> Borç Girişi </h4>
              <small> </small>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                </div>
                <input type="hidden" id="MusID" value="<?php echo $MusteriID; ?>">
                <select class="form-control" name="parabirimi" id="parabirimi">
                <option value="0"> Para Birimi </option>
                  <?php
                  $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE Aktif=1");
                  if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $pb) {
                    echo '<option value="' . $pb['ID'] . '">' . $pb['ParaBirimi'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" class="form-control" placeholder="0000.00" id="TutarB">
              </div>
              <div id="varsakur" class="input-group mb-3">

              </div>
              <input type="text" class="form-control" id="Aciklama" placeholder="Açıklama">
              <input style="margin-top:10px;" id="Borclandir" type="button" value="Borçlandır" class="form-control btn btn-warning col-md-6">
            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
      </div><!-- Borclandir Modal End -->
      <!-- Alacaklandir -->
      <div id="AlacakModal" class="modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <h4> Alacak Girişi </h4>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                </div>
                <input type="hidden" id="MusID" value="<?php echo $MusID; ?>">
                <select class="form-control" name="parabirimialacak" id="parabirimialacak">
                  <option value="0"> Para Birimi </option>
                  <?php
                  $fimy_parabirimi = $vt->listele("fimy_parabirimi", "WHERE Aktif=1");
                  if ($fimy_parabirimi != null) foreach ($fimy_parabirimi as $pb) {
                    echo '<option value="' . $pb['ID'] . '">' . $pb['ParaBirimi'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" class="form-control" placeholder="0000.00" id="TutarA">
              </div>
              <div id="varsakural" class="input-group mb-3"></div>
              <input type="text" class="form-control" id="AciklamaA" placeholder="Açıklama">
              <input style="margin-top:10px;" id="Alacaklan" type="button" value="Alacaklandır" class="form-control btn btn-warning col-md-6">
              <div id="cevap"></div>
            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
      </div><!-- Alacaklandir Modal End -->

      <!-- ÖdemeYap -->
      <div id="OdemeYap" class="modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <h4> Ödeme Yap </h4>
              <div class="input-group mb-3">
                <select id="kasa" class="form-control select2">
                  <option label="Kasa Seçiniz"></option>
                  <?php
                  $BakiyeRenk = "";
                  $isaret = "";
                  $icrm_kasalar = $vt->listele("fimy_kasa");
                  if ($icrm_kasalar != null) foreach ($icrm_kasalar as $f) {
                    $ID = $f['ID'];
                    $KasaAdi = $f['KasaAdi'];
                    $Bakiye = $f['Bakiye'];
                    $KPB = $f['ParaBirimi'];
                    $icrm_pb = $vt->listele("fimy_parabirimi", "WHERE ID='" . $KPB . "'");
                    if ($icrm_pb != null) foreach ($icrm_pb as $pb) {
                      $exentedpb = $pb['ParaBirimi'];
                    }

                    if ($Bakiye < 0) {
                      $BakiyeRenk = "red";
                      $Bakiye = explode("-", $Bakiye);
                      $Bakiye = $Bakiye[1];
                      $isaret = "-";
                    } else if ($Bakiye > 0) {
                      $BakiyeRenk = "green";
                      $isaret = "";
                    } else {
                      $BakiyeRenk = "orange";
                      $isaret = "";
                    }

                    echo '<option style="color:' . $BakiyeRenk . ';" value="' . $ID . '">
                                    <td>' . $KasaAdi . '</td>
                                    <td> | </td>
                                    <td><b style="color:' . $BakiyeRenk . ';">' . $isaret . ' ' . number_format($Bakiye, 2, ',', '.') . ' ' . $exentedpb . '</b></td>
                                  </option>';
                  }
                  ?>

                </select>

              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="0000.00" id="TutarOdeme">
                <div class="input-group-append">
                  <span id="pbicon" class="input-group-text"> </span>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="AciklamaOdeme" placeholder="Açıklama">
              </div>
              <input type="hidden" id="OMusID" value="<?php echo $MusteriID; ?>">

              <input style="margin-top:10px;" id="odemeyap" type="button" value="Ödeme Yap" class="form-control btn btn-dark col-md-6">
            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
      </div><!-- ÖdemeYap Modal End -->

      <!-- ÖdemeAl -->
      <div id="OdemeAl" class="modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <h4> Ödeme Al </h4>
              <div class="input-group mb-3">
                <select id="kasaal" class="form-control select2">
                  <option label="Kasa Seçiniz"></option>
                  <?php
                  $BakiyeRenk = "";
                  $isaret = "";
                  $icrm_kasalar = $vt->listele("fimy_kasa");
                  if ($icrm_kasalar != null) foreach ($icrm_kasalar as $f) {
                    $ID = $f['ID'];
                    $KasaAdi = $f['KasaAdi'];
                    $Bakiye = $f['Bakiye'];
                    $KPB = $f['ParaBirimi'];
                    $icrm_pb = $vt->listele("fimy_parabirimi", "WHERE ID='" . $KPB . "'");
                    if ($icrm_pb != null) foreach ($icrm_pb as $pb) {
                      $exentedpb = $pb['ParaBirimi'];
                    }

                    if ($Bakiye < 0) {
                      $BakiyeRenk = "red";
                      $Bakiye = explode("-", $Bakiye);
                      $Bakiye = $Bakiye[1];
                      $isaret = "-";
                    } else if ($Bakiye > 0) {
                      $BakiyeRenk = "green";
                      $isaret = "";
                    } else {
                      $BakiyeRenk = "orange";
                      $isaret = "";
                    }

                    echo '<option style="color:' . $BakiyeRenk . ';" value="' . $ID . '">
                                    <td>' . $KasaAdi . '</td>
                                    <td> | </td>
                                    <td><b style="color:' . $BakiyeRenk . ';">' . $isaret . ' ' . number_format($Bakiye, 2, ',', '.') . ' ' . $exentedpb . '</b></td>
                                  </option>';
                  }
                  ?>

                </select>

              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="0000.00" id="alTutarOdeme">
                <div class="input-group-append">
                  <span id="pbicon" class="input-group-text"> </span>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="AciklamaOdemeal" placeholder="Açıklama">
              </div>
              <input type="hidden" id="OAMusID" value="<?php echo $MusteriID; ?>">

              <input style="margin-top:10px;" id="odemeal" type="button" value="Ödeme Al" class="form-control btn btn-info col-md-6">
            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
      </div><!-- ÖdemeAl Modal End -->


      <!-- MODALSuccess -->
      <div id="Successmdl" class="modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">

              <div id="echo"></div>

            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
      </div><!-- modal -->
  <?php
    include("../src/footer-alt.php");
  } else {
    include("../src/footer-alt.php");
    echo "
            <script>
            Swal.fire({ title: 'Hata!', text: 'Geçersiz parametre. Lütfen kontrol ediniz!', icon: 'error' });
                        setTimeout(function() {
                            window.location.href = '../muhasebe/musteriler.fi';
                        }, 800);
            </script>";
  }
} else {
  include("../src/footer-alt.php");
  echo "
            <script>
            Swal.fire({ title: 'Hata!', text: 'Böyle bir parametre yok. lütfen kontrol ediniz!', icon: 'error' });
                        setTimeout(function() {
                            window.location.href = '../muhasebe/musteriler.fi';
                        }, 800);
            </script>";
}

  ?>
  <script>
    $(document).ready(function() {

      $('#TutarB').mask('00000000000,00', {
        reverse: true
      });
      $('#TutarA').mask('00000000000,00', {
        reverse: true
      });
      $('#TutarOdeme').mask('00000000000,00', {
        reverse: true
      });
      $('#alTutarOdeme').mask('00000000000,00', {
        reverse: true
      });
      
      $("#parabirimialacak").on("change", function() {
        var ds = 'parabirimi=' + $('#parabirimialacak').val();
        $.ajax({
          url: '../muhasebe/process/kurfiltrele.fi',
          type: 'POST',
          data: ds,
          success: function(e) {
            $("div#varsakural").html("").html(e);
          }
        });

      });
      $("#parabirimi").on("change", function() {
        var ds = 'parabirimi=' + $('#parabirimi').val();
        $.ajax({
          url: '../muhasebe/process/kurfiltrele.fi',
          type: 'POST',
          data: ds,
          success: function(e) {
            $("div#varsakur").html("").html(e);
          }
        });

      });
      $("#kasa").on("change", function() {
        var ds = 'kasa=' + $('#kasa').val();
        $.ajax({
          url: '../muhasebe/process/ParaBirimiFiltre.fi',
          type: 'POST',
          data: ds,
          success: function(e) {
            $("span#pbicon").html("").html(e);
          }
        });

      });
      $("#kasaal").on("change", function() {
        var ds = 'kasa=' + $('#kasaal').val();
        $.ajax({
          url: '../muhasebe/process/ParaBirimiFiltre.fi',
          type: 'POST',
          data: ds,
          success: function(e) {
            $("span#pbicon").html("").html(e);
          }
        });

      });

      $("#Borclandir").on("click", function() {
        var ds = 'TutarB=' + $('#TutarB').val() +
          '&Aciklama=' + $('#Aciklama').val() +
          '&BorcAlacak=1' +
          '&ParaBirimi=' + $('#parabirimi').val() +
          '&MusID=' + $('#MusID').val();
        $("#preloader").show();
        $.ajax({
          url: '../muhasebe/process/BorclandirAlacaklandir.fi',
          type: 'POST',
          data: ds,
          success: function(e) {
            $("#preloader").hide();
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
      });

      $("#Alacaklan").on("click", function() {
        var ds = 'TutarA=' + $('#TutarA').val() +
          '&Aciklama=' + $('#AciklamaA').val() +
          '&BorcAlacak=2' +
          '&ParaBirimi=' + $('#parabirimialacak').val() +
          '&MusID=' + $('#MusID').val();
        $("#preloader").show();
        $.ajax({
          url: '../muhasebe/process/BorclandirAlacaklandir.fi',
          type: 'POST',
          data: ds,
          success: function(e) {
            //alert(e);
            $("#preloader").hide();
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
      });

      $("#odemeyap").on("click", function() {
        var ds = 'kasa=' + $('#kasa').val() +
          '&Aciklama=' + $('#AciklamaOdeme').val() +
          '&TutarOdeme=' + $('#TutarOdeme').val() +
          '&odemeparabirimi=' + $('#odemeparabirimi').val() +
          '&MusID=' + $('#OMusID').val();
        $.ajax({
          url: '../muhasebe/process/OdemeYap.fi',
          type: 'POST',
          data: ds,
          success: function(e) {
          alert(e);
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
      });

      $("#odemeal").on("click", function() {
        var ds = 'kasa=' + $('#kasaal').val() +
          '&Aciklama=' + $('#AciklamaOdemeal').val() +
          '&TutarOdeme=' + $('#alTutarOdeme').val() +
          '&odemeparabirimi=' + $('#odemeparabirimi').val() +
          '&MusID=' + $('#OAMusID').val();
        $.ajax({
          url: '../muhasebe/process/OdemeAl.fi',
          type: 'POST',
          data: ds,
          success: function(e) {
            alert(e);
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
      });

    });
  </script>
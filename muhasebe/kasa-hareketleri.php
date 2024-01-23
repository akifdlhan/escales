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
?>
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
      <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

          <div class="row d-flex align-items-stretch">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-xl-3 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="header-title text-center">Açılış Bakiyesi</h4>
                      <div class="widget-detail-1 text-center">
                        <h2 class="fw-normal "> <?php
                                                echo number_format($kasalar['AcilisBakiyesi'], 2, ',', '.');
                                                echo " " . $exentedpb; ?> </h2>
                        <p class="text-muted mb-1"> </p>
                      </div>
                    </div>
                  </div>
                </div><!-- end col -->
                <div class="col-xl-3 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="header-title text-center">Açılış Tarihi</h4>
                      <div class="widget-detail-1 text-center">
                        <h2 class="fw-normal "> <?php $KasaTarih = $kasalar['Tarih'];
                                                $kt = new DateTime($KasaTarih);
                                                echo $kt->format('d.m.Y'); ?> </h2>
                        <p class="text-muted mb-1"> </p>
                      </div>
                    </div>
                  </div>
                </div><!-- end col -->
                <div class="col-xl-6 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="header-title text-center">Açıklama</h4>
                      <div class="widget-detail-1 text-center">
                        <?php
                        if ($DovizID > 0) {

                          $sorgu = $vt->listele("fimy_dovizcifti", "WHERE ID={$DovizID}");
                          if ($sorgu != null) foreach ($sorgu as $satir) {
                            $DA = $satir['DovizAdi'];
                            $ID = $satir['ID'];
                          }
                          $fimy_dovizkurlari = $vt->listele("fimy_dovizkurlari", "WHERE DovizID={$DovizID}");
                          if ($fimy_dovizkurlari != null) foreach ($fimy_dovizkurlari as $kur) {
                            $Alis = $kur['Alis'];
                            $Satis = $kur['Satis'];
                          }
                          echo '<h5>' . $DA . '</h5>';
                          echo '<p> <b>Alış.:</b> ' . $Alis . ' <b>Satış.:</b> ' . $Satis . '</p>';
                        }
                        ?>
                        <p class="fw-normal"> <?php echo $kasalar['Aciklama']; ?> </p>
                        <p style="margin-bottom:25px !important;" class="text-muted mb-1"> </p>
                      </div>
                    </div>
                  </div>
                </div><!-- end col -->

                <div style="display: flex; flex-direction: column;" class="col-xl-6 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <br>
                      <h4 class="header-title text-center">Güncel Bakiye</h4>
                      <br>
                      <div class="widget-detail-1 text-center">
                        <?php
                        $r = "";
                        if ($Bakiye >= 0) {
                          $r = "Green";
                        } else {
                          $r = "Red";
                        }
                        ?>
                        <h2 style="text-shadow:-2px -2px 10px <?php echo $r; ?>;" class="fw-normal"> <?php echo number_format($Bakiye, 2, ',', '.'); ?> <?php echo $exentedpb; ?> </h2>
                        <p style="margin-bottom:12px !important;" class="text-muted mb-1"> </p>
                        <br>
                      </div>
                    </div>
                  </div>
                </div><!-- end col -->

                <div style="text-align:center;display: block;" class="col-lg-6">
                  <div class="card">
                    <div class="card-body">
                      <a style="margin-top:10px;width: 150px;" data-bs-toggle="modal" data-bs-target="#ParaGirisi" class="btn btn-success" data-animation="fadein" data-plugin="ParaGirisi" data-overlayspeed="200" data-overlaycolor="#36404a">
                        <i class="ti-import"></i> Para Girişi
                      </a><br>
                      <a style="margin-top:10px;width: 150px;" data-bs-toggle="modal" data-bs-target="#ParaCikisi" class="btn btn-primary    " data-animation="fadein" data-plugin="ParaCikisi" data-overlayspeed="200" data-overlaycolor="#36404a">
                        <i class="ti-export"></i> Para Çıkışı
                      </a><br>
                      <a style="margin-top:10px;width: 150px;" data-bs-toggle="modal" data-bs-target="#virman" class="btn btn-warning" data-animation="fadein" data-plugin="ParaVirman" data-overlayspeed="200" data-overlaycolor="#36404a">
                        <i class="ti-share"></i> Virman(Kasalar Arası)
                      </a><br>
                    </div>
                  </div>
                </div><!-- col-lg-12 -->

              </div>
            </div>
            <div id="echo"></div>

            <div class="col-lg-12">

              <a class="btn btn-block" href="../muhasebe/tum-hareketler.fi?KasaID=<?php echo $KasaID; ?>"> Tüm Haraketleri Gör</a>
              <div style="margin-top:10px;" class="col-md-12">
                <div style="text-align:center;display: block;margin: auto;" class="card card-dashboard-fourteen">
                  <label class="az-content-label"> <span> </span></label>
                  <div class="card-body">
                    <div class="row row-sm">
                      <div class="col-lg-12">
                        <div class="col-lg-12">
                          <h5 class="az-content-label mg-b-5">Para Giriş - Çıkış Hareketleri</h5>
                        </div>


                        <div class="table-responsive">
                          <table class="table mg-b-0">
                            <thead>
                              <tr>
                                <th>İşlem Türü</th>
                                <th>Tutar</th>
                                <th>Para Birimi</th>
                                <th>Açıklama</th>
                                <th>Tarih</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $fimy_kasaparagc = $vt->listele("fimy_kasaparagc", "WHERE KasaID={$KasaID} ORDER BY ID DESC LIMIT 5");
                              if ($fimy_kasaparagc != null) foreach ($fimy_kasaparagc as $paragc) {

                              ?>
                                <tr>
                                  <td><?php // $paragc['Tur']; 
                                      if ($paragc['Tur'] == 1) {
                                        echo "Para Girişi";
                                      } else {
                                        echo "Para Çıkışı";
                                      }
                                      ?></td>
                                  <td><?php echo number_format($paragc['Tutar'], 2, ',', '.');
                                      //echo $paragc['Tutar']; 
                                      ?></td>
                                  <td><?php echo $exentedpb; ?></td>
                                  <td><?php echo $paragc['Aciklama']; ?></td>
                                  <td><?php $ttarih = $paragc['Tarih'];
                                      $t = new DateTime($ttarih);
                                      echo $t->format('d.m.Y H:i:s');
                                      ?></td>
                                </tr>
                              <?php
                              }
                              ?>
                            </tbody>
                          </table>
                        </div><!-- table-responsive -->
                      </div>

                      <div class="col-lg-12">
                        <hr>
                        <div class="col-lg-12">
                          <h5 class="az-content-label mg-b-5">Ödeme Hareketleri</h5>
                        </div>

                        <div class="table-responsive">
                          <table class="table mg-b-0">
                            <thead>
                              <tr>
                                <th>Müşteri</th>
                                <th>Al - Ver</th>
                                <th>Tutar</th>
                                <th>Açıklama</th>
                                <th>Tarih</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $fimy_m_odemehareket = $vt->listele("fimy_m_odemehareket", "WHERE KasaID={$KasaID} ORDER BY ID DESC LIMIT 5");
                              if ($fimy_m_odemehareket != null) foreach ($fimy_m_odemehareket as $bah) {
                                $Tur = "";
                                if ($bah['AlVer'] == 1) {
                                  $Tur = "Ödeme Yapıldı";
                                } else if ($bah['AlVer'] == 2) {
                                  $Tur = "Ödeme Alındı";
                                } else {
                                  $Tur = "SystemErrorICON_OdemeListeme228";
                                }
                                $KA = $bah['KasaID'];
                                $MID = $bah['MID'];
                                $fimy_kasa = $vt->listele("fimy_kasa", "WHERE ID='" . $KA . "'");
                                if ($fimy_kasa != null) foreach ($fimy_kasa as $f) {
                                  $KasaAdi = $f['KasaAdi'];
                                }
                                $fimy_cari_hesap = $vt->listele("fimy_cari_hesap", "WHERE ID='" . $MID . "'");
                                if ($fimy_cari_hesap != null) foreach ($fimy_cari_hesap as $m) {
                                  $exentedisim = $m['Adi'];
                                  $exentedsisim = $m['Soyadi'];
                                  $MusAdiSoy = $exentedisim . " " . $exentedsisim;
                                }
                              ?>
                                <tr>
                                  <td><?php echo $MusAdiSoy; ?></td>
                                  <td><?php echo $Tur; ?></td>
                                  <td><?php echo number_format($bah['Tutar'], 2, ',', '.') . " " . $exentedpb; ?> </td>
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

                      <div class="col-lg-12">
                        <hr>
                        <div class="col-lg-12">
                          <h5 class="az-content-label mg-b-5">Virman Hareketleri</h5>
                        </div>

                        <div class="table-responsive">
                          <table class="table mg-b-0">
                            <thead>
                              <tr>
                                <th>Alıcı Kasa</th>
                                <th>Kur</th>
                                <th>Aktarılan Bakiye</th>
                                <th>Tutar</th>
                                <th>Açıklama</th>
                                <th>Önceki Bakiye</th>
                                <th>Tarih</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $fimy_kasa_virma = $vt->listele("fimy_kasa_virma", "WHERE VericiKasa={$KasaID} ORDER BY ID DESC LIMIT 5");
                              if ($fimy_kasa_virma != null) foreach ($fimy_kasa_virma as $bah) {

                                $fimy_kasa = $vt->listele("fimy_kasa", "WHERE ID='" . $bah['AliciKasa'] . "'");
                                if ($fimy_kasa != null) foreach ($fimy_kasa as $f) {
                                  $KasaAdi = $f['KasaAdi'];
                                  $AliciParaBirimi = $f['ParaBirimi'];
                                  $icrm_pb = $vt->listele("fimy_parabirimi", "WHERE ID='" . $AliciParaBirimi . "'");
                                  if ($icrm_pb != null) foreach ($icrm_pb as $pb) {
                                    $Aliciexentedpb = $pb['ParaBirimi'];
                                  }
                                }
                              ?>
                                <tr>
                                  <td><?php echo $KasaAdi . " - " . $Aliciexentedpb; ?></td>
                                  <td><?php echo number_format($bah['Kur'], 5, ',', '.') . " " . $Aliciexentedpb; ?></td>
                                  <td><?php echo number_format($bah['KurKarsiligi'], 2, ',', '.') . " " . $Aliciexentedpb; ?></td>
                                  <td><?php echo number_format($bah['VirmanTutar'], 2, ',', '.') . " " . $exentedpb; ?></td>
                                  <td><?php echo $bah['Aciklama']; ?></td>
                                  <td><?php echo number_format($bah['VericiOncekiBakiye'], 2, ',', '.') . " " . $exentedpb; ?> </td>
                                  <td><?php $kt = new DateTime($bah['Proccess_Date']);
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
                </div><!-- card -->
              </div><!-- col-card -->
            </div><!-- row -->

          </div>
        </div>
      </div>
    </div><!-- end row -->
    </div> <!-- container -->
    </div> <!-- content -->

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    <!-- Paragirisi -->
    <div id="ParaGirisi" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <h4> Para Girişi </h4>
            <small> * Yazacağınız tutar ilgili kasanın para birimi üzerinden giriş sağlanacaktır. </small>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
              </div>
              <input type="hidden" id="KasaID" value="<?php echo $KasaID; ?>">
              <input type="text" class="form-control" id="PGTutar">
              <div class="input-group-append">
                <span class="input-group-text"><?php echo $exentedpb; ?></span>
              </div>
            </div>
            <input type="text" class="form-control" id="Aciklama" placeholder="Acıklama">
            <input style="margin-top:10px;" id="ParaGir" type="button" value="Para Girişi" class="form-control btn btn-success col-md-6">
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->
    <!-- Paragirisi -->
    <div id="ParaCikisi" class="modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <h4> Para Çıkışı </h4>
            <small> * Yazacağınız tutar ilgili kasanın para birimi üzerinden çıkış sağlanacaktır. </small>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
              </div>
              <input type="hidden" id="KasaID" value="<?php echo $KasaID; ?>">
              <input type="text" class="form-control" id="PGTutarC">
              <div class="input-group-append">
                <span class="input-group-text"><?php echo $exentedpb; ?></span>
              </div>
            </div>
            <input type="text" class="form-control" id="AciklamaC" placeholder="Acıklama">
            <input style="margin-top:10px;" id="ParaCik" type="button" value="Para Çıkışı" class="form-control btn btn-success col-md-6">
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->
    <!-- Virman -->
    <div id="virman" class="modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <h4> Kasalar Arası Virman </h4>
            <div class="input-group mb-3">
              <select id="alicikasa" class="form-control select2">
                <option label="Kasa Seçiniz"></option>
                <?php
                $fimy_kasa = $vt->listele("fimy_kasa", "WHERE ID={$KasaID}");
                if ($fimy_kasa != null) foreach ($fimy_kasa as $ka) {
                  $Bakiye = $ka['Bakiye'];
                  $CurrnetTillPB = $ka['ParaBirimi'];
                  $icrm_pb = $vt->listele("fimy_parabirimi", "WHERE ID='" . $CurrnetTillPB . "'");
                  if ($icrm_pb != null) foreach ($icrm_pb as $pb) {
                    $CurrentTillPB = $pb['ParaBirimi'];
                  }
                  if ($Bakiye <= 0) {
                    echo '<script>
                          toastr["error"]("Kasada Bakiye bulunmadığından dolayı virman işlemi yapılamaz..");
                          </script>';
                  }
                }
                $BakiyeRenk = "";
                $isaret = "";
                $icrm_kasalar = $vt->listele("fimy_kasa", "WHERE ID<>{$KasaID}");
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
              <input type="hidden" id="VericiKasa" value="<?php echo $KasaID; ?>">
              <input type="text" class="form-control" id="VirmanTutar">
              <div class="input-group-append">
                <span class="input-group-text"><?php echo $CurrentTillPB; ?></span>
              </div>
            </div>
            <div id="pbfarkli" class="form-group has-success mg-b-0"></div>
            <div id="pbcarpani" class="form-group has-success mg-b-0">
              <br>
            </div>
            <div class="form-group has-success mg-b-10">
              <input type="text" class="form-control" id="VirmanAciklama" placeholder="Açıklama..">
            </div>
            <div class="form-group has-success mg-b-10">
              <input style="margin-top:10px;" id="ParaVirman" type="button" value="Virman Onayla" class="form-control btn btn-success col-md-6">
            </div>

          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <!-- Script -->
    <script>
      $(document).ready(function() {
        $('#PGTutar').mask('00000000000,00', {
          reverse: true
        });
        $('#PGTutarC').mask('00000000000,00', {
          reverse: true
        });
        $('#VirmanTutar').mask('00000000000,00', {
          reverse: true
        });

        $("#ParaGir").on("click", function() {
          var ds = 'PGTutar=' + $('#PGTutar').val() +
            '&Aciklama=' + $('#Aciklama').val() +
            '&KasaID=' + $('#KasaID').val();
          $.ajax({
            url: '../muhasebe/process/paragir.fi',
            type: 'POST',
            data: ds,
            success: function(e) {
              $("div#echo").html("").html(e);
              $('#ParaGirisi').modal('toggle');
              toastr["success"](e);
            }
          });
        });

        $("#alicikasa").on("change", function() {
          var ds = 'alicikasa=' + $('#alicikasa').val() +
            '&KasaID=' + $('#KasaID').val();
          $.ajax({
            url: '../muhasebe/process/alicikasa.fi',
            type: 'POST',
            data: ds,
            success: function(e) {
              $("div#pbfarkli").html("").html(e);
            }
          });
        });

        $("#ParaCik").on("click", function() {
          var ds = 'PGTutarC=' + $('#PGTutarC').val() +
            '&AciklamaC=' + $('#AciklamaC').val() +
            '&KasaID=' + $('#KasaID').val();
          $.ajax({
            url: '../muhasebe/process/paracik.fi',
            type: 'POST',
            data: ds,
            success: function(e) {
              $("div#echo").html("").html(e);
              $('#ParaCikisi').modal('toggle');
              toastr["success"](e);
            }
          });
        });

        $("#VirmanTutar").on("input", function() {
          var ds = 'kurkarsiligi=' + $('#kurkarsiligi').val() +
            '&VirmanTutar=' + $('#VirmanTutar').val() +
            '&alicikasa=' + $('#alicikasa').val() +
            '&VericiKasa=' + $('#VericiKasa').val();
          $.ajax({
            url: '../muhasebe/process/kurxvirmantutar.fi',
            type: 'POST',
            data: ds,
            success: function(e) {
              $("div#pbcarpani").html("").html(e);
            }
          });
        });

        $("#ParaVirman").on("click", function() {
          if ($('#VirmanTutar').val() == "" || $('#VirmanAciklama').val() == "" || $('#alicikasa').val() == 0) {
            toastr["error"]("Boş alanlar mevcut lütfen kontrol ediniz..");
          } else {
            var ds = 'VirmanSonTutar=' + $('#sontutar').val() +
              '&VirmanTutar=' + $('#VirmanTutar').val() +
              '&VirmanAciklama=' + $('#VirmanAciklama').val() +
              '&kur=' + $('#kurkarsiligi').val() +
              '&alicikasa=' + $('#alicikasa').val() +
              '&VericiKasa=' + $('#VericiKasa').val();
            $.ajax({
              url: '../muhasebe/process/virman.fi',
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
          }

        });
      });
    </script>
    <!-- Script End -->



<?php
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
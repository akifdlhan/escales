<?php include("../src/access.php"); ?>
              <!-- ============================================================== -->
              <!-- Start Page Content here -->
              <!-- ============================================================== -->
  
              <div class="content-page">
                  <div class="content">
  
                      <!-- Start Content-->
                      <div class="container-fluid">
  
                      <div class="row">
                      <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                <center>
                                    <a href="yeni-musteri.fi" style="margin:3px;" class="btn btn-success col-lg-12"> Yeni Müşteri </a>
                                </center>
                                <table id="cari-full" class="table table-bordered dt-responsive nowrap">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Adi</th>
                                                <th>Soyadi</th>
                                                <th>Tel</th>
                                                <th>Mail</th>
                                                <th>Oluşturma Tarihi</th>
                                                <th>Hesap Tipi</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                    $fimy_cari_hesap = $vt->listele("fimy_cari_hesap");
                                                    if($fimy_cari_hesap != null) foreach( $fimy_cari_hesap as $cari ) {
                                                        if($cari['Kurumsal'] == 1){
                                                            $kurumsal = "Kurumsal";
                                                        }else{
                                                            $kurumsal = "Bireysel";
                                                        }
                                                        echo '<tr>
                                                        <td>'.$cari['ID'].'</td>
                                                        <td>'.$cari['Adi'].'</td>
                                                        <td>'.$cari['Soyadi'].'</td>
                                                        <td>'.$cari['Tel'].'</td>
                                                        <td>'.$cari['Mail'].'</td>
                                                        <td>'.$cari['Olusturma'].'</td>
                                                        <td>'.$kurumsal.'</td>
                                                        <td>
                                                        <center>
                                                        <a class="btn btn-info" href="musteri-detay.fi?MusteriID='.$cari['ID'].'">
                                                        <i class="ti-layers-alt"></i> 
                                                        Detay
                                                        </a>
                                                        </center>
                                                        </td>
                                                        </tr>';
                                                        }
                                                    ?>
                                            </tbody>
                                        </table>

                                </div>
                            </div>
                      </div>
                  </div>     
                  <!-- end row -->       
                          
                      
                      </div> <!-- container -->
  
                  </div> <!-- content -->
                <script>
                     $(document).ready(function(){
                            $("#cari-full").DataTable({
                                order: [[0, 'desc']],
                                "lengthMenu": [15,20,50,100,200]   
                            });
                        });
                </script>
              <!-- ============================================================== -->
              <!-- End Page content -->
              <!-- ============================================================== -->
              <?php include("../src/footer-alt.php"); ?>
<?php include("../src/access.php"); ?>
              <!-- ============================================================== -->
              <!-- Start Page Content here -->
              <!-- ============================================================== -->
  
              <div class="content-page">
                  <div class="content">
  
                      <!-- Start Content-->
                      <div class="container-fluid">
  
                      <div class="row">
                                <div class="card">
                                    <div class="inner-box card-body">
                                        <div class="col-sm-12"> <h4> Şifre Gereksinimleri </h4> </div>
                                    </div>
                                </div>
                          </div>
                          <!-- end row --> 
                          <div class="row">
                          <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-borderless table-bordered mb-0">
                                                <tbody>
                                                <?php
                                                    $fimy_prules = $vt->listele("fimy_prules","WHERE ID=1");
                                                    if($fimy_prules != null) foreach( $fimy_prules as $pr ) {
                                                            $Min = $pr['Min'];
                                                            $Cust = $pr['Cust-charter'];
                                                            $Num = $pr['Num-req'];
                                                            $UpLow = $pr['UpLow-req'];
                                                            $Cust = ($Cust == true) ? "true" : "false";
                                                            $Num = ($Num == true) ? "true" : "false";
                                                            $UpLow = ($UpLow == true) ? "true" : "false";
                                                    }
                                                
                                                ?>
                                                    <tr>
                                                        <th style="width: 35%;">Minimum Karakter</th>
                                                        <td><?php echo $Min; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%;">Özel Karakter</th>
                                                        <td><?php echo $Cust; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%;">Rakam</th>
                                                        <td><?php echo $Num; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%;">Büyük-Küçük Harf</th>
                                                        <td><?php echo $UpLow; ?></td>
                                                    </tr>        
                                                </tbody>
                                            </table>
                                        </div> <!-- end .table-responsive -->
                                    </div>
                                </div> <!-- end card -->
                            </div><!-- end col -->
                          </div>       
                          
                      
                      </div> <!-- container -->
  
                  </div> <!-- content -->
  
              <!-- ============================================================== -->
              <!-- End Page content -->
              <!-- ============================================================== -->
              <?php include("../src/footer-alt.php"); ?>
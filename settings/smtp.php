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
                                        <div class="col-sm-12"> <h4> SMTP Ayarları </h4> </div>
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
                                                    $fimy_smtp = $vt->listele("fimy_smtp","where statu=1");
                                                    if($fimy_smtp != null) foreach( $fimy_smtp as $smtp ) {
                                                            $usarname = $smtp['username'];
                                                            $password = $smtp['password'];
                                                            $server = $smtp['server'];
                                                            $port = $smtp['port'];
                                                            $Display_Name = $smtp['Display-Name'];
                                                            $Sender = $smtp['Sender'];
                                                    }
                                                ?>
                                                    <tr>
                                                        <th style="width: 35%;">Username</th>
                                                        <td><?php echo $usarname; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%;">Password</th>
                                                        <td><?php echo $password; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%;">Server</th>
                                                        <td><?php echo $server; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%;">Port</th>
                                                        <td><?php echo $port; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%;">Display Name</th>
                                                        <td><?php echo $Display_Name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%;">Sender</th>
                                                        <td><?php echo $Sender; ?></td>
                                                    </tr>
        
                                                </tbody>
                                            </table>
                                        </div> <!-- end .table-responsive -->
                                    </div>
                                </div> <!-- end card -->
                            </div><!-- end col -->
                          </div>
                          <!-- end row --> 
                          <div class="row">
                          <div class="col-12">
                                <div class="card">
                                    <div class="inner-box card-body">
                                        <div class="col-sm-12"> 
                                            Test
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="testmail">Mail Adresi</label>
                                                    <input type="mail" class="form-control" id="testmail" value="info@fislash.com.tr">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <input type="submit" class="btn btn-success" id="testgonder" value="Test Et">
                                                    <div id="son"></div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                          </div>
                          <script src="..\assets\js\fi-js\smtp.js" type="text/javascript"></script>
                      
                      </div> <!-- container -->
  
                  </div> <!-- content -->
  
              <!-- ============================================================== -->
              <!-- End Page content -->
              <!-- ============================================================== -->
              <?php include("../src/footer-alt.php"); ?>
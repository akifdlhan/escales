<?php include("../src/access.php"); ?>
              <!-- ============================================================== -->
              <!-- Start Page Content here -->
              <!-- ============================================================== -->
  
              <div class="content-page">
                  <div class="content">
  
                      <!-- Start Content-->
                      <div class="container-fluid">
  
                          <div class="row">
                              <div class="col-sm-12">  </div>
                          </div>
                          <!-- end row -->        
                          
                          <div class="row">
                          <div class="col-xl-12"> 
                          <div class="card">
                            <div class="card-header">
                              <div class="row">
                                <div class="col-xl-6"><h4 class="card-title">Fi My App Ayarları</h4></div>
                                <div class="col-xl-6">
                                <button type="button" class="btn btn-info" id="eo"> Edit </button>
                                <button type="button" class="btn btn-success" id="update"> Update </button>
                                </div>
                              </div>
                            </div>
                            <div class="card-body">
                          <?php 
                          $siteoptions = $vt->listele("fimy_appoptions");
                          if($siteoptions != null) foreach( $siteoptions as $opt ) {
                              $opt['FirmaAdi'];
                              $opt['YetkiliAdi'];
                              $opt['YetkiliSoyadi'];
                              $opt['FirmaAdi'];
                          ?>
                          <div class="row">
                            <div class="col-xl-6"> 
                              <div class="form-group">
                                  <label class="text-label">Company</label>
                                  <input type="text" id="company" name="company" class="form-control" value="<?php echo $opt['FirmaAdi'];?>" readonly>
                              </div>
                            </div>
                            <div class="col-xl-3"> 
                              <div class="form-group">
                                  <label class="text-label">Officer Name</label>
                                  <input type="text" id="name" name="name" class="form-control" value="<?php echo $opt['YetkiliAdi'];?>" readonly>
                              </div>
                            </div>
                            <div class="col-xl-3"> 
                              <div class="form-group">
                                  <label class="text-label">Officer Surname</label>
                                  <input type="text" id="surname" name="surname" class="form-control" value="<?php echo $opt['YetkiliSoyadi'];?>" readonly>
                              </div>
                            </div>
                            <div class="col-xl-3"> 
                              <div class="form-group">
                                  <label class="text-label">Telephone Number</label>
                                  <input type="text" id="tel" name="tel" class="form-control" value="<?php echo $opt['Telefon'];?>" readonly>
                              </div>
                            </div>
                            <div class="col-xl-3"> 
                              <div class="form-group">
                                  <label class="text-label">Telephone Number 2</label>
                                  <input type="text" id="tel2" name="tel2" class="form-control" value="<?php echo $opt['Telefon2'];?>" readonly>
                              </div>
                            </div>
                            <div class="col-xl-3"> 
                              <div class="form-group">
                                  <label class="text-label">Mail</label>
                                  <input type="mail" id="mail" name="mail" class="form-control" value="<?php echo $opt['Mail'];?>" readonly>
                              </div>
                            </div>
                            <div class="col-xl-3">
                                      <div class="form-group">
			                                <label class="text-label">Address</label>
                                            <textarea rows="2" id="adres" class="form-control" readonly><?php echo $opt['Adres'];?></textarea>
                                        </div>
                            </div>
                            <div class="col-xl-6">
                                      <div class="form-group">
			                                <label class="text-label">Logo</label>
                                      <img style="max-width: 250px; max-height: 250px; height: auto; width: auto;" src="<?php echo $opt['Logo'];?>" alt="">
                                      </div>
                            </div>
                            <div class="col-xl-6">
                                      <div class="form-group">
			                                <label class="text-label">Logo Small</label>
                                      <img style="max-width: 120px; width: auto;" src="<?php echo $opt['LogoSmall'];?>" alt="">
                                    </div>
                            </div>
                           
                            <div id="modeldiv"></div>
                            <div class="col-xl-12">
                            <form action="javascript:void(0);" name="dosyayukle" id="dosyayukle" enctype="multipart/form-data">
                           <div class="row">
                           <div class="col-xl-6">
                            <input class="form-control" type="file" name="dosya" id="dosya" />
                            </div>
                            <div class="col-xl-6">
                            <input class="col-xl-6 btn btn-success" type="submit" value="Update" />
                            </div>
                           </div>
                            </form>
                            </div>
                            <script src="..\assets\js\fi-js\app-settings.js" type="text/javascript"></script>
                          <?php 
                          }
                          ?>
                          </div><!-- Row -->
                            </div>
                          </div>
      </div>
                          </div>
                      
                      </div> <!-- container -->
  
                  </div> <!-- content -->
  
              <!-- ============================================================== -->
              <!-- End Page content -->
              <!-- ============================================================== -->
              <?php include("../src/footer-alt.php"); ?>
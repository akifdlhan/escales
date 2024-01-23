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
                                    <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                        <h4> Kullanıcı Grupları </h4>
                                        </div>
                                        <div style="text-align: right;" class="col-lg-6">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample"
                                        aria-expanded="false" aria-controls="collapseWidthExample">
                                        Grup Oluştur
                                    </button>
                                        </div>
                                    </div>    
                                    
                                     </div>
                                </div>
                            </div>

                            <div style="margin-bottom:5px;" class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="collapse collapse-horizontal" id="collapseWidthExample">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card card-body mb-0" >
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="Grup-Adi">Grup Adı <b>(*)</b></label>
                                                                    <input type="text" class="form-control" id="grup-adi" placeholder="">
                                                                    <small id="grupcontrol"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="Grup-Detay">Grup Detayı <b>(*)</b></label>
                                                                    <input type="text" class="form-control" id="grup-detay" placeholder="">
                                                                    <small id="detaycontrol"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <button id="grup-olustur" class="btn btn-success waves-effect waves-light me-1 col-md-12">Grup Oluştur</button>
                                                                <div id="son"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                              
                          </div>
                          <!-- end row -->    
                          <div class="row">
                                    <?php
                                        $fimy_access_group = $vt->listele("fimy_access_group","where Aktif=1");
                                        if($fimy_access_group != null) foreach( $fimy_access_group as $fag ) {
                                                ?>
                                    <article class="pricing-column col-xl-3 col-md-6">
                                        <div class="card">
                                            <div class="inner-box card-body">
                                                <div class="plan-header p-3 text-center">
                                                    <h6 >Level<i class="fa fa-hashtag" aria-hidden="true"></i><?php echo $fag['Level']; ?></h6>
                                                    <h3 class="plan-title"><?php echo $fag['Access_Adi']; ?></h3>
                                                    <div class="plan-duration"><?php echo $fag['Process_Date']; ?></div>
                                                </div>
                                                <ul class="plan-stats list-unstyled text-center p-3 mb-0">
                                                    <li style="font-size:9px;line-height: 1.6;"> <?php echo $fag['Access_Detay']; ?> </li>
                                                    <li> <a href="ugaction.fi?IDHash=<?php echo md5($fag['ID']); ?>&Level=<?php echo $fag['Level']; ?>&ID=<?php echo $fag['ID']; ?>"> <i style="color:#be1622;" class="fa fa-minus-circle" aria-hidden="true"></i> Sil </a> </li>
                                                </ul>
    
                                                <div class="text-center">
                                                   <?php // <a href="#" class="btn btn-bordered-success btn-success rounded-pill waves-effect waves-light">Pasif</a> ?>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                                
                                                <?php
                                        }
                                        ?>
                          </div>    
                          
                      
                      </div> <!-- container -->
  
                  </div> <!-- content -->
  
              <!-- ============================================================== -->
              <!-- End Page content -->
              <!-- ============================================================== -->

              <script>
                $("#grup-olustur").on("click",function(){
                    var grupadi = $("#grup-adi").val();
                    var grupdetay = $("#grup-detay").val();

                    if(grupadi == "" || grupadi == "" ){
                        toastr["error"]("Boş alanlar mevcut lütfen kontrol ediniz.");
                    }else{

                    userinfo="islem=1&"+
                    "grupadi="+grupadi+
                    "&grupdetay="+grupdetay;
                    
                    $.ajax({
                        url:'../settings/process/ug-process.fi', 
                        type:'POST', 
                        data:userinfo,
                        success:function(e){ 
                           $("div#son").html("").html(e);
                        }
                    });
                    
                        
                    }
                });
              </script>
              <?php include("../src/footer-alt.php"); ?>
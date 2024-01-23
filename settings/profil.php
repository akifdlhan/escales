<?php include("../src/access.php"); ?>
              <!-- ============================================================== -->
              <!-- Start Page Content here -->
              <!-- ============================================================== -->
              <?php 
function tarayicitespit() {
  $tarayicibul=$_SERVER['HTTP_USER_AGENT'];
  if(stristr($tarayicibul,"MSIE")) { $tarayici="Internet Explorer"; }
  if(stristr($tarayicibul,"Trident")) { $tarayici="Internet Explorer"; }
  elseif(stristr($tarayicibul,"Opera")) { $tarayici="Opera"; }
  elseif(stristr($tarayicibul,"OPR"))   { $tarayici="Opera"; }
  elseif(stristr($tarayicibul,"Firefox")) { $tarayici="Mozilla Firefox"; }
  elseif(stristr($tarayicibul,"YaBrowser")) { $tarayici="Yandex Browser"; }
  elseif(stristr($tarayicibul,"Chrome")) { $tarayici="Google Chrome"; }
  elseif(stristr($tarayicibul,"Safari")) { $tarayici="Safari"; }
  else {$tarayici="Bilinmiyor";}
  return $tarayici;
  }
  $tarayicim = tarayicitespit();
?>
<?php 
  $kullanici = $vt->listele("fimy_user_details","WHERE User_ID={$_SESSION['KID']}");
  if($kullanici != null) foreach( $kullanici as $k ) {
    $ID = $k['User_ID'];
    $is =  $k['Adi']." ".$k['Soyadi'];
    $resim =  $k['Resim'];
    $tel =  $k['TelefonNo'];
    $mail =  $k['Mail'];
    $btarih =  $k['Kayit_Tarih'];
    $SG =  $k['Son_Giris_Tarih'];
      
      $fimy_user = $vt->listele("fimy_user","WHERE ID={$_SESSION['KID']}");
      if($fimy_user != null) foreach( $fimy_user as $fu ) {
          $User = $fu['kullaniciadi'];
      }
        $fimy_user_access = $vt->listele("fimy_user_access","WHERE User_ID={$_SESSION['KID']}");
        if($fimy_user_access != null) foreach( $fimy_user_access as $ua ) {
            $YL = $ua['Access_Level'];
        }

  }
  ?>
              <div class="content-page">
                  <div class="content">
  
                      <!-- Start Content-->
                      <div class="container-fluid">
                          <!-- end row -->        
                          <div class="row">
                          <div class="col-xl-12">
   
   <div class="card overflow-hidden">
                             <div class="text-center p-3 overlay-box " style="background-color: red;">
                                 <div class="profile-photo">
                                     <img src="<?php echo $resim; ?>" width="100" class="img-fluid rounded-circle" alt="<?php echo $is; ?>">
                                 </div>
                                 <h3 class="mt-3 mb-1 text-white"><?php echo $is; ?></h3>
                                 <p class="text-white mb-0"><?php echo $User; ?></p>
                             </div>
                             <ul class="list-group list-group-flush">
                                 <li class="list-group-item d-flex justify-content-between"><span class="mb-0">User Group</span> <strong class="text-muted"><?php // $YL; 
             $fimy_access_group = $vt->listele("fimy_access_group","WHERE Level='".$YL."'");
             if($fimy_access_group != null) foreach( $fimy_access_group as $Py ) {
                 echo $Py['Access_Adi'];
             } ?></strong></li>
                                 <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Mail</span><strong class="text-muted"> <?php echo $mail; ?></strong></li>
                                 <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Telefon</span><strong class="text-muted"><?php echo $tel; ?></strong></li>
                                 <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Oluşturma Tarihi</span><strong class="text-muted"><?php echo $btarih; ?>	</strong></li>
                                 <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Son Login</span><strong class="text-muted"><?php echo $SG; ?>	</strong></li>
                             </ul>
                               <div class="card-footer">	
                                   <div class="row">
                                     <div style="margin-top:1px;" class="col-lg-6"> <button class="btn btn-info btn-lg btn-block col-lg-12"> <i class="fa fa-address-book"></i> Update Profile </button> </div>							
                                     <div style="margin-top:1px;" class="col-lg-6"> <a href="repass.fi?Username=<?php echo md5($User); ?>&ID=<?php echo $ID; ?>" class="btn btn-warning btn-lg btn-block col-lg-12"> <i class="fa fa-asterisk"></i> Change Password </a> </div>	
                                   </div>				
                               </div>
                         </div>
                       </div>
                          </div>
                          
                      
                      </div> <!-- container -->
  
                  </div> <!-- content -->
                    <?php 
                         echo '<script>
                         newTitle="'.$User.' | '.$_SESSION['Firma'].'";
                         document.title = newTitle;
                         document.getElementById("page-title-main").innerHTML = "'.$is.'";
                         </script>';
                    ?>
              <!-- ============================================================== -->
              <!-- End Page content -->
              <!-- ============================================================== -->
              <?php include("../src/footer-alt.php"); ?>
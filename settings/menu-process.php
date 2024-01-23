<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){
		 //$islem;
        if($islem == 1){

        $variables = array($title, $position, $url, $icon);
        $bos = inputcheck($variables);
          
            if($bos == 0){

              if(empty($parent)){
                //$parentadi = "";
                $dizin = $url;
                if (!file_exists($dizin)) {
                  if (mkdir("../".$dizin, 0777, true)) {
                      echo '<script>toastr["success"]("'.$dizin.' dizini oluşturuldu.");</script>';
                  } else {
                      echo '<script>toastr["error"]("Dizin oluşturma başarısız oldu..");</script>';
                  }
              } else {
                  echo '<script>toastr["error"]("'.$dizin.' dizini zaten var.");</script>';
              }
              $path = "../".$dizin;
              chdir($path);
              // Burada İndex oluşturacak.
              $dosyaAdi = 'index.php';
              $dosyaIcerigi = '<?php include("../src/access.php"); ?>
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

                                        </div>
                                    </div>
                              </div>
                          </div>     
                          <!-- end row -->  
                      
                      </div> <!-- container -->
  
                  </div> <!-- content -->
  
              <!-- ============================================================== -->
              <!-- End Page content -->
              <!-- ============================================================== -->
              <?php include("../src/footer-alt.php"); ?>';

              if (!file_exists($dosyaAdi)) {
                  if (file_put_contents($dosyaAdi, $dosyaIcerigi) !== false) {
                    echo '<script>toastr["success"]("'.$dosyaAdi.' dosyası oluşturuldu.");</script>';
                      $path = "../".$dizin."";
                  } else {
                    echo '<script>toastr["error"]("'.$dosyaAdi.' dosyası oluşturma başarısız oldu.");</script>';
                  }
              } else {
                echo '<script>toastr["error"]("'.$dosyaAdi.' dosyası zaten var.");</script>';
                  $path = "../".$dizin."";
              }
              // Burada İndex oluşturacak.


              // "parent_id"=>$parent, "position"=>$position, "icon"=>$icon, "url"=>$url.".php", "title"=>$title
             $menusadd = $vt->ekle("fimy_menu",array("position"=>$position, "folder"=>$url, "icon"=>$icon, "url"=>$path, "title"=>$title, "access"=>$access));


            }else{
              $fimy_parent = $vt->listele("fimy_menu","WHERE ID={$parent}");
              if($fimy_parent != null) foreach( $fimy_parent as $parent_id ) {
                  $parent_url = $parent_id['url'];
                  $parent_position = $parent_id['position'];
                  $parent_icon = $parent_id['icon'];
              }
              chdir($parent_url);
              $dosyaAdi = $url.'.php';
              $dosyaIcerigi = '<?php include("../src/access.php"); ?>
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

                                </div>
                            </div>
                      </div>
                  </div>     
                  <!-- end row -->       
                          
                      
                      </div> <!-- container -->
  
                  </div> <!-- content -->
  
              <!-- ============================================================== -->
              <!-- End Page content -->
              <!-- ============================================================== -->
              <?php include("../src/footer-alt.php"); ?>';

              if (!file_exists($dosyaAdi)) {
                if (file_put_contents($dosyaAdi, $dosyaIcerigi) !== false) {
                    echo '<script>toastr["success"]("'.$dosyaAdi.' dosyası oluşturuldu.");</script>';
                } else {
                    echo '<script>toastr["error"]("'.$dosyaAdi.' dosyası oluşturma başarısız oldu.");</script>';
                }
            } else {
                echo '<script>toastr["error"]("'.$dosyaAdi.' dosyası zaten var.");</script>';
            }
                  
              $pathh = $parent_url."/".$dosyaAdi;
              $post = $parent_position."-".$position;
                  

             // "parent_id"=>$parent, "position"=>$position, "icon"=>$icon, "url"=>$url.".php", "title"=>$title
             $menusadd = $vt->ekle("fimy_menu",array("parent_id"=>$parent,"folder"=>$url.".fi", "position"=>$post, "icon"=>$parent_icon, "url"=>$pathh, "title"=>$title, "access"=>$access));

                
            }


              if($menusadd > 0){
                echo '<script>
                Swal.fire({ title: "Menü Başarıyla Eklendi!", text: "İşlem Tamamlandı!", icon: "success" });
                setTimeout(function() {
                    window.location = "./menus.php";
                  }, 1000);
                    </script>';
              }else{
                echo '<script>
                Swal.fire({ title: "Sistem Sorunu(FiErr#655401)!", text: "Menü item eklenirken işlem Tamamlanamadı!", icon: "warning" });
                setTimeout(function() {
                    window.location = "./menus.fi";
                  }, 1000);
                    </script>';
              }

                
            }else{
                echo '<script>
                Swal.fire({ title: "Alanları Kontrol Edin!", text: "İşlem Tamamlanamadı!", icon: "warning" });
                setTimeout(function() {
                    window.location = "./menus.fi";
                  }, 1000);
                    </script>';
            }
           
        }else if($islem == 2){
            
        }else{

        }
	}
?>
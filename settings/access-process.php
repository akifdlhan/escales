<?php
session_start();
ob_start();
include("../src/iconlibrary.php");
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){
    // $MenuID;
    $fimy_menus = $vt->ozellistele("SELECT folder, access FROM fimy_menu WHERE ID={$MenuID}");
    if($fimy_menus != null) foreach( $fimy_menus as $menu ) {
      $Folder = $menu['folder'];
      $MenuYetkisi = $menu['access'];
    }
    echo '<h4>'.$Folder.'</h4>';
    echo '<div class="form-check form-switch">
          <input type="checkbox" class="form-check-input" id="AltMenuSw">
          <label class="form-check-label" for="AltMenuSw">Alt Menüleri Dahil Et</label>
          </div>';
    echo '<div class="row">';
    $accessValues = explode(",", $MenuYetkisi);
    $isChecked = "";
    $fimy_menus = $vt->listele("fimy_access_group","where Aktif=1 ORDER BY Level");
    if($fimy_menus != null) foreach( $fimy_menus as $menu ) {
            $Level = $menu['Level'];
            if($Level == 0){
              $disable = "disabled";
            }else{
              $disable = "";
            }
            $TrueFalse = in_array($Level,$accessValues);
            if($TrueFalse == 1){
              $isChecked = "checked";
            }else{
              $isChecked = "";
            }
            ?>
              <div class="col-lg-2">
                <input type="hidden" id="MenuID" value="<?php echo $MenuID; ?>">
                <input class="form-check-input" type="checkbox" value="<?php echo $menu['Level']; ?>" id="YetkiGrubu" <?php echo $disable; ?> <?php echo $isChecked; ?>>
                <label class="form-check-label" for="YetkiGrubu"><?php echo $menu['Access_Adi']; ?></label>
              </div>
              
          <?php

    }
    echo '<br><br>
    <div class="col-lg-12">
    <button id="YetkiDuzenleButon" class="btn btn-success waves-effect col-lg-12"> Düzenle </button>
    </div>';
    echo '</div>';
    ?>
    <script src="..\assets\js\fi-js\access-process.js" type="text/javascript"></script>
    <?php
	}
?>
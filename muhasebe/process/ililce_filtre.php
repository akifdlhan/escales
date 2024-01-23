<?php
include("../../src/iconlibrary.php");
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){
        // $ilID;
        
        $ilces = $vt->listele("fimy_ilce","WHERE ilID={$ilID}");
        if($ilces != null) foreach( $ilces as $ilce ) {
            echo '<option value="'.$ilce['ID'].'">'.$ilce['ilce'].'</option>';
        }
            
                }
?>
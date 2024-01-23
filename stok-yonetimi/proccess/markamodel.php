<?php
include("../../src/iconlibrary.php");
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){
        // $ilID;
        
        $fimy_model = $vt->listele("fimy_model","WHERE marka_id={$markaID}");
        if($fimy_model != null) foreach( $fimy_model as $mdl ) {
            echo '<option value="'.$mdl['model_id'].'">'.$mdl['model'].'</option>';
        }
            
                }
?>
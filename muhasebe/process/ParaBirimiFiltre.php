<?php
include("../../src/iconlibrary.php");
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){
        
            $icrm_kasalar = $vt->listele("fimy_kasa","WHERE ID={$kasa}");
            if($icrm_kasalar != null) foreach( $icrm_kasalar as $f ) {
                $KPB = $f['ParaBirimi'];
                $icrm_pb = $vt->listele("fimy_parabirimi","WHERE ID='".$KPB."'");
                if($icrm_pb != null) foreach( $icrm_pb as $pb ) {  
                  $exentedpb = $pb['Aciklama'];
                  echo '<b style="font-size:16px;">'.$exentedpb.'</b>';
                  echo '<input type="hidden" name="odemeparabirimi" id="odemeparabirimi" value='.$pb['ID'].'>';
                }
            }
            
                }
?>
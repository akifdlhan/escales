<?php
include("../../src/iconlibrary.php");   
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){

        if(empty($depoadi) || $deposorumlusu == 0 )
        {
                echo "Boş alanlar bulunmakta lütfen kontrol ediniz..";   

        }else{

            $fimy_depolar = $vt->ekle("fimy_depolar",array(
                    "depo_adi"=>$depoadi,
                    "sorumlu_id"=>$deposorumlusu
                ));

                    if($fimy_depolar > 0)
                    {                        
                       
                   $link = '../stok-yonetimi/depo-detay.php?DepoID='.$fimy_depolar.'&DepoName='.$depoadi;
                   echo '<script>setTimeout(function(){window.location.replace("'.$link.'");}, 2000);</script>';
                   echo '<div class="modal-content tx-size-sm" >
                        <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <i class="icon ion-checkmark tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                    <center> <h4 class="tx-success tx-semibold mg-b-20">Başarıyla Depo Oluşturulmuştur!</h4> </center>
                    </div><!-- modal-body -->
                        </div><!-- modal-content -->';
               
                    }


            


        }
        
}

?>
<?php
include("../../src/iconlibrary.php");   
$vt = new veritabani(); 
	extract($_POST);
	if($_POST){

        if(empty($KasaAdi) || empty($ABakiye) || empty($ParaBirimi))
        {
                echo "Boş alanlar bulunmakta lütfen kontrol ediniz..";   

        }else{
           
            //echo $KasaAdi;
            //echo $ABakiye;
            //echo $ParaBirimi;
            //echo $Aciklama;
            $ABakiye = str_replace(",", ".", $ABakiye);
            
            $icrm_kasalar = $vt->ekle("fimy_kasa",array(
                    "KasaAdi"=>$KasaAdi,
                    "AcilisBakiyesi"=>$ABakiye,
                    "Bakiye"=>$ABakiye,
                    "ParaBirimi"=>$ParaBirimi,
                    "Aciklama"=>$Aciklama
                ));

                    if($icrm_kasalar > 0)
                    {                        
                        $icrm_kasaparagc = $vt->ekle("fimy_kasaparagc",array(
                            "KasaID"=>$icrm_kasalar,
                            "Tur"=>1,
                            "Tutar"=>$ABakiye,
                            "Aciklama"=>"Açılış Bakiyesi"));

                   // Tur - 1 Satış, 2 Ekleme, 3 Giriş Yapıldı
                   // Durum - 1 Başarılı, 2 Başarısız
                   /*$icrm_log = $vt->ekle("icrm_log",array(
                       "MID"=>0,
                       "Tur"=>2,
                       "Tutar"=>"",
                       "Aciklama"=>$KasaAdi." ",
                       "Aciklama2"=>"",
                       "Durum"=>1));*/
                   $link = '../muhasebe/kasa-hareketleri.php?KasaID='.$icrm_kasalar.'';
                   echo '<script>setTimeout(function(){window.location.replace("'.$link.'");}, 2000);</script>';
                   echo '<div class="modal-content tx-size-sm" >
                        <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <i class="icon ion-checkmark tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-success tx-semibold mg-b-20">Başarıyla Kasa Oluşturulmuştur!</h4>
                    </div><!-- modal-body -->
                        </div><!-- modal-content -->';
               
                    }


            


        }
        
}

?>
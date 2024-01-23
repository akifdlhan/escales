<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9">
                    <div id="urun-listesi" class="card">
                        <div class="card-body">
                            <div id="dugmeler" style="margin:2px;"></div>
                            <table id="urunstoklistesi" class="table table-bordered dt-responsive table-responsive">
                                <thead>
                                    <tr>
                                        <th>Tc</th>
                                        <th>Personel Ad</th>
                                        <th>Personel Soyad</th>
                                        <th>Telefon</th>
                                        <th>Cinsiyet</th>
                                        <th>Departman</th>
                                        <th>Adres</th>
                                        <th>İl</th>
                                        <th>İlçe </th>
                                        <th>Başlama Tarihi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $fimy_personel = $vt ->listele("fimy_personel","ORDER BY UD DESC");
                                        if($fimy_personel!=null) foreach($fimy_personel as $personel){
                                            echo '
                                            <tr>
                                            <td class="text-center">
                                            <a href="PersonelID='.$personel['ID'].'">
                                            <i style="font-size:16px; color:darkblue;" class="ti-layout-tab"></i>
                                            </a>
                                            </td>
                                            <td>'.$personel['ID'].'</td>
                                            <td>'.$personel['Adi'].'</td>
                                            <td>'.$personel['Soyadi'].'</td>
                                            <td>'.$personel['Telefon'].'</td>
                                            <td>'.$personel['Cinsiyet'].'</td>
                                            <td>'.$persoenel['Departman'].'</td>
                                            <td>'.$persoenel['Adres'].'</td>
                                            <td>'.$persoenel['Il'].'</td>
                                            <td>'.$persoenel['Ilce'].'</td>
                                            <td>'.$persoenel['BaslamaTarihi'].'</td>
                                            </rt>';
                                        }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div> 
<script>
    $(document).ready(function(){
        var personellistesidiv = document.getElementById("personel-listesi");
        var personelYukseklik = personellistesidiv.clientHeight;
        var personelsayfasibutonlarDiv = document.getElementById("personelsayfasibutonlar");
        personelsayfasibutonlarDiv.style.height = personelYukseklik+"px";
    });
</script>
<!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
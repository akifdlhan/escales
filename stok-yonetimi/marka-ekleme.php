<?php include("../src/access.php"); ?>
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
                        <div class="col-lg-12">
                                    <h5>Marka Ekleme</h5>
                                </div>
                                <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group has-success mg-b-0">
                                        <input class="form-control" placeholder="Marka Adı" id="marka" required type="text" style="margin-bottom:10px;">
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->

                                <div class="col-lg-4 text-end">
                                    <button id="AddCustomer" class="btn btn-block btn-success col-lg-8">Ekle</button>
                                </div><!-- col-lg-6 -->
                                </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row row-sm">
                                <table id="menus-full" class="table table-bordered dt-responsive table-responsive" style="margin-bottom:10px;">
                                    <thead>
                                        <tr>


                                            <th>ID</th>
                                            <th>Marka Adı</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $fimy_marka = $vt->listele("fimy_marka");
                                        if ($fimy_marka != null) foreach ($fimy_marka as $marka) {

                                            echo '<tr>
                                                          
                                                            <td>' . $marka['marka_id'] . '</td>
                                                            <td>' . $marka['marka'] . '</td>
                                                            <td>
                                                            <a href=?markaId=' . $marka['marka_id'] . '&action=2>Sil</a> 
                                                           </td>
                                                        </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->


            </div> <!-- container -->


            <?php  
 if ($_GET) {
    $markaId = $_GET['markaId'];
    $fimy_marka_sil = $vt->sil("fimy_marka", "marka_id={$markaId}");
    
    if($fimy_marka_sil>0)
    {

        $fimy_model_sil = $vt->sil("fimy_model", "marka_id={$markaId}");
        $usermarkamodel = $vt->guncelle("fimy_urunler",array("model"=>0),"marka=$markaId"); // markaidye göre modelleri 0 yapacak
        $usermarkamodel = $vt->guncelle("fimy_user_new",array("marka"=>0),"marka=$markaId"); // markaidyi 0 yapacak
        echo ' 
        <script> toastr["success"]("Marka Silinmiştir");

        setTimeout(function() {
            window.location.href = window.location.href;
        }, 800);</script>    
        ';
    }
} else {
    
  }
 
 ?>
        </div> <!-- content -->
        <script>
                $("#AddCustomer").on("click", function() {
                    
                    var datastore = 'marka=' + $('#marka').val() ;
                      
                    $.ajax({
                        url: '../stok-yonetimi/proccess/markaadd.fi',
                        type: 'POST',
                        data: datastore,
                        success: function(e) {
                        //alert(e);
                            var responses = JSON.parse(e);
                            var RefreshChechk = responses[0].refresh;
                            if (RefreshChechk == 0) {

                                toastr[responses[0].status](responses[0].message);

                            } else {

                                toastr[responses[0].status](responses[0].message);

                                setTimeout(function() {
                                    window.location.href = window.location.href;
                                }, 800);

                            }
                        }
                    });

                });

        </script>
        <script>
            $(document).ready(function() {
                $("#menus-full").DataTable({
                    order: [
                        [0, 'desc']
                    ],
                    "lengthMenu": [5, 10, 15, 20, 50, 100]
                });
            });
        </script>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
        <?php include("../src/footer-alt.php"); ?>
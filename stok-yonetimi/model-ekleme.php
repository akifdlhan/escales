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
                                    <h5>Model Ekleme</h5>
                                </div>
                                <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group mg-b-0">
                                        <select id="marka" class="form-control select2">
                                            <option value="0">Marka..</option>
                                            <?php
                                            $markas = $vt->listele("fimy_marka");
                                            if ($markas != null) foreach ($markas as $marka) {
                                                echo '<option value="' . $marka['marka_id'] . '">' . $marka['marka'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                <div class="col-lg-6">
                                    
                                    <div class="form-group has-success mg-b-0">
                                        <input class="form-control" placeholder="Model" id="model" required type="text" style="margin-bottom:10px;">
                                    </div><!-- form-group -->
                                </div><!-- col-lg-6 -->
                                
                                <div class="col-lg-4 text-center">
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
                                            <th>Model Adı</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $fimy_model = $vt->listele("fimy_model");
                                        if ($fimy_model != null) foreach ($fimy_model as $model) {
                               
                                            $fimy_marka= $vt->listele("fimy_marka", "WHERE marka_id={$model['marka_id']}");
                                            // marka çekme
                                            if ($fimy_marka != null) foreach ($fimy_marka as $marka) {
                                                $markaadi = $marka['marka'];
                                            }

                                            echo '<tr>
                                                          
                                                            <td>' . $model['model_id'] . '</td>
                                                            <td>' . $markaadi . '</td>
                                                            <td>' . $model['model'] . '</td>
                                                            <td>
                                                            <a href=?modelId=' . $model['model_id'] . '&action=2>Sil </a> 
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
    $modelId = $_GET['modelId'];
    $fimy_model_sil = $vt->sil("fimy_model", "model_id={$modelId}");
    if($fimy_model_sil>0)
    {
     //  model silindikten sonra fimy_user_new tablosunda model_id fieldı modelId ile eşit olan tüm sütunları 0 olarak güncelle burada.
        $usermarkamodel = $vt->guncelle("fimy_urunler",array("model"=>0),"model=$modelId");
        echo ' 
        <script> toastr["success"]("Model Silinmiştir");

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
                    
                    var datastore = 
                        '&marka=' + $('#marka').val() +
                        '&model=' + $('#model').val();
                      
                    $.ajax({
                        url: '../stok-yonetimi/proccess/modeladd.fi',
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
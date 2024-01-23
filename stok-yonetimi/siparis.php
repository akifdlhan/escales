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
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="../stok-yonetimi/yeni-siparis.php" class="btn btn-success col-lg-12"> Sipariş Oluştur </a>
                                <!-- </div>
                                <div class="col-md-4">
                                    <button class="btn btn-blue col-lg-12"> Sipariş Düzenle </button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-warning col-lg-12"> Sipariş Formu Bastır </button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <h4>
                                    Tüm Siparişler
                                </h4>
                            </center>
                            <div style="margin: 2px;" id="dugmeler"></div>
                            <table id="urunstoklistesi" class="table table-bordered dt-responsive table-responsive">
                                <thead>
                                    <tr>
                                        <th> </th>
                                        <th> Sipariş Tarihi </th>
                                        <th> Sipariş No </th>
                                        <th> Müşteri </th>
                                        <th> Tahmini Teslim Tarihi </th>
                                        <th> Satış Sorumlusu </th>
                                        <th> Onay Durumu </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fimy_siparis_formu = $vt->listele("fimy_siparis_formu", "WHERE Pasif=1 ORDER BY ID DESC");
                                    if ($fimy_siparis_formu != null) foreach ($fimy_siparis_formu as $mst) {
                                        $fimy_cari_hesap = $vt->listele("fimy_cari_hesap", "WHERE ID={$mst['MusteriID']};");
                                        if ($fimy_cari_hesap != null) foreach ($fimy_cari_hesap as $cari) {
                                            $adi = $cari['Adi'];
                                            $soyadi = $cari['Soyadi'];
                                            $musteribilgi = $adi . " " . $soyadi;
                                        }
                                        $fimy_user_details = $vt->listele("fimy_user_details", "WHERE User_ID={$mst['SiparisAlan']};");
                                        if ($fimy_user_details != null) foreach ($fimy_user_details as $user) {
                                            $useradi = $user['Adi'];
                                            $usersoyadi = $user['Soyadi'];
                                            $useradisoyadi = $useradi . " " . $usersoyadi;
                                        }
                                        $onaybutonu = "";
                                        $yetkiSinif = $_SESSION['yetki'];
                                        if ($yetkiSinif == 0 || $yetkiSinif == 6) {
                                            if ($mst['Onay'] == 0) {
                                                $onaybutonu = '<div class="badge bg-danger float-start">
                                                <a style="color:white;" href="../stok-yonetimi/siparis-onayla.php?Siparis='. $mst['SiparisNo'] . '&ID=' . $mst['ID'] . '&Onay=0&User='.$_SESSION['KID'].'">Onaysız</a>
                                                </div>';
                                            }  else if ($mst['Onay'] == 1) {
                                                $onaybutonu = '<div class="badge bg-soft-success float-start">
                                                <a style="color:white;" href="../stok-yonetimi/siparis-onayla.php?Siparis='. $mst['SiparisNo'] . '&ID=' . $mst['ID'] . '&Onay=1&User='.$_SESSION['KID'].'">Onaylandı</a>
                                                </div>';
                                            } else if ($mst['Onay'] == 2) {
                                                $onaybutonu = '<div class="badge bg-success float-start">
                                                <a style="color:white;" href="#">Teslim Edildi</a>
                                                </div>';
                                            }
                                        }else{
                                            if ($mst['Onay'] == 0) {
                                                $onaybutonu = '<div class="badge bg-danger float-start">
                                                <a style="color:white;" href="#">Onaylanmadı</a>
                                                </div>';
                                            }  else if ($mst['Onay'] == 1) {
                                                $onaybutonu = '<div class="badge bg-soft-success float-start">
                                                <a style="color:white;" href="#">Onaylandı</a>
                                                </div>';
                                            } else if ($mst['Onay'] == 2) {
                                                $onaybutonu = '<div class="badge bg-success float-start">
                                                <a style="color:white;" href="#">Teslim Edildi</a>
                                                </div>';
                                            }
                                        }
                                        
                                        $siparisdetay = '<div class="badge bg-info float-start">
                                        <a style="color:white;" href="../stok-yonetimi/siparis-detay.php?Siparis='. $mst['SiparisNo'] . '&ID=' . $mst['ID'] . '">Sipariş Detay</a>
                                        </div>';
                                        echo '  <tr>
                                                <td>' . $mst['ID'] . '</td>
                                                <td>' . date("d.m.Y H:i", strtotime($mst['OlusturmaTarihi'])) . '</td>
                                                <td>' . $mst['SiparisNo'] . '</td>
                                                <td>' . $musteribilgi . '</td>
                                                <td>' . $mst['TahminiTeslim'] . '</td>
                                                <td>' . $useradisoyadi . '</td>
                                                <td>' . $onaybutonu  . $siparisdetay . '</td>   
                                                </tr>';
                                    }
                                    ?>
                                </tbody class=" bg-soft-info ">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->


        </div> <!-- container -->

    </div> <!-- content -->
    <script>
        $(document).ready(function() {
            var urunstoklistesi = $("#urunstoklistesi").DataTable({
                order: [[0, 'desc']],
                buttons: ["copy", "excel", "pdf"],
                "lengthMenu": [50, 100, 150, 250, 300]
            });
            // urunstoklistesi.buttons().container().appendTo("#urunstoklistesi_wrapper .col-md-6:eq(0)");
            urunstoklistesi.buttons().container().appendTo("#dugmeler");


        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
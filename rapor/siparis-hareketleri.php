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

                            <table id="siparisloglari" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>  </th>
                                        <th> Log </th>
                                        <th> Kullanıcı </th>
                                        <th> Depo </th>
                                        <th> Ürün </th>
                                        <th> İşlem Tarihi </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fimy_stok_log = $vt->listele("fimy_stok_log", "ORDER BY ID DESC");
                                    if ($fimy_stok_log != null) foreach ($fimy_stok_log as $stoklog) {
                                        $fimy_user_details = $vt->listele("fimy_user_details", "WHERE User_ID={$stoklog['UserID']};");
                                        if ($fimy_user_details != null) foreach ($fimy_user_details as $user) {
                                            $useradi = $user['Adi'];
                                            $usersoyadi = $user['Soyadi'];
                                            $useradisoyadi = $useradi . " " . $usersoyadi;
                                        }
                                        $depoadi = "";
                                        if (empty($stoklog['DepoID'])) {
                                        } else {
                                            $fimy_depolar = $vt->listele("fimy_depolar", "WHERE ID={$stoklog['DepoID']};");
                                            if ($fimy_depolar != null) foreach ($fimy_depolar as $depo) {
                                                $depoadi = $depo['depo_adi'];
                                            }
                                        }
                                        $urunadi = "";
                                        if (empty($stoklog['UrunID'])) {
                                        } else {
                                            $fimy_urunler = $vt->listele("fimy_urunler", "WHERE ID={$stoklog['UrunID']};");
                                            if ($fimy_urunler != null) foreach ($fimy_urunler as $urn) {
                                                $urunadi = $urn['urun_adi'] . " | " . $urn['StokKodu'];
                                            }
                                        }

                                    ?>
                                        <tr>
                                            <td> <?php echo $stoklog['ID']; ?> </td>
                                            <td> <?php echo $stoklog['Log']; ?> </td>
                                            <td> <?php echo $useradisoyadi; ?> </td>
                                            <td> <?php echo $depoadi; ?> </td>
                                            <td> <?php echo $urunadi; ?> </td>
                                            <td> <?php echo $stoklog['Procces_Date']; ?> </td>
                                        </tr>
                                    <?php
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

    </div> <!-- content -->
    <script>
        $(document).ready(function() {

            var urunstoklistesi = $("#siparisloglari").DataTable({
                buttons: ["copy", "excel", "pdf"],
                "lengthMenu": [50, 100, 150, 250, 300],
                order: [[0, 'desc']]
            });
            urunstoklistesi.buttons().container().appendTo("#dugmeler");
        });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div id="personel-listesi" class="card">
                        <div class="card-body">
                            <div id="dugmeler" style="margin: 2px;"></div>
                            <div class="table-responsive">
                                <table id="personelListesi" class="table table-bordered dt-responsive">
                                    <thead>
                                        <tr>
                                            <th>TC</th>
                                            <th>Adı</th>
                                            <th>Soyadı</th>
                                            <th>Telefon</th>
                                            <th>Cinsiyet</th>
                                            <th>Departman</th>
                                            <th>Adres</th>
                                            <th>İl</th>
                                            <th>İlçe</th>
                                            <th>Başlama Tarihi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $fimy_personel = $vt->listele("fimy_personel", "ORDER BY ID DESC");
                                        if ($fimy_personel != null) foreach ($fimy_personel as $personel) {
                                            echo '
                                            <tr>
                                            <td>' . $personel['TC'] . '</td>
                                            <td>' . $personel['Adi'] . '</td>
                                            <td>' . $personel['Soyadi'] . '</td>
                                            <td>' . $personel['Telefon'] . '</td>
                                            <td>' . $personel['Cinsiyet'] . '</td>
                                            <td>' . $personel['Departman'] . '</td>
                                            <td>' . $personel['Adres'] . '</td>
                                            <td>' . $personel['Il'] . '</td>
                                            <td>' . $personel['Ilce'] . '</td>
                                            <td>' . $personel['BaslamaTarihi'] . '</td>
                                            </tr>';
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
</div>
<script>
    $(document).ready(function () {
        var table = $('#personelListesi').DataTable({
            lengthMenu: [[50, 100, 250], [50, 100, 250]],
            order: [[0, 'asc']],
            dom: '<"top"lf<"wrapper"B>>rtip',
            buttons: ["copy", "excel", "pdf"],
        });

        $('#dugmeler').append($('.dt-buttons'));
    });
</script>
<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
<?php include("../src/footer-alt.php"); ?>

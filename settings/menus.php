<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
        <link href="../assets/libs/fullcalendar/main.min.css" rel="stylesheet" type="text/css" />
        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div style="margin-bottom:5px;" class="col-lg-12">
                            <a data-bs-toggle="modal" data-bs-target="#page-add-modal" class="btn btn-success waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a">
                                <i class="mdi mdi-plus"></i> Sayfa Ekle
                            </a>


                        </div>
                    </div>
                    <div class="collapse" id="YetkiDuzenle">
                        <div class="card">
                            <div class="card-body">
                                <div id="AccessEdit">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted font-14 mb-3">
                                Tüm menüleri buradan görebilir, ekleyebilir ve düzenleme yapabilirsiniz.
                            </p>

                            <table id="menus-full" class="table table-bordered dt-responsive table-responsive">
                                <thead>
                                    <tr>
                                        <th> </th>
                                        <th> Görünüm </th>
                                        <th>Sıra</th>
                                        <th>Üst Menü</th>
                                        <th>Folder Slug</th>
                                        <th>URL</th>
                                        <th>Icon</th>
                                        <th>Başlık</th>
                                        <th>Erişim Grupları</th>
                                        <th>Düzenle/Sil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fimy_menus = $vt->listele("fimy_menu");
                                    if ($fimy_menus != null) foreach ($fimy_menus as $menu) {
                                        ($menu['statu'] == 1) ? $s = '<i style="color:green !important;" class="ti-thumb-up"></i>' : $s = '<i style="color:red !important;" class="ti-thumb-down"></i>';
                                        ($menu['Gorunum'] == 1) ? $g = '<i style="color:green !important;" class="ti-eye"></i>' : $g = '<i style="color:red !important;" class="ti-eye"></i>';
                                        if (empty($menu['parent_id'])) {
                                            $parentadi = "";
                                        } else {
                                            $fimy_parent = $vt->listele("fimy_menu", "WHERE ID={$menu['parent_id']}");
                                            if ($fimy_parent != null) foreach ($fimy_parent as $parent) {
                                                $parentadi = $parent['title'];
                                            }
                                        }
                                        $access = explode(",", $menu['access']);
                                        $DiziBuyuk = count($access);
                                        $DegerleriAL = 1;
                                        $ViewGroup = "";
                                        foreach ($access as $grup) {
                                            $fimy_access_group = $vt->listele("fimy_access_group", "WHERE Level={$grup}");
                                            if ($fimy_access_group != null) foreach ($fimy_access_group as $fag) {

                                                $ViewGroup .= $fag['Access_Adi'];
                                                if ($DiziBuyuk == $DegerleriAL) {
                                                } else {
                                                    $ViewGroup .= ",";
                                                }
                                                $DegerleriAL++;
                                            }
                                        }

                                        echo '<tr>
                                                            <td><a href="menuaction.fi?status=' . md5($menu['statu']) . '&unique=' . $menu['ID'] . '&action=0">' . $s . '</td>
                                                            <td><a href="menugorunum.fi?gorunum=' . md5($menu['Gorunum']) . '&unique=' . $menu['ID'] . '&action=0">' . $g . '</td>
                                                            <td>' . $menu['position'] . '</td>
                                                            <td>' . $parentadi . '</td>
                                                            <td>' . $menu['folder'] . '</td>
                                                            <td><a href="' . $menu['url'] . '">' . $menu['url'] . '</a></td>
                                                            <td><i class="' . $menu['icon'] . '"></i></td>
                                                            <td>' . $menu['title'] . '</td>
                                                            <td style="font-size:10px;">' . $ViewGroup . '</td>
                                                            <td>
                                                            <center>
                                                            <a href="menuaction.fi?menu=' . $menu['folder'] . '&post=' . md5($menu['position']) . '&unique=' . $menu['ID'] . '&action=2"><i class="ti-trash"></i></a>
                                                            <i class="ti-marker-alt"></i>
                                                            <button class="btn btn-primary waves-effect waves-light duzenleme" type="button" data-bs-toggle="collapse" data-bs-target="#YetkiDuzenle" aria-expanded="false" aria-controls="YetkiDuzenle">
                                                            <i id="' . $menu['ID'] . '" class="fa fa-bomb EditID"></i>
                                                            </button> 
                                                            </center></td>
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

    </div> <!-- content -->
    <!-- Modal -->
    <div class="modal fade" id="page-add-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Sayfa Ekle</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label" for="name">Başlık <b>(*)</b></label>
                        <input type="text" class="form-control" id="title" placeholder="">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="parent">Üst Menü <b>(*)</b></label>
                                <select id="parent" class="form-select">
                                    <option value="0"></option>
                                    <?php
                                    $fimy_menus = $vt->listele("fimy_menu", "where position <> 0 and parent_id IS NULL");
                                    if ($fimy_menus != null) foreach ($fimy_menus as $menu) {
                                        echo '<option value="' . $menu['ID'] . '">' . $menu['title'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="position">Sıra <b>(*)</b></label>
                                <input type="text" class="form-control" id="position" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="url">URL <b>(*)</b></label>
                                <input type="text" class="form-control" id="url" placeholder="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="icon">İkon <b>(*)</b></label>
                                <a href="https://themify.me/themify-icons">İkon Setleri</a>
                                <input type="text" class="form-control" id="icon" value="ti-settings">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="YetkiGruplari">Yetki Grubu <b>(*)</b></label>
                                <br>
                                <?php
                                $fimy_menus = $vt->listele("fimy_access_group", "where Aktif=1");
                                if ($fimy_menus != null) foreach ($fimy_menus as $menu) {
                                ?>
                                    <input class="form-check-input" type="checkbox" value="<?php echo $menu['Level']; ?>" id="YetkiGrubu">
                                    <label class="form-check-label" for="YetkiGrubu"><?php echo $menu['Access_Adi']; ?></label><br>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <button id="submit-page" class="btn btn-success waves-effect waves-light me-1">Oluştur</button>
                    <div id="son"></div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script src="..\assets\js\fi-js\menus.js" type="text/javascript"></script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-body">

                        <?php
                        $fimy_notice = $vt->listele("fimy_notice");
                        if ($fimy_notice != null) foreach ($fimy_notice as $notice) {
                            $baslik = $notice['Title'];
                            $desc = $notice['desco'];
                            $checked = ($notice['Statu'] == 1) ? "checked" : " ";
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="card-title">Duyuru </h4>
                            </div>
                            <div class="col-sm-6">
                                <h5>
                                    <div style class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="notice-active" <?php echo $checked; ?>>
                                        <label class="form-check-label" for="notice-active">Pasif/Aktif</label>
                                    </div>
                                </h5>
                            </div>
                        </div>



                        <div class="mb-3">
                            <input type="hidden" id="notice-user" value="<?php echo $_SESSION['KID'];    ?>">
                            <label for="title" class="form-label">Duyuru Başlığı</label>
                            <input type="text" id="title" class="form-control" value="<?php echo $baslik; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="notice-desc" class="form-label">Duyuru Detayı</label>
                            <div id="notice-desc" style="height: 300px;">
                                <?php echo $desc; ?>
                            </div> <!-- end Snow-editor-->
                        </div>
                        <button id="notice-save" class="btn btn-primary">Kaydet</button>
                        <div id="son"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
        <script src="..\assets\js\fi-js\notice.js" type="text/javascript"></script>
    </div> <!-- content -->


    <!-- Init js-->
    <script>
    var quill = new Quill("#notice-desc", {
        theme: "snow",
        modules: {
            toolbar: [
                [{
                    font: ["Raleway"]
                }, {
                    size: []
                }],
                ["bold", "italic", "underline", "strike"],
                [{
                    color: []
                }, {
                    background: []
                }],
                [{
                    script: "super"
                }, {
                    script: "sub"
                }],
                [{
                    header: [!1, 1, 2, 3, 4, 5, 6]
                }, "blockquote", "code-block"],
                [{
                    list: "ordered"
                }, {
                    list: "bullet"
                }, {
                    indent: "-1"
                }, {
                    indent: "+1"
                }],
                ["direction", {
                    align: []
                }],
                ["link","image"],
                ["clean"],
            ]
        },
    });
    </script>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
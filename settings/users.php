<?php include("../src/access.php"); ?>
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-12"> <h4> Kullanıcılar <a data-bs-toggle="modal" data-bs-target="#page-add-modal" class="btn btn-success waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a">
                                                    <i class="mdi mdi-plus"></i> Kullanıcı Ekle
                                                </a> </h4>  </div>
                                            <?php
                                                    $fimy_us = $vt->ozellistele("SELECT fu.ID,fu.kullaniciadi,Mail,Adi,Soyadi,Resim,fuac.Access_Level,fag.Access_Adi,fu.Aktif FROM fimy_user_details fud, fimy_user fu, fimy_user_access fuac, fimy_access_group fag WHERE fud.User_ID=fu.ID and fuac.User_ID=fu.ID and fuac.Access_Level=fag.Level and fu.Aktif");
                                                    if($fimy_us != null) foreach( $fimy_us as $us ) {
                                                     ?>
                                                     <div class="col-sm-4">
                                               <div class="card">
                                    <div class="card-body widget-user">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-lg me-3 flex-shrink-0">
                                                <img src="<?php echo $us['Resim']; ?>" class="img-fluid rounded-circle" alt="<?php echo $us['Adi']." ".$us['Soyadi']; ?>">
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="mt-0 mb-1"><?php echo $us['Adi']." ".$us['Soyadi']; ?>
                                                <small class="text-primary"><a href="qrview.fi?User=<?php echo md5($us['kullaniciadi']); ?>&ID=<?php echo $us['ID']; ?>"><b><?php echo $us['kullaniciadi']; ?></b></a></small></h5>
                                                <p class="text-muted mb-2 font-13 text-truncate"><?php echo $us['Mail']; ?></p>
                                                <small class="text-warning"><b><?php echo $us['Access_Adi']; ?></b></small><br>
                                                <small class="text-danger"> <a href="useraction.php?Username=<?php echo md5($us['kullaniciadi']); ?>&ID=<?php echo $us['ID']; ?>"><i style="color:red;" class="ti-trash"></i>Sil</a></small>
                                                <small class="text-primary"> <a href="#"><i class="ti-marker-alt"></i>Düzenle</a></small>
                                                <small class="text-primary"> <a href="repass.fi?Username=<?php echo md5($us['kullaniciadi']); ?>&ID=<?php echo $us['ID']; ?>"><i class="ti-key"></i>Parola</a> </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                                <?php } ?>
                        </div>
                        <!-- end row -->        
                        <!-- Button trigger modal -->                    
                    </div> <!-- container -->

                </div> <!-- content -->
           <!-- Modal -->
           <div class="modal fade" id="page-add-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Kullanıcı Ekle</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="username">Kullanıcı Adı <b>(*)</b></label>
                            <input type="hidden" id="username-data">
                            <input type="text" class="form-control" id="username-view" placeholder="" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="parent">Şifre <b>(*)</b></label>
                                    <input type="text" class="form-control" id="sifre" placeholder="">
                                    <small id="passcontrol"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="position">Şifre Tekrar <b>(*)</b></label>
                                    <input type="text" class="form-control" id="sifre-tekrar">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="parent">Adı <b>(*)</b></label>
                                    <input type="text" class="form-control" id="adi" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="position">Soyadı <b>(*)</b></label>
                                    <input type="text" class="form-control" id="soyadi" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="parent">Telefon <b>(*)</b></label>
                                    <input type="tel" class="form-control" id="telefon" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="position">Mail <b>(*)</b></label>
                                    <input type="mail" class="form-control" id="mail" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="parent">Adres <b>(*)</b></label>
                                    <textarea class="form-control" name="adres" id="adres" cols="30" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="yetki">Yetki Grubu <b>(*)</b></label>
                                        <select class="form-control" name="yetki" id="yetki-id">
                                        <option value="100"> Yetki Grubu</option>
                                        <?php
                                        $fimy_menus = $vt->listele("fimy_access_group","where Aktif=1 ORDER BY Level");
                                        if($fimy_menus != null) foreach( $fimy_menus as $menu ) {
                                                echo '<option value="'.$menu['Level'].'">'.$menu['Access_Adi'].'</option>';
                                        }
                                        ?>
                                        </select>
                                        <small id="yetkikontrol"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button id="kullanici-olustur" class="btn btn-success waves-effect waves-light me-1 col-md-12">Oluştur</button>
                                <div id="son"></div>
                            </div>
                        </div>    
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script src="..\assets\js\fi-js\users.js" type="text/javascript"></script>
                        
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
<?php include("../src/footer-alt.php"); ?>
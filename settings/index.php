<?php include("../src/access.php"); ?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <?php
                $currentPage = $_SERVER['PHP_SELF'];
                $domain = $_SERVER['HTTP_HOST'];
                $arraydegiskeni = 2;
                if($domain == "localhost"){
                    $arraydegiskeni = 2;
                }else{
                    $arraydegiskeni = 1;
                }
                
                $acss = "";
                //position <> 0 and
                $fimy_menus = $vt->listele("fimy_menu", "WHERE Gorunum=1 and position <> 0 and statu=1 and FIND_IN_SET(" . $User_Yetki_Grubu . ", access) ORDER BY position ASC");
                if ($fimy_menus != null) foreach ($fimy_menus as $menu) {


                    if ($menu['parent_id'] == NULL) {
                        $parent_check = $vt->ozellistele("select count(ID) as Sayim from fimy_menu WHERE Gorunum=1 and parent_id={$menu['ID']} and FIND_IN_SET(" . $User_Yetki_Grubu . ", access)");
                        if ($parent_check != null) foreach ($parent_check as $parent_c) {
                            $altmenu_say = $parent_c['Sayim'];
                        }

                        if ($altmenu_say > 0) {
                            $dbden = explode("/", $menu['url']);
                            $vtdengelen = $dbden[1];
                            $men = explode("/", $currentPage);
                            $clientdangelen = $men[$arraydegiskeni];
                            if ($vtdengelen == $clientdangelen) {

                                $parent_check = $vt->listele("fimy_menu", "WHERE Gorunum=1 and statu=1 and parent_id={$menu['ID']} and FIND_IN_SET(" . $User_Yetki_Grubu . ", access) ORDER BY position ASC");
                                if ($parent_check != null) foreach ($parent_check as $parent_c) {
                ?>
                                    <div class="col-lg-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <center>
                                                            <img style="height:50px;" src="<?php echo $logo; ?>" alt="<?php echo $firma; ?>">
                                                        </center>
                                                    </div>
                                                    <div style="display: flex;align-items: center;justify-content: center;" class="col-lg-8">
                                                        <center>
                                                            <h5>
                                                                <a href="<?php echo $parent_c['url']; ?>"> <?php echo $parent_c['title']; ?> </a>
                                                            </h5>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                <?php
                                }
                            }
                        } else {
                            echo "Alt Menü Mevcut Değildir.";
                        }
                    }
                }
                ?>
            </div>
            <!-- end row -->


        </div> <!-- container -->

    </div> <!-- content -->

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <?php include("../src/footer-alt.php"); ?>
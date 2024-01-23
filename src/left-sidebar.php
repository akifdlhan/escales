<?php include("../src/header.php"); ?>
<!-- body start -->

<body class="loading" data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="scrollable" data-leftbar-color="light" data-leftbar-size="default" data-sidebar-user='true'>

    <!-- Begin page -->
    <div id="wrapper">
        <?php
        $UID = $_SESSION['KID'];
        $user_details = $vt->ozellistele("select count(ap.ID) as Say, ap.ID, ap.kullaniciadi, ua.Access_Level, ud.Adi, ud.Soyadi, ud.Mail, ud.TelefonNo, ud.Resim
    from fimy_user ap, fimy_user_access ua, fimy_access_group ag, fimy_user_details ud
    where
    (ap.ID = ud.User_ID)
    and (ap.ID = ua.User_ID)
    and (ua.Access_Level = ag.Level)
    and ap.ID={$UID}");
        if ($user_details != null) foreach ($user_details as $user) {

            $kullanici = $user['kullaniciadi'];
            $adi = $user['Adi'];
            $soyadi = $user['Soyadi'];
            $resim = $user['Resim'];
            $access = $user['Access_Level'];
        }
        $access_details = $vt->ozellistele("SELECT ua.Access_Level, ag.Access_Adi, ua.User_ID FROM fimy_user_access ua, fimy_access_group ag where ua.Access_Level=ag.Level and ua.User_ID={$UID}");
        if ($access_details != null) foreach ($access_details as $access) {
            $access_name = $access['Access_Adi'];
        }

        ?>
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-end mb-0">

                <?php //ARAMA VE BİLDİRİM KISIMI BURADAYDI.. 
                ?>

                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="<?php echo $resim; ?>" alt="user-image" class="rounded-circle">
                        <span class="pro-user-name ms-1">
                            <?php echo $kullanici; ?> <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Hoşgeldin !</h6>
                        </div>

                        <!-- item-->
                        <a href="../settings/profil.php" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>Hesabım</span>
                        </a>

                        <!-- item-->
                        <a href="../src/hava.php" class="dropdown-item notify-item">
                            <i class="fe-cloud"></i>
                            <span>Hava Güncelle</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a href="../logout/logoff.php" class="dropdown-item notify-item">
                            <i class="fe-log-out"></i>
                            <span>Çıkış</span>
                        </a>

                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                        <i class="fe-settings noti-icon"></i>
                    </a>
                </li>

            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <a href="../fpanel" class="logo logo-light text-center">
                    <span class="logo-sm">
                        <img src="<?php echo $logo; ?>" alt="" height="28">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo $logo; ?>" alt="" height="97">
                    </span>
                </a>
                <a href="../fpanel" class="logo logo-dark text-center">
                    <span class="logo-sm">
                        <img src="<?php echo $logo; ?>" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo $logo; ?>" alt="" height="100">
                    </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
                <li>
                    <button class="button-menu-mobile disable-btn waves-effect">
                        <i class="fe-menu"></i>
                    </button>
                </li>
                <li>
                    
                    <h4 id="page-title-main" class="page-title-main col-lg-12">
                       
                        <?php
                        $currentPage = $_SERVER['REQUEST_URI'];
                        if (strstr($currentPage, "?")) {
                            $SoruIsareti = explode("?", $currentPage);
                            $men = explode("/", $SoruIsareti[0]);
                        } else {
                            $men = explode("/", $currentPage);
                        }
                        // $men = explode("/",$currentPage);
                        $sonindis = end($men);
                        $cm = count($men);
                        $slug = $men[$cm - 2];
                        if ($sonindis == "") {
                            $sorgudegiskeni = $slug;
                        } else {
                            $sorgudegiskeni = $sonindis;
                        }
                        $fimy_menus = $vt->listele("fimy_menu", "WHERE statu=1 and folder='" . $sorgudegiskeni . "'");
                        if ($fimy_menus != null) {
                            foreach ($fimy_menus as $menu) {
                                // echo '<marquee behavior="" direction="right"> Dolar - </marquee>';
                                //echo $TopHeader = $menu['title'];
                                 echo '<title>'.$menu['title'].' | Fi My </title>';
                            }
                        } else {
                            echo "Dashboard";
                            echo '<title> Dashboard | Fi My </title>';
                        }
                        ?>
                    </h4>
                </li>

            </ul>

            <div class="clearfix"></div>

        </div>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="h-80" data-simplebar>

                <!-- User box -->
                <div class="user-box text-center">

                    <img style="margin-top: 15px;" src="<?php echo $resim; ?>" alt="<?php echo $adi . " " . $soyadi; ?>" title="<?php echo $adi . " " . $soyadi; ?>" class="rounded-circle img-thumbnail avatar-md">
                    <div class="dropdown">
                        <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $adi . " " . $soyadi; ?></a>
                    </div>
                    <p class="text-muted left-user-info"><?php echo $access_name; ?></p>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul id="side-menu">

                        <li class="menu-title">Menü</li>
                        <li>
                            <a href="../fpanel/dashboard.php">
                                <i class="mdi mdi-view-dashboard-outline"></i>
                                <span class="badge bg-success rounded-pill float-end"></span>
                                <span> Dashboard </span>
                            </a>
                        </li>
                        <?php
                        $currentPage = $_SERVER['PHP_SELF'];
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
                                    $cssto = '';
                                    $css = "";
                                    $acss = "";
                                    $dbden = explode("/", $menu['url']);
                                    $vtdengelen = $dbden[1];
                                    $men = explode("/", $currentPage);
                                    $clientdangelen = $men[2];
                                    if ($vtdengelen == $clientdangelen) {
                                        $cssto = 'class="menuitem-active"';
                                        $css = "show";
                                        $acss = 'class="active"';
                                    }
                                    echo '<li ' . $cssto . '>
                                        <a href="#' . $menu['folder'] . '" data-bs-toggle="collapse">
                                                <i class="' . $menu['icon'] . '"></i>
                                                <span class="badge bg-success rounded-pill float-end"></span>
                                                <span> ' . $menu['title'] . ' </span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="collapse ' . $css . '" id="' . $menu['folder'] . '">
                                            <ul class="nav-second-level">';

                                    $parent_check = $vt->listele("fimy_menu", "WHERE Gorunum=1 and statu=1 and parent_id={$menu['ID']} and FIND_IN_SET(" . $User_Yetki_Grubu . ", access) ORDER BY position ASC");
                                    if ($parent_check != null) foreach ($parent_check as $parent_c) {
                                        echo '<li>
                                <a  href="' . $parent_c['url'] . '">' . $parent_c['title'] . '</a>
                            </li>';
                                    }
                                    echo '</ul>
                                        </div>
                                        </li>';
                                } else {
                                    echo '<li>
                            <a ' . $acss . ' href="' . $menu['url'] . '">
                                    <i class="' . $menu['icon'] . '"></i>
                                    <span class="badge bg-success rounded-pill float-end"></span>
                                    <span> ' . $menu['title'] . ' </span>
                                </a>
                            </li>';
                                }
                            }
                        }
                        ?>
                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->
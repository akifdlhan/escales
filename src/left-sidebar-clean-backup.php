<?php include("../src/header.php"); ?>
<!-- body start -->
<body class="loading" data-layout-color="light"  data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="scrollable" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>

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
            if($user_details != null) foreach( $user_details as $user ) {
                
                $kullanici = $user['kullaniciadi'];
                $adi = $user['Adi'];
                $soyadi = $user['Soyadi'];
                $resim = $user['Resim'];
                $access = $user['Access_Level'];
            }
            $access_details = $vt->ozellistele("SELECT ua.Access_Level, ag.Access_Adi, ua.User_ID FROM fimy_user_access ua, fimy_access_group ag where ua.Access_Level=ag.Level and ua.User_ID={$UID}");
                    if($access_details != null) foreach( $access_details as $access ) {
                        $access_name = $access['Access_Adi'];
                    }

    ?>
    <!-- Topbar Start -->
    <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-end mb-0">

                <li class="d-none d-lg-block">
                    <form class="app-search">
                        <div class="app-search-box">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Ara..." id="top-search">
                                <button class="btn input-group-text" type="submit">
                                    <i class="fe-search"></i>
                                </button>
                            </div>
                            <div class="dropdown-menu dropdown-lg" id="search-dropdown">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h5 class="text-overflow mb-2">Found 22 results</h5>
                                </div>
    
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-home me-1"></i>
                                    <span>Analytics Report</span>
                                </a>

                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow mb-2 text-uppercase">Users</h6>
                                </div>

                                <div class="notification-list">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="d-flex align-items-start">
                                            <img class="d-flex me-2 rounded-circle" src="assets/images/users/user-2.jpg" alt="Generic placeholder image" height="32">
                                            <div class="w-100">
                                                <h5 class="m-0 font-14">Erwin E. Brown</h5>
                                                <span class="font-12 mb-0">UI Designer</span>
                                            </div>
                                        </div>
                                    </a>
                                    
                                </div>
    
                            </div> 
                        </div>
                    </form>
                </li>

                <li class="dropdown d-inline-block d-lg-none">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="fe-search noti-icon"></i>
                    </a>
                    <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                        <form class="p-3">
                            <input type="text" class="form-control" placeholder="Ara ..." aria-label="Recipient's username">
                        </form>
                    </div>
                </li>
    
                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="fe-bell noti-icon"></i>
                        <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                <span class="float-end">
                                    <a href="" class="text-dark">
                                        <small>Clear All</small>
                                    </a>
                                </span>Notification
                            </h5>
                        </div>

                        <div class="noti-scroll" data-simplebar>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                <div class="notify-icon">
                                    <img src="../assets/images/users/user-1.jpg" class="img-fluid rounded-circle" alt="" /> </div>
                                <p class="notify-details"><?php echo $kullanici; ?></p>
                                <p class="text-muted mb-0 user-msg">
                                    <small>Hi, How are you? What about our next meeting</small>
                                </p>
                            </a>

                        </div>

                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                            Tümünü Gör
                            <i class="fe-arrow-right"></i>
                        </a>

                    </div>
                </li>

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
                        <a href="contacts-profile.html" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>Hesabım</span>
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
                        <img src="../assets/images/logo-sm.png" alt="" height="28">
                    </span>
                    <span class="logo-lg">
                        <img src="../assets/images/logo-light.png" alt="" height="22">
                    </span>
                </a>
                <a href="../fpanel" class="logo logo-dark text-center">
                    <span class="logo-sm">
                        <img src="../assets/images/logo-sm.png" alt="" height="28">
                    </span>
                    <span class="logo-lg">
                        <img src="../assets/images/logo-dark.png" alt="" height="22">
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
                    <h4 class="page-title-main">Dashboard</h4>
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

                <img src="<?php echo $resim; ?>" alt="<?php echo $adi." ".$soyadi; ?>" title="<?php echo $adi." ".$soyadi; ?>" class="rounded-circle img-thumbnail avatar-md">
                    <div class="dropdown">
                        <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown"  aria-expanded="false"><?php echo $adi." ".$soyadi; ?></a>
                    </div>
                <p class="text-muted left-user-info"><?php echo $access_name; ?></p>
            </div>

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul id="side-menu">

                    <li class="menu-title">Menü</li>
                    <li>
                        <a href="../fpanel">
                            <i class="ti-direction-alt"></i>
                            <span class="badge bg-success rounded-pill float-end"></span>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ti-package"></i>
                            <span class="badge bg-success rounded-pill float-end"></span>
                            <span> Stok </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ti-id-badge"></i>
                            <span class="badge bg-success rounded-pill float-end"></span>
                            <span> Personel </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ti-notepad"></i>
                            <span class="badge bg-success rounded-pill float-end"></span>
                            <span> Muhasebe </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ti-archive"></i>
                            <span class="badge bg-success rounded-pill float-end"></span>
                            <span> Envanter </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ti-agenda"></i>
                            <span class="badge bg-success rounded-pill float-end"></span>
                            <span> Raporlar </span>
                        </a>
                    </li>
                    <li>
                        <a href="#settings" data-bs-toggle="collapse">
                            <i class="ti-settings"></i>
                            <span class="badge bg-success rounded-pill float-end"></span>
                            <span> Ayarlar </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="settings">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="../settings/menus.php">Menüler</a>
                                        </li>
                                        <li>
                                            <a href="../settings/users.php">Kullanıcılar</a>
                                        </li>
                                        <li>
                                            <a href="../settings/usergroup.php">Roller</a>
                                        </li>
                                        <li>
                                            <a href="../settings/notice.php">Duyuru</a>
                                        </li>
                                        <li>
                                            <a href="../settings/smtp.php">SMTP</a>
                                        </li>
                                        <li>
                                            <a href="../settings/passrules.php">Şifre Gereksinimleri</a>
                                        </li>
                                        <li>
                                            <a href="../settings/about-us.php">Hakkında</a>
                                        </li>
                                    </ul>
                                </div>
                    </li>
                    
                </ul>

            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->
<?php
include("../src/access-my-dashboard.php");
echo '<title> Dashboard | Fi My </title>';
$sehir = "istanbul";
$WeatherUpdate = updateWeatherInDatabase($sehir, $vt);
?>

    <body class="loading authentication-bg">

        <div class="mt-5 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div style="margin-left:50px;" class="text-start"> 
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

                                $saat = date('H'); // Saati alın (24 saat formatında)

                                if ($saat >= 6 && $saat < 8) {
                                    $mesaj = 'Günaydın';
                                }elseif ($saat >= 8 && $saat < 12) {
                                    $mesaj = 'İyi Çalışmalar';
                                }elseif ($saat >= 12 && $saat < 18) {
                                    $mesaj = 'İyi Günler';
                                }elseif ($saat >= 18 && $saat < 22) {
                                    $mesaj = 'İyi Akşamlar';
                                } else {
                                    $mesaj = 'İyi Geceler';
                                }
                                ?>
                                    <h2 style="color:#0e2d67 !important;" class="mt-4"><?php echo $mesaj; ?>, <br><font style="font-weight: 100"><?php echo $adi." ".$soyadi; ?>!</font></h2>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div style="margin-right:50px;" class="text-end">
                                <div class="col-lg-12">
                                    <div id="menu-bar" class="row">
                                        <div class="col-md-6" id="col-saat">
                                            <div class="card" style="background-color: transparent !important;">
                                                <div class="card-body">
                                                    <div class="avatar-md rounded-circle mx-auto">
                                                        </div>
                                                    <script type="text/javascript">
                                                        window.onload = startTime;
                                                        function startTime()
                                                        {
                                                         var today=new Date();
                                                         var h=today.getHours();
                                                         var m=today.getMinutes();
                                                         var s=today.getSeconds();
                                                         h=checkTime(h);
                                                         m=checkTime(m);
                                                         s=checkTime(s);
                                                         document.getElementById('saat').innerHTML=h+":"+m;
                                                         t=setTimeout('startTime()',1000);
                                                        }
                                                        
                                                        function checkTime(i)
                                                        {
                                                        if (i<10)
                                                         {
                                                          i="0" + i;
                                                         }
                                                        return i;
                                                        }
                                                        </script>
                                                        <?php setlocale(LC_TIME, 'tr-TR.UTF-8'); date_default_timezone_set('Europe/Istanbul'); ?>
                                                    <h5 id="saat" class="text-uppercase mt-3">00:00:00</h5>
                                                    <p id="saat-yazi"  class="text-muted" > <?php echo strftime('%d.%m.%Y %A'); ?> </p>
                                                    
                                                </div>
                                            </div>
                                        </div> <!-- end col-->
                                        <div class="col-md-6" id="col-hava">
                                            <div class="card" style="margin-left: -20px !important; background-color: transparent !important;">
                                                <div class="card-body">
                                                    <?php 
                                                    $sor = $vt->listele("fimy_hava","WHERE ID=1");
                                                    if($sor != null) foreach( $sor as $s ) { 
                                                        if($s['Derece'] > 0){                                                       
                                                    ?>
                                                    <div id="hava-ico" class="avatar-md rounded-circle mx-auto">
                                                        <?php echo '<img class="avatar-title text-primary" src="'.$s['Svg'].'" width="56" height="56">'; ?>
                                                    </div>
                                                    <h6 id="hava" class="text-uppercase mt-3"><?php echo $s['Derece']; ?><font style="font-size:16px;">°C</font></h6>
                                                    <p id="hava-yazi" > <?php echo $s['Durum']." - ".$s['Sehir']; ?> </p>
                                                    <?php 
                                                    }
                                                } ?>
                                                </div>
                                            </div>
                                        </div> <!-- end col-->
                                    </div>
                                </div>    <!-- end head row-->
                                </div>
                            </div>
                        </div>
                    
                    
                        <div id="text-menu-top" class="text-center">                            
                            <p class="text-muted">  </p>

                            <div class="row mt-5">
                                <style>
                                    @media (min-width:800px) { }
                                        #menu-bar > * {
                                            margin-top: -50px !important;
                                        }
                                </style>
                                <div class="col-lg-8">
                                    <div id="menu-bar" class="row">
                                        <?php
                                        if (isset($_COOKIE['username'])) {
                                            // 'username' anahtarı tanımlı
                                            $username = $_COOKIE['username'];
                                        } else {
                                            setcookie("MyCookieFi", $_SESSION['KID'], 0,"/");
                                        }
                                         ?>
                                        <div class="col-md-3">
                                            <div class="card" style="background-color: transparent !important;">
                                                <div class="card-body">
                                                    <a href="./dashboard.php">
                                                    <div class="avatar-md rounded-circle mx-auto">
                                                    <i style="color:#0e2d67 !important; font-size:42px;" class="mdi mdi-view-dashboard-outline avatar-title text-primary"></i>
                                                    </div>
                                                    <h5 style="margin-top: -2px !important;" class="mt-3"> Dashboard </h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div> <!-- end col-->
                                        <?php 
                                        $User_Yetki_Grubu = $_SESSION['yetki'];
                                            $fimy_menus = $vt->listele("fimy_menu","WHERE Gorunum=1 and position <> 0 and statu=1 and FIND_IN_SET(".$User_Yetki_Grubu.", access) ORDER BY position ASC");
                                            if($fimy_menus != null) foreach( $fimy_menus as $menu ) {

                                                if($menu['parent_id'] == NULL){
                                                echo '<div class="col-md-3">
                                                <div class="card" style="background-color: transparent !important;">
                                                    <div class="card-body">
                                                        <a href="'.$menu['url'].'">
                                                        <div class="avatar-md rounded-circle mx-auto">
                                                            <i style="color:#0e2d67 !important; font-size:42px;" class="'.$menu['icon'].' avatar-title text-primary"></i>
                                                        </div>
                                                        <h5 style="margin-top: -2px !important;" class="mt-3">'.$menu['title'].'</h5>
                                                    </a>
                                                    </div>
                                                </div>
                                            </div> <!-- end col-->';
                                                }
                                                    
                                            }
                                            ?>
                                        <div class="col-md-3">
                                            <div class="card" style="background-color: transparent !important;">
                                                <div class="card-body">
                                                    <a href="../logout/logoff.php">
                                                    <div class="avatar-md rounded-circle mx-auto">
                                                        <i style="color:#0e2d67 !important;  font-size:42px;" class="ti-power-off font-28 avatar-title text-primary"></i>
                                                    </div>
                                                    <h5 style="margin-top: -2px !important;" class="mt-3">Çıkış</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div> <!-- end col-->
                                    </div>
                                </div><!-- end col-lg-8 -->
                                <div class="col-lg-4">
                                    <div id="menu-bar" class="row">
                                    <div class="col-md-6">
                                            <div class="card" style="background-color: transparent !important;">
                                                <div class="card-body">
                                                    <a href="#">
                                                    <div class="avatar-md rounded-circle mx-auto">
                                                    </div>
                                                    <h5 style="margin-top: -2px !important;" class="mt-3"> </h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div> <!-- end col-->
                                        <div class="col-md-4">
                                            <div class="card" style="background-color: transparent !important;">
                                                <div class="card-body">
                                                    <a href="#user-id=<?php echo $UID; ?>&user=<?php echo $kullanici; ?>">
                                                    <div class="avatar-md rounded-circle mx-auto">
                                                    <img src="<?php echo $resim; ?>" alt="<?php echo $kullanici; ?>" title="<?php echo $adi." ".$soyadi; ?>" class="rounded-circle img-thumbnail avatar-md">
                                                    </div>
                                                    <h5 style="margin-top: -2px !important;" class="mt-3"><?php echo $kullanici; ?></h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div> <!-- end col-->
                                        <div class="col-md-12">
                                            <div class="card" style="background-color: transparent !important;">
                                                <div class="card-body text-center">
                                                        <?php       
                                                        $siteoptions = $vt->listele("fimy_appoptions");
                                                        if($siteoptions != null) foreach( $siteoptions as $opt ) {
                                                            $firma = $opt['FirmaAdi'];
                                                            $logo = $opt['Logo'];
                                                        }
                                                        ?>
                                                    <div class="avatar-md rounded-circle mx-auto">
                                                    <center>
                                                    <img src="<?php echo $logo; ?>" alt="<?php echo $firma; ?>" title="<?php echo $firma; ?>" style="max-width: 120px; width: auto;">
                                                    </center>
                                                    </div>
                                                    <h5 style="margin-top: -2px !important;" class="mt-3"><?php echo ""; ?></h5>
                                                </div>
                                            </div>
                                        </div> <!-- end col-->
                                    </div>
                                </div>    <!-- end head row-->
                                <?php
                                $fimy_notice = $vt->ozellistele("SELECT n.Title, n.desco, n.Lastupdate, u.kullaniciadi, n.Statu FROM fimy_notice n, fimy_user u WHERE n.User=u.ID and n.Statu=1");
                                if($fimy_notice != null) foreach( $fimy_notice as $notice ) {
                                    echo '
                                    <div class="col-md-8">
                                    <h5 style="color:#0e2d67;">'.$notice['Title'].'</h5>
                                    <p style="color:#0e2d67;">'.$notice['desco'].'</p>
                                    <div class="row">
                                        <div class="col-lg-6">
                                        <p style="color:#0e2d67;text-align:left;">'.$notice['Lastupdate'].'</p>
                                        </div>
                                        <div class="col-lg-6">
                                        <p style="color:#0e2d67;text-align:right;">'.$notice['kullaniciadi'].'</p>
                                        </div>       
                                    </div>       
                                    
                                    </div>        
                                    ';
                                }
                                    ?>
                            </div> <!-- end row-->

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- App js -->
    <?php include("../src/footer-end.php"); ?>
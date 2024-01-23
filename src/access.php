<?php
session_start();
ob_start();
setlocale(LC_TIME, "turkish");
setlocale(LC_ALL, 'turkish');
include("../src/iconlibrary.php");
include("../src/private_custom.php");
$vt = new veritabani();
$fi = new fislash();

if (empty($_SESSION['aktif'])) {
    
    session_destroy();

    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-3600);
            setcookie($name, '', time()-3600, '/');
        }
    }
    header('Location: ../../index.php');
    exit();
} else {
    if ($_SESSION['aktif'] == 1) {
        if (isset($_SESSION['yetki'])) {
            $User_Yetki_Grubu = $_SESSION['yetki'];
            $currentPage = $_SERVER['REQUEST_URI'];
            if (strstr($currentPage, "?")) {
                $SoruIsareti = explode("?", $currentPage);
                $men = explode("/", $SoruIsareti[0]);
            } else {
                $men = explode("/", $currentPage);
            }
            //$men = explode("/",$currentPage);
            $sonindis = end($men);
            $cm = count($men);
            $slug = $men[$cm - 2];
            if ($sonindis == "") {
                $sorgudegiskeni = $slug;
            } else {
                $sorgudegiskeni = $sonindis;
            }
            //$fimy_menus = $vt->listele("fimy_menu","WHERE statu=1 and folder='".$sorgudegiskeni."'");
            $fimy_menus = $vt->ozellistele("select count(ID) as KontrolSayisi from fimy_menu WHERE statu=1 and folder='" . $sorgudegiskeni . "' and FIND_IN_SET(" . $User_Yetki_Grubu . ", access)");
            if ($fimy_menus != null) foreach ($fimy_menus as $menu) {
                $KontrolDegiskeni = $menu['KontrolSayisi'];
            }
            if ($KontrolDegiskeni > 0) {
                include("../src/left-sidebar.php");
            } else {
                header('Location: ../src/401.php');
                exit();
            }
            /*if ($_SESSION['yetki'] == 0 || $_SESSION['yetki'] == 1 || $_SESSION['yetki'] == 2 || $_SESSION['yetki'] == 3 || $_SESSION['yetki'] == 4 ) {
      include("../src/left-sidebar.php");
    }else {
        header('Location: ../src/401.php');
        exit();
    }*/
        } else {
            header('Location: ../src/401.php');
            exit();
        }
    } else if ($_SESSION['aktif'] == 0) {
        header('Location: ../src/401.php');
        exit();
    } else {
        header('Location: ../src/401.php');
        exit();
    }
}

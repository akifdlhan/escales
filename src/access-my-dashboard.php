<?php
session_start();
ob_start();
setlocale(LC_TIME, "turkish");
setlocale(LC_ALL, 'turkish');
include("../src/iconlibrary.php");
$vt = new veritabani();
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
            include("../src/header.php");
            /*if ($_SESSION['yetki'] == 0 || $_SESSION['yetki'] == 1 || $_SESSION['yetki'] == 2 || $_SESSION['yetki'] == 3 || $_SESSION['yetki'] == 4 || $_SESSION['yetki'] == 5 ) {
      
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

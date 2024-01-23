<?php
session_start();
ob_start(); 
if(empty($_SESSION['yetki']))
{
     header('Location: ..\index.php');
}
else
{
if($_SESSION['aktif'] == 1 ){
if (isset($_SESSION['yetki'])) {
    if ($_SESSION['yetki'] == 1 || $_SESSION['yetki'] == 2 || $_SESSION['yetki'] == 3 ) {
      include("../src/header.php");
    }else {
        header('Location: ../src/401.php');
        exit();
    }
}
 else {
    header('Location: ../src/401.php');
    exit();
}
}else if($_SESSION['aktif'] == 0 )
{
    header('Location: ../src/401.php');
    exit();
}else{
    header('Location: ../src/401.php');
    exit();
}
}
?>
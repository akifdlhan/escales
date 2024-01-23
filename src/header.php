<?php @session_start();
ob_start();
//setlocale(LC_TIME, "turkish");
//setlocale(LC_ALL,'turkish');
//include("../src/iconlibrary.php");
//$vt = new veritabani(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <?php
    $siteoptions = $vt->listele("fimy_appoptions");
    if ($siteoptions != null) foreach ($siteoptions as $opt) {
        $firma = $opt['FirmaAdi'];
        $logo = $opt['Logo'];
        $FirmaAdres = $opt['Adres'];
        $FirmaTelefon = $opt['Telefon'];
    }
    $_SESSION['Firma'] = $firma;
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
            $TopHeader = $menu['title'];
            echo '<title>' . $menu['title'] . ' | ' . $firma . ' </title>';
        }
    } else {
        echo '<title> Dashboard | ' . $firma . ' </title>';
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Fislash My App" name="description" />
    <meta content="Fislash" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo $logo; ?>">

    <!-- App Css -->
    <link href="../assets/css/fi-my-app.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Sweet Alert-->
    <link href="../assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom Box and Modal-->
    <link href="../assets/libs/custombox/custombox.min.css" rel="stylesheet">
    <!-- third party (datatables) css -->
    <link href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!-- third party (datatables) css end -->
    <!-- Notification css (Toastr) -->
    <link href="../assets/libs/toastr/build/toastr.min.css" rel="stylesheet" type="text/css" />

    <link href="../assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <!-- icons -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <!-- Toastr js -->
    <script src="../assets/libs/toastr/build/toastr.min.js"></script>
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <!-- quill js -->
    <script src="../assets/libs/quill/quill.min.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        });
    </script>
</head>
<?php include("../src/HaremGuncelle.php"); 
?>

<div id="preloader">
    <div id="loader"></div>
</div>
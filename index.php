<?php
setlocale(LC_TIME, "turkish");
setlocale(LC_ALL, 'turkish');
include("src/iconlibrary.php");
$vt = new veritabani();
$siteoptions = $vt->listele("fimy_appoptions");
if ($siteoptions != null) foreach ($siteoptions as $opt) {
    $firma = $opt['FirmaAdi'];
    $logo = $opt['Logo'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Fislash My</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Fislash My App" name="description" />
    <meta content="Fislash" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo substr($logo, 3); ?>">

    <!-- App css -->

    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Notification css (Toastr) -->
    <link href="assets/libs/toastr/build/toastr.min.css" rel="stylesheet" type="text/css" />
    <!-- icons -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <style>
        body.authentication-bg {
            background-image: url("") !important;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<?php
if (isset($_COOKIE['MyCookieFi'])) {
    echo "<script>window.location = 'fpanel'</script>";
} else {
    // session_destroy();
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 3600);
            setcookie($name, '', time() - 3600, '/');
        }
    }
}
?>

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="text-center">
                        <a href="index.php">
                            <img src="<?php echo substr($logo, 3); ?>" alt="" height="60" class="mx-auto">
                        </a>
                        <p class="text-muted mt-2 mb-4"> </p>

                    </div>
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label for="username" class="form-label">Kullanıcı Adı</label>
                                <input class="form-control" type="username" id="kullaniciadi" required="" placeholder="Kullanıcı Adı">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input class="form-control" type="password" required="" id="sifre" placeholder="Şifre">
                            </div>

                            <div style="display:none;" class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                    <label class="form-check-label" for="checkbox-signin">Beni Hatırla</label>
                                </div>
                            </div>

                            <div id="smstoken" class="mb-3 d-grid text-center">
                                <button id="login" class="btn btn-primary" type="submit"> Giriş </button>
                            </div>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="pages-recoverpw.html" class="text-muted ms-1"><i class="fa fa-lock me-1"></i>Şifre mi Unuttum?</a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Custom Script -->
    <script>
        $(document).ready(function() {

            $('#sifre').keypress(function(event) {
                if (event.keyCode === 13) {
                    $('#kullaniciadi').attr("disabled", "disabled");

                    ds = "username=" + $("#kullaniciadi").val() + "&pass=" + $("#sifre").val();
                    $.ajax({
                        url: 'smsauth/auth.fi',
                        type: 'POST',
                        data: ds,
                        success: function(e) {
                            $("div#smstoken").html("").html(e);
                        }
                    });
                }
            });

            $("#login").on("click", function() {
                $('#kullaniciadi').attr("disabled", "disabled");

                ds = "username=" + $("#kullaniciadi").val() + "&pass=" + $("#sifre").val();
                $.ajax({
                    url: 'smsauth/auth.fi',
                    type: 'POST',
                    data: ds,
                    success: function(e) {
                        $("div#smstoken").html("").html(e);
                    }
                });
            });
            $('#smstoken1').keypress(function(event) {
                if (event.keyCode === 13) {
                    ds = "smstoken=" + $("#smstoken1").val();
                    $.ajax({
                        url: 'smsauth/validate.fi',
                        type: 'POST',
                        data: ds,
                        success: function(e) {
                            $("div#smstoken").html("").html(e);
                        }
                    });
                }
            });
            $("#dogrula").on("click", function() {
                ds = "smstoken=" + $("#smstoken1").val();
                $.ajax({
                    url: 'smsauth/validate.fi',
                    type: 'POST',
                    data: ds,
                    success: function(e) {
                        $("div#smstoken").html("").html(e);
                    }
                });
            });

        });
    </script>
    <!-- Toastr js -->
    <script src="assets/libs/toastr/build/toastr.min.js"></script>
    <!-- Vendor -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>
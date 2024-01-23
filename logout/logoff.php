<?php setlocale(LC_TIME, "turkish");
          setlocale(LC_ALL,'turkish');
          include("../src/iconlibrary.php");
          $vt = new veritabani();
             include("../src/header.php"); ?>
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="index.html" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="assets/images/logo-dark.png" alt="" height="22">
                                            </span>
                                        </a>
                    
                                        <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="assets/images/logo-light.png" alt="" height="22">
                                            </span>
                                        </a>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div class="mt-4">
                                        <div class="logout-checkmark">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                                <circle class="path circle" fill="none" stroke="#0e2d67" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                                <polyline class="path check" fill="none" stroke="#0e2d67" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                            </svg>
                                        </div>
                                    </div>

                                    <h3>Tekrar Görüşürüz !</h3>
                                    <?php 
                                    
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

                                    echo "<script>setTimeout(function() {
                                        window.location = '../'
                                      }, 1000);
                                      </script>";                                    
                                    ?>
                                </div>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                
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
            
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
<?php include("../src/footer-end.php"); ?>
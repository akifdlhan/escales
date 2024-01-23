<?php
if($_GET){

include("../src/access-my-dashboard.php"); 
echo '<link rel="shortcut icon" href="../assets/images/logo-sm.png">';
echo '<title> Şifre Sıfırlama | Fi My </title>';
                    $ID = $_GET['ID'];
                    $fimy_user = $vt->listele("fimy_user","WHERE ID={$ID}");
                    if($fimy_user != null) foreach( $fimy_user as $fu ) {
                            $kullaniciadi = $fu['kullaniciadi'];
                    }
?>

    <body class="loading authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="card">

                            <div class="card-body p-4">
                                
                                <div class="text-center mb-4">
                                    <h4 class="text-uppercase mt-0"><?php echo $kullaniciadi; ?> <br> Şifre Sıfırlama</h4>
                                </div>


                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Eski Şifre</label>
                                        <input type="hidden" id="user" value="<?php echo $ID; ?>">
                                        <input class="form-control" type="text" id="oldpass" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Yeni Şifre</label>
                                        <input class="form-control" type="text" id="npass" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Yeni Şifre Tekrar</label>
                                        <input class="form-control" type="text" id="npass2" required>
                                    </div>
                                    <div class="mb-3">

                                    </div>
                                    <div class="mb-3 text-center d-grid">
                                        <button class="btn btn-primary" id="resetis" type="submit"> Şifre Sıfırla </button>
                                    </div>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted"><div id="son"></div></p>
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
        <script src="..\assets\js\fi-js\repass.js" type="text/javascript"></script>

<?php 
include("../src/footer-end.php");
             }else{
                echo '<script>
                setTimeout(function() {
                    window.location = "./profil.php";
                  }, 1000);
                    </script>';
             }
              ?>
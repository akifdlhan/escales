<?php include("../src/access.php"); ?>
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <div class="row">
                        <div class="col-sm-12">
                                <div class="card card-body">
                                    <h4 class="card-title">Firma Bilgileri</h4>
                                    <h5 class="card-text">  </h5>
                                    <div class="card-text">
                                        <div class="row">
                                        <?php       
                                            $siteoptions = $vt->listele("fimy_appoptions");
                                            if($siteoptions != null) foreach( $siteoptions as $opt ) {
                                               ?>
                                               <div class="col-lg-2"><h5 class="card-text">Firma Adı </h5><?php echo $opt['FirmaAdi']; ?></div>
                                               <div class="col-lg-2"><h5 class="card-text">Yetkili Adı Soyadı </h5><?php echo $opt['YetkiliAdi']." ".$opt['YetkiliSoyadi']; ?></div>
                                               <div class="col-lg-2"><h5 class="card-text">Telefon</h5><?php echo $opt['Telefon']; ?></div>
                                               <div class="col-lg-2"><h5 class="card-text">Telefon 2</h5><?php echo $opt['Telefon2']; ?></div>
                                               <div class="col-lg-2"><h5 class="card-text">Mail</h5><?php echo $opt['Mail']; ?></div>
                                               <div class="col-lg-12"><h5 class="card-text">Adres </h5><?php echo $opt['Adres']; ?></div>
                                               
                                               <?php
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card card-body">
                                    <h4 class="card-title">Lisans Bilgileri</h4>
                                    <h5 class="card-text">Fi Slash Software </h5>
                                    <div class="card-text">
                                        <div class="row">
                                        
                                            <div class="col-sm-6">
                                                <table style="text-align: center;" class="table table-dark table-borderless mb-0">
                                                    <tr>
                                                        <th colspan=4>
                                                            Lisans Numarası
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                    <?php 
                                                    $fimy_license = $vt->listele("fimy_license","WHERE ID=1 and Statu=1");
                                                    if($fimy_license != null) foreach( $fimy_license as $license ) {
                                                            echo '
                                                            <td>'.$license['Code1'].'</td>
                                                            <td>'.$license['Code2'].'</td>
                                                            <td>'.$license['Code3'].'</td>
                                                            <td>'.$license['Code4'].'</td>';
                                                            $baslama = $license['Start_date'];
                                                            $bitis = $license['End_date'];
                                                    }
                                                        ?>
                                                        
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <table style="text-align: center;" class="table table-dark table-borderless mb-0">
                                                    <tr>
                                                        <th colspan=2>
                                                            Başlama Tarihi
                                                        </th>
                                                        <th colspan=2>
                                                            Bitiş Tarihi
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan=2><?php echo date("d.m.Y", strtotime($baslama)); ?></td>
                                                        <td colspan=2><?php echo date("d.m.Y", strtotime($bitis)); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card card-body">
                                    <h4 class="card-title">Fi Gezgin Hakkında</h4>
                                    <p class="card-text">
<p>Fi Gezgin, işletmelerin günlük operasyonlarını yönetmelerine ve finansal süreçlerini izlemelerine yardımcı olan kapsamlı bir web uygulamasıdır. Stok, Personel, Ön Muhasebe, Envanter ve Rapor modüllerini içeren Fi Gezgin, işletme sahiplerine ve yöneticilere işlerini daha verimli bir şekilde yönetme ve büyütme fırsatı sunar.</p>
<p>Stok modülü, işletmenizin stoklarını izlemenizi ve yönetmenizi sağlar. Ürünlerinizin stok durumunu takip edebilir, stok giriş ve çıkışlarını kaydedebilir, stok hareketlerini raporlayabilirsiniz. Ayrıca, minimum stok seviyelerini belirleyerek otomatik uyarılar alabilir ve stoğunuzu optimize edebilirsiniz.</p>
<p>Personel modülü, işletmenizin insan kaynakları süreçlerini yönetmenize yardımcı olur. Personel bilgilerini kaydedebilir, işe alım sürecini takip edebilir, çalışanların performansını değerlendirebilir ve izinlerini takip edebilirsiniz. Böylece, personel yönetimi ve takibi daha kolay ve etkili hale gelir.</p>
<p>Ön Muhasebe modülü, işletmenizin temel muhasebe işlemlerini gerçekleştirmenizi sağlar. Gelir ve giderleri kaydedebilir, faturalarınızı oluşturabilir, borç-alacak takibini yapabilir ve finansal raporlar üretebilirsiniz. Finansal süreçleri kontrol altında tutarak, işletmenizin mali durumunu anlamak ve kararlarınızı buna göre şekillendirmek daha kolay olur.</p>
<p>Envanter modülü, işletmenizin envanterini yönetmek için kullanılır. Ürünlerinizin detaylı bilgilerini kaydedebilir, envanter hareketlerini takip edebilir, stoğunuzdaki değişimleri anlık olarak gözlemleyebilirsiniz. Bu sayede, envanterinizin etkin bir şekilde yönetilmesi ve kayıp/eksikliklerin azaltılması sağlanır.</p>
<p>Rapor modülü, işletmenizin performansını izlemenizi ve analiz etmenizi sağlar. Satış raporları, gelir-gider tabloları, envanter analizleri gibi çeşitli raporlar oluşturabilirsiniz. Bu raporlar, işletmenizin güncel durumunu anlamak, trendleri belirlemek ve gelecekteki stratejilerinizi planlamak için değerli bilgiler sunar.</p>
<p>Fi Gezgin, kullanıcı dostu bir arayüze sahip olup, kullanıcıların modüller arasında kolaylıkla geçiş yapabilmesini sağlar. Verilerin güvenliği ve gizliliği büyük önem taşır ve güvenlik önlemleriyle korunur. Ayrıca, özelleştirilebilir ve genişletilebilir yapısı sayesinde işletmenizin ihtiyaçlarına uygun şekilde özelleştirilebilir. </p>
<p>Fi Gezgin, işletmelerin operasyonel verimliliklerini artırmalarına, süreçleri daha iyi yönetmelerine ve stratejik kararlar almalarına yardımcı olan güçlü bir tümleşik web uygulamasıdır. İşletmenizin gereksinimlerini karşılamak ve büyümesini desteklemek için Fi Gezgin'ı tercih edebilirsiniz. </p>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->        
                        
                    
                    </div> <!-- container -->

                </div> <!-- content -->

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
<?php include("../src/footer-alt.php"); ?>
<?php if ($_GET) {
    include("../src/access.php");

    $SiparisID = $_GET['ID'];
    $Onay = $_GET['Onay'];

    if ($Onay == 0) {
        $fimy_siparis_formu = $vt->guncelle("fimy_siparis_formu", array(
            "Onay" => 1
        ), "ID={$SiparisID}");
        $fimy_siparis_formu = $vt->ekle("fimy_siparis_log", array(
            "SiparisFormID" => $SiparisID,
            "Log" => "Sipariş Onaylandı.",
            "KullaniciID" => $_GET['User']
        ));
        header("Location: ../stok-yonetimi/siparis.php");
        exit();
    } else if ($Onay == 1) {
        $fimy_siparis_formu = $vt->guncelle("fimy_siparis_formu", array(
            "Onay" => 0
        ), "ID={$SiparisID}");
        $fimy_siparis_formu = $vt->ekle("fimy_siparis_log", array(
            "SiparisFormID" => $SiparisID,
            "Log" => "Sipariş Onayı kaldırıldı.",
            "KullaniciID" => $_GET['User']
        ));
        header("Location: ../stok-yonetimi/siparis.php");
        exit();
    } else {
        header("Location: ../stok-yonetimi/siparis.php");
        exit();
    }





    include("../src/footer-alt.php");
} else {
    header("Location: ../stok-yonetimi/siparis.php");
    exit();
}

<?php
include("../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_POST) {
    $TC = isset($_POST['TC']) ? $_POST['TC'] : '';
    $Adi = isset($_POST['Adi']) ? $_POST['Adi'] : '';
    $Soyad = isset($_POST['Soyad']) ? $_POST['Soyad'] : '';
    $Telefon = isset($_POST['Telefon']) ? $_POST['Telefon'] : '';  
    $Cinsiyet = isset($_POST['Cinsiyet']) ? $_POST['Cinsiyet'] : '';
    $Departman = isset($_POST['Departman']) ? $_POST['Departman'] : '';
    $Adres = isset($_POST['Adres']) ? $_POST['Adres'] : '';
    $il = isset($_POST['il']) ? $_POST['il'] : '';
    $ilce = isset($_POST['ilce']) ? $_POST['ilce'] : '';
    $BaslamaTarihi = isset($_POST['BaslamaTarihi']) ? $_POST['BaslamaTarihi'] : '';
    
    $fimy_personel = $vt->ekle("fimy_personel", array(
        "TC" => $TC,
        "Adi" => $Adi,
        "Soyadi" => $Soyad,
        "Telefon" => $Telefon,
        "Cinsiyet" => $Cinsiyet,
        "Departman" => $Departman,
        "Adres" => $Adres,
        "il" => $il,
        "ilce" => $ilce,
        "BaslamaTarihi" => $BaslamaTarihi
    
    ));
    if($fimy_personel > 0){
        echo "Personel Eklenmiştir.";
    }
    

}
?>
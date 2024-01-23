<?php
include("../../src/iconlibrary.php");
$vt = new veritabani();
extract($_POST);
if ($_GET) {
    $fimy_urunler = $vt->listele("fimy_urunler", "WHERE ID={$_GET['ID']}");
    if ($fimy_urunler != null) foreach ($fimy_urunler as $urun) {
        $barkod = $urun['barkod'];
        $StokKodu = $urun['StokKodu'];
        $UrunAdi = $urun['urun_adi'];
    }
    require '../../src/vendor/autoload.php';
    require('../../src/fpdf.php');

    class PDF extends FPDF
        {
            private $productName;
            private $stockCode;
            private $barcode;

            function header()
            {
                // Sayfa üst kısmı
                $this->SetFont('Arial', 'B', 6);
                $this->SetY(4);
                $this->Cell(0, 0, iconv('UTF-8', 'ISO-8859-9', $this->productName . " | " . $this->stockCode), 0, 1, 'C');
                // iconv('UTF-8', 'ISO-8859-9', $this->productName . " | " . $this->stockCode)
            }

            function footer()
            {
                // Sayfa alt kısmı
                $this->SetY(17);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 0, iconv('UTF-8', 'ISO-8859-9', $this->barcode), 0, 0, 'C');
                // $this->barcode
            }

            function createDocument($productName, $stockCode, $barcode, $imagePath)
            {
                $this->productName = $productName;
                $this->stockCode = $stockCode;
                $this->barcode = $barcode;

                $this->AddPage('L', array(40, 20)); // 20mm uzunluk, 40mm genişlik
                $this->SetMargins(5, 5); // Sağdan ve soldan 5mm kesme payı

                // Sayfanın tam ortasında barkod görüntüsü
                $this->Image($imagePath, 2, 6, 36);

                // Çıktıyı göster
                // $this->Output();
            }
            function ClearLastPageContent()
            {
                $this->pages[$this->page] = ''; // En son eklenen sayfanın içeriğini boşalt
            }
        }

    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    // $UrunAdi . " - " . $StokKodu
    $barcode = $generator->getBarcode($barkod, $generator::TYPE_CODE_128, 1, 30);
    $imagePath = $barkod . '.png'; // Kaydedilecek dosya adı ve yolunu belirtin
    file_put_contents($imagePath, $barcode);
    //  $barkod

    $pdf = new PDF();
    $productName = $UrunAdi;
    $stockCode = $StokKodu;
    $barcodem = $barkod;
    $imagePath = $imagePath;
    $pdf->createDocument($productName, $stockCode, $barcodem, $imagePath);
    $pdf->Output();
    unlink($imagePath);
}

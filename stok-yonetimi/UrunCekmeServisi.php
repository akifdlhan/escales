<?php
include("../src/iconlibrary.php");
$vt = new veritabani();

// DataTables tarafından gönderilen parametreleri alma
$start = isset($_GET['start']) ? $_GET['start'] : 0;
$length = isset($_GET['length']) ? $_GET['length'] : 50;

// Sıralama parametrelerini alma
$order_column = isset($_GET['order'][0]['column']) ? $_GET['order'][0]['column'] : 0;
$order_dir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'asc';

// Arama terimini alma
$search = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

// Sıralama sütunlarını ve sıralama yönünü belirleme
$columns = array('ID', 'barkod', 'StokKodu', 'urun_adi', 'stok_miktari', 'KategoriAdi', 'SatisFiyati', 'ParaBirimi', 'proccess_date');
$order_column_name = $columns[$order_column];

// Veri çekme sorgusu
$sql = "SELECT u.ID, u.barkod, u.StokKodu, u.urun_adi, 
               COALESCE(SUM(s.stok_miktari), 0) AS stok_miktari, 
               k.KategoriAdi, 
               p.SatisFiyati, 
               u.proccess_date
        FROM fimy_urunler u
        LEFT JOIN fimy_urun_stok_depo s ON u.ID = s.UrunID
        LEFT JOIN fimy_kategoriler k ON u.KategoriID = k.ID
        LEFT JOIN fimy_urun_fiyat p ON u.ID = p.UrunID
        WHERE u.urun_adi LIKE '%$search%' or u.StokKodu LIKE '%$search%'
        GROUP BY u.ID
        ORDER BY $order_column_name $order_dir
        LIMIT $start, $length";

$data = array();

$sqll = $vt->ozellistele($sql);
if ($sqll != null) foreach ($sqll as $row) {
    $row['link'] = '<a href="urun-karti.php?UrunID=' . $row['ID'] . '"><i style="font-size:16px; color:darkblue;" class="fas fa-glasses"></i></a>';
    $row['SatisFiyati'] = number_format($row['SatisFiyati'], 2, ',', '.');
    $data[] = $row;
}


// Toplam veri sayısını bulma
$sqlCount = "SELECT COUNT(u.ID) as count
             FROM fimy_urunler u
             WHERE u.urun_adi LIKE '%$search%' or u.StokKodu LIKE '%$search%'";

$count = 0;
$sqlCountt = $vt->ozellistele($sqlCount);
if ($sqlCountt != null) foreach ($sqlCountt as $countRow) {
    $count = $countRow['count'];
}

// JSON formatında veri ve toplam sayfa sayısını döndürme
$response = array(
    "draw" => isset($_GET['draw']) ? $_GET['draw'] : 1,
    "recordsTotal" => $count,
    "recordsFiltered" => $count,
    "data" => $data
);

echo json_encode($response);


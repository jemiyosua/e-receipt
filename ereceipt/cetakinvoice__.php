<?php

ini_set('display_errors', '1');
// init_set('memory_limit', '96M');
require_once('koneksi.php');

isset($_GET['id']);

$PAYMENT_ID = $_GET['id'];

$q = "SELECT ID_USER, NAMA, TANGGAL_BAYAR, BULAN_REIMBURSE, TOTAL_BAYAR, KETERANGAN, NAMA_KOST, ALAMAT_KOST, NO_TELEPON, EMAIL_KOST, WEBSITE_KOST, NAMA_PEMILIK FROM TAGIHAN WHERE PAYMENT_ID = '$PAYMENT_ID'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$ID_USER = $row["ID_USER"];
if ($ID_USER == 26 || $ID_USER == 55) {
    $TTD = "ttd/ttd_mastin_2.png";
    $WIDTH = "70PX";
    $LEBAR = "15%";
	$ENTER = "<br><br><br>";
} else if ($ID_USER == 27) {
	$TTD = "ttd/ttd_deddy.png";
	$WIDTH = "70PX";
    $LEBAR = "15%";
	$ENTER = "<br><br><br><br>";
} else if ($ID_USER == 29) {
	$TTD = "ttd/ttd_richad.png";
	$WIDTH = "70PX";
    $LEBAR = "15%";
	$ENTER = "<br><br><br><br>";
} else if ($ID_USER == 34) {
	$TTD = "ttd/ttd_mitra.jpeg";
    $WIDTH = "70px";
    $LEBAR = "15%";
	$ENTER = "<br><br><br>";
} else if ($ID_USER == 41) {
    $TTD = "ttd/ttd_pepi.png";
    $WIDTH = "100px";
    $LEBAR = "20%";
	$ENTER = "<br><br><br><br>";
} else {
    $TTD = "ttd/ttd.png";
    $WIDTH = "100px";
    $LEBAR = "20%";
	$ENTER = "<br><br><br>";
} 

$NAMA = strtolower($row['NAMA']);
$VNAMA = ucwords($NAMA);

$TANGGAL_BAYAR = $row['TANGGAL_BAYAR'];
$VTANGGAL_BAYAR = date('d F Y', strtotime($TANGGAL_BAYAR));

$BULAN_REIMBURSE = $row['BULAN_REIMBURSE'];

$TOTAL_BAYAR = $row['TOTAL_BAYAR'];
$CASH_AMOUNT = substr($TOTAL_BAYAR, 4);
$VCASH_AMOUNT = str_replace(".", "", $CASH_AMOUNT);

$KETERANGAN = strtolower($row['KETERANGAN']);
$VKETERANGAN = ucwords($KETERANGAN);

$NAMA_KOST = $row['NAMA_KOST'];

$ALAMAT_KOST = $row['ALAMAT_KOST'];

$NO_TELEPON = $row['NO_TELEPON'];
if ($NO_TELEPON == "") {
	$VNO_TELEPON = "-";
} else {
	$VNO_TELEPON = $NO_TELEPON;
}

$EMAIL_KOST = $row['EMAIL_KOST'];
if ($EMAIL_KOST == "") {
	$VEMAIL_KOST = "-";
} else {
	$VEMAIL_KOST = $EMAIL_KOST;
}

$WEBSITE_KOST = $row['WEBSITE_KOST'];
if ($WEBSITE_KOST == "") {
	$VWEBSITE_KOST = "-";
} else {
	$VWEBSITE_KOST = $WEBSITE_KOST;
}

$NAMA_PEMILIK = $row['NAMA_PEMILIK'];

function penyebut($nilai)
{
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " " . $huruf[$nilai];
	} else if ($nilai < 20) {
		$temp = penyebut($nilai - 10) . " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
	}
	return $temp;
}

function terbilang($nilai)
{
	if ($nilai < 0) {
		$hasil = "minus " . trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}
	return $hasil;
}

$html = "
<html>
	<body>

		<b>" . $NAMA_KOST . "</b>

		<p>" . $ALAMAT_KOST . "</p>

		<p>Phone : ".$NO_TELEPON."</p>
		<p>Email : ".$VEMAIL_KOST."</p>
		<p>Website : ".$VWEBSITE_KOST."</p>

	</body>
</html>
";

$content = "
<html> 
<body>
    <h1>HTML2PDF WORK !</h1> 
    Selamat datang di rachmat.ID
</body>
</html>
";

require __DIR__.'/html2pdf/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
$html2pdf = new Html2Pdf('P','A4','fr', true, 'UTF-8', array(15, 15, 15, 15), false); 
$html2pdf->writeHTML($html);
// $html2pdf->output("Kwitansi Pembayaran " . $VTANGGAL_BAYAR . ".pdf","D");
$html2pdf->output();

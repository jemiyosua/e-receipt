<?php

ini_set('display_errors', '1');
// init_set('memory_limit', '96M');
require_once('koneksi.php');
require_once 'dompdf/autoload.inc.php';

isset($_GET['id']);

$PAYMENT_ID = $_GET['id'];

// echo $PAYMENT_ID;exit;

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

	$path = $TTD;
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	// echo $base64;
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

$html = '

<html>

<style type="text/css">

    table, table td, table th{
        border-collapse: collapse;
    }
    .text-dark, table td{
        color: #343a40;
    }
    .text-white{
        color: #ffffff;
    }
    table td,
    table th {
        font-size: 12px;
        padding: 3px;
        line-height: 1.5;
        font-family:arial;
    }

    .bg-dark {
        background-color: #343a40;
    }
    .bg-secondary {
        background-color: #6c757d;
    }
    .bg-white {
        background-color: #ffffff;
    }
</style>

<b>' . $NAMA_KOST . '</b>

<table>
	<tr>
		<td>' . $ALAMAT_KOST . '</td>
	</tr>
	<tr>
		<td>Phone : ' . $NO_TELEPON . '</td>
	</tr>
	<tr>
		<td>Email : ' . $VEMAIL_KOST . '</td>
	</tr>
	<tr>
		<td>Website : ' . $VWEBSITE_KOST . '</td>
	</tr>
</table>
<table width=100%>
	<tr>
		<td><hr></td>
	</tr>
	<tr>
		<td align=center><b><text color=black>KWITANSI PEMBAYARAN</text></b></td>
	</tr>
	<tr>
		<td><hr></td>
	</tr>
</table>

<br>

<table width=75%>
	<tr>
		<td>Terima Dari</td>
		<td>:</td>
		<td>' . $VNAMA . '</td>
	</tr>
	<tr>
		<td>Terbilang</td>
		<td>:</td>
		<td>' . strtoupper(terbilang($VCASH_AMOUNT)) . ' RUPIAH</td>
	</tr>
	<tr>
		<td>Guna Pembayaran</td>
		<td>:</td>
		<td>' . $VKETERANGAN . '</td>
	</tr>
	<tr>
		<td>Tanggal Pembayaran</td>
		<td>:</td>
		<td>' . $VTANGGAL_BAYAR . '</td>
	</tr>
</table>

<br>

<table width=50%>
	<tr>
		<td colspan=2><hr></td>
	</tr>
	<tr>
		<td>Jumlah</td>
		<td bgcolor=yellow><b>' . $TOTAL_BAYAR . '</b></td>
	</tr>
	<tr>
		<td colspan=2><hr></td>
	</tr>
</table>

<br>

<table align=right width=20%>
	<tr>
		<td align=center>' . $VTANGGAL_BAYAR . '</td>
	</tr>
	<tr>
		<td align=center>' . $NAMA_KOST . '</td>
	</tr>
</table>

<br>
<br>
<br>

' . $ENTER . '

<table align=right width=20%>
	<tr>
		<td align=center>' . $NAMA_PEMILIK . '</td>
	</tr>
</table>
';
$html .= "</html>";

// echo $html;exit;

// use Dompdf\Options;
use Dompdf\Dompdf;

// $options = new Options();
// $options->set('isRemoteEnabled', true);
// $dompdf = new Dompdf($options);
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
// file_php_contents('sample.pdf', $dompdf->output());
$dompdf->stream('Kwitansi Pembayaran ' . $VTANGGAL_BAYAR . '.pdf', array("Attachment" => false));

<?php

require_once('koneksi.php');
require_once("dompdf/autoload.inc.php");

isset($_GET['id']);

$ID_LETTER = $_GET['id'];

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$q = "SELECT ID_USER, NIK, NAMA_KARYAWAN, JENIS_LISTRIK, NOMOR_METER, NAMA_PELANGGAN, ALAMAT, PEMILIK_KOST, TGL_INPUT FROM PERNYATAAN WHERE ID_LETTER = '$ID_LETTER'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$ID_USER = $row['ID_USER'];

if ($ID_USER == 1) {
    $TTD = "ttd/user/jemi.png";
    $TTD_KOST = "ttd/ttd.png";
    $WIDTH = "100px";
    $WIDTH_KOST = "100px";
    $LEBAR = "20%";
	$ENTER = "<br><br>";
	$ENTER_NAMA = "<br><br><br>";
    $STATUS = "Penjaga Kost";
} else if ($ID_USER == 2) {
    $TTD = "ttd/user/tejo.png";
    $TTD_KOST = "ttd/ttd.png";
    $WIDTH = "50px";
    $WIDTH_KOST = "100px";
    $LEBAR = "20%";
	$ENTER = "<br><br>";
	$ENTER_NAMA = "<br><br><br>";
    $STATUS = "Penjaga Kost";
} else if ($ID_USER == 9) {
    $TTD = "ttd/user/jeremy.png";
    $TTD_KOST = "ttd/ttd.png";
    $WIDTH = "75px";
    $WIDTH_KOST = "100px";
    $LEBAR = "20%";
	$ENTER = "<br><br>";
	$ENTER_NAMA = "<br><br><br>";
    $STATUS = "Penjaga Kost";
}

$NIK = $row['NIK'];
$NAMA_KARYAWAN = $row['NAMA_KARYAWAN'];
$JENIS_LISTRIK = $row['JENIS_LISTRIK'];
if ($JENIS_LISTRIK == "T") {
    $VJENIS_LISTRIK = "TOKEN";
} else {
    $VJENIS_LISTRIK = "NON TOKEN";
}
$NOMOR_METER = $row['NOMOR_METER'];
$NAMA_PELANGGAN = $row['NAMA_PELANGGAN'];
$ALAMAT = $row['ALAMAT'];
$PEMILIK_KOST = strtoupper($row['PEMILIK_KOST']);
$TGL_INPUT = $row['TGL_INPUT'];
$VTGL_INPUT = date('d/m/Y', strtotime($TGL_INPUT));

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

    <div align="center">
        SURAT PERNYATAAN REIMBURSE BIAYA LISTRIK KOST <br> KARYAWAN PT ASURANSI SINAR MAS
    </div>

    <br>

    Yang bertanda tangan dibawah ini :

    <br>

    <table width=75%>
        <tr>
            <td>NIK (KARYAWAN)</td>
            <td>:</td>
            <td><b>' . $NIK . '</b></td>
        </tr>
        <tr>
            <td>Nama Karyawan</td>
            <td>:</td>
            <td><b>' . $NAMA_KARYAWAN . '</b></td>
        </tr>
        <tr>
            <td>Jenis Listrik</td>
            <td>:</td>
            <td><b>' . $VJENIS_LISTRIK . '</b></td>
        </tr>
        <tr>
            <td>Nomor Meter / Id Pelanggan</td>
            <td>:</td>
            <td><b>' . $NOMOR_METER . '</b></td>
        </tr>
        <tr>
            <td>Nama Pelanggan</td>
            <td>:</td>
            <td><b>' . $NAMA_PELANGGAN . '</b></td>
        </tr>
        <tr>
            <td>Alamat lengkap Kost</td>
            <td>:</td>
            <td><b>' . $ALAMAT . '</b></td>
        </tr>
        <tr>
            <td>Dengan ini menyatakan</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 30px;" colspan=3>1. Reimburse biaya kost tidak termasuk biaya listrik</td>
        </tr>        
    </table>

    <br>

    Demikian surat pernyataan ini saya buat dengan sebenar - benarnya dan saya sanggup menerima konsekuensi apabila kemudian hari terbukti pernyataan yang saya buat ini palsu.

    <br><br><br>

    <table align=right width=20%>
        <tr>
            <td align=center>Jakarta, ' . $VTGL_INPUT . '</td>
        </tr>
    </table>
    
    <br><br>

    <div align="left">Yang membuat pernyataan</div>

    <br>

    <table style="width:100%">
        <tr>
            <td>
                <table align=left>
                    <tr>
                        <td align=center>Karyawan</td>
                    </tr>
                </table>

                ' . $ENTER . '

                <table align=left width=' . $LEBAR . '>
                    <tr>
                        <td><b><img src="' . $TTD . '" width="' . $WIDTH . '" align="center"><b></td>
                    </tr>
                </table>

                ' . $ENTER_NAMA . '

                <table align=left>
                    <tr>
                        <td align=center><b>' . $NAMA_KARYAWAN . '</b></td>
                    </tr>
                </table>
            </td>
            <td>
                <table align=right>
                    <tr>
                        <td align=center>' . $STATUS . '</td>
                    </tr>
                </table>

                ' . $ENTER . '

                <table align=right width='.$LEBAR.'>
                    <tr>
                        <td><b><img src="' . $TTD_KOST . '" width="' . $WIDTH_KOST . '" align="center"><b></td>
                    </tr>
                </table>

                ' . $ENTER_NAMA . '

                <table align=right width=20%>
                    <tr>
                        <td align=center><b>' . $PEMILIK_KOST . '</b></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br><br><br>

    * Saat pengisian data, mohon ditulis salah 1 saja ya.

    <br><br>

    ** saat pengisian data, mohon ditulis salah 1 saja ya dan jika Pihak kost yang melakukan tanda tangan surat pernyataan adalah penjaga kost, mohon tulis alasan nya di surat ini dan kolom keterangan saat pengajuan reimburse listrik di PEGA ya.
';

$html .= "</html>";
$dompdf->loadHtml($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('Surat_Pernyataan_' . $NAMA_KARYAWAN . '.pdf', array("Attachment" => false));

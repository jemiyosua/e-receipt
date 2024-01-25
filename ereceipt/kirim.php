<?php

require_once('koneksi.php');

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['kirim'])) {

    if (isset($_GET['id'])) {

        $id_dokumen = $_GET['id'];

        $q = "SELECT PAYMENT_ID, NAMA, TANGGAL_BAYAR, BULAN_REIMBURSE, TOTAL_BAYAR, KETERANGAN, NAMA_KOST, ALAMAT_KOST, NO_TELEPON, EMAIL_KOST, WEBSITE_KOST, NAMA_PEMILIK FROM TAGIHAN WHERE ID = $id_dokumen";
        $sql = mysqli_query($conn, $q);
        $row = mysqli_fetch_assoc($sql);

        $NAMA = strtolower($row['NAMA']);
        $VNAMA = ucwords($NAMA);

        $PAYMENT_ID = $row['PAYMENT_ID'];

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

        // BODY EMAIL

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
                    <td>Phone : -</td>
                </tr>
                <tr>
                    <td>Email : -</td>
                </tr>
                <tr>
                    <td>Website : -</td>
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
            <br>
            <br>
            <br>
            <br>

            <table align=right width=20%>
                <tr>
                    <td align=center>' . $NAMA_PEMILIK . '</td>
                </tr>
            </table>
            ';

        $html .= "</html>";

        $EMAIL_PENERIMA = $_POST['emailPenerima'];

        // Include librari phpmailer
        include('phpmailer/Exception.php');
        include('phpmailer/PHPMailer.php');
        include('phpmailer/SMTP.php');
        $email_pengirim = 'jemiyosua@gmail.com'; // Isikan dengan email pengirim
        $nama_pengirim = 'E-RECEIPT PAYMENT'; // Isikan dengan nama pengirim
        $email_penerima = $EMAIL_PENERIMA; // Ambil email penerima dari inputan form
        $subjek = "E-receipt Payment "; // Ambil subjek dari inputan form
        $pesan = $html; // Ambil pesan dari inputan form
        $attachment = ""; // Ambil nama file yang di upload

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = $email_pengirim; // Email Pengirim
        $mail->Password = 'gpbfakarsxlfizox'; // Isikan dengan Password email pengirim
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        // $mail->SMTPDebug = 2; // Aktifkan untuk melakukan debugging
        $mail->setFrom($email_pengirim, $nama_pengirim);
        $mail->addAddress($email_penerima, '');
        $mail->isHTML(true); // Aktifkan jika isi emailnya berupa html
        // Load file content.php
        ob_start();
        include "content.php";
        $content = ob_get_contents(); // Ambil isi file content.php dan masukan ke variabel $content
        ob_end_clean();
        $mail->Subject = $subjek;
        $mail->Body = $content;
        // $mail->AddEmbeddedImage('img/bill.png', 'logo_mynotescode', 'logo.png'); // Aktifkan jika ingin menampilkan gambar dalam email
        if (empty($attachment)) { // Jika tanpa attachment
            $send = $mail->send();
            if ($send) { // Jika Email berhasil dikirim
                $_SESSION['pesan'] = "Your e-receipt payment was successfully send to your email, please check your email.";
                header('location: indexInvoice.php');
            } else { // Jika Email gagal dikirim
                $_SESSION['pesanError'] = "Something went wrong when send your e-receipt payment to your email, please try again later.";
                header('location: indexInvoice.php');
                // echo '<h1>ERROR<br /><small>Error while sending email: '.$mail->getError().'</small></h1>'; // Aktifkan untuk mengetahui error message
            }
        } else { // Jika dengan attachment
            $tmp = $_FILES['attachment']['tmp_name'];
            $size = $_FILES['attachment']['size'];
            if ($size <= 25000000) { // Jika ukuran file <= 25 MB (25.000.000 bytes)
                $mail->addAttachment($tmp, $attachment); // Add file yang akan di kirim
                $send = $mail->send();
                if ($send) { // Jika Email berhasil dikirim
                    echo "<h1>Email berhasil dikirim</h1><br /><a href='index.php'>Kembali ke Form</a>";
                } else { // Jika Email gagal dikirim
                    echo "<h1>Email gagal dikirim</h1><br /><a href='index.php'>Kembali ke Form</a>";
                    // echo '<h1>ERROR<br /><small>Error while sending email: '.$mail->getError().'</small></h1>'; // Aktifkan untuk mengetahui error message
                }
            } else { // Jika Ukuran file lebih dari 25 MB
                echo "<h1>Ukuran file attachment maksimal 25 MB</h1><br /><a href='index.php'>Kembali ke Form</a>";
            }
        }
    }
}

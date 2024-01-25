<?php

require_once('koneksi.php');

session_start();

if (isset($_GET['val'])) {
    $VAL = $_GET['val'];
}

// TAMBAH KWITANSI
if (isset($_POST['tambah'])) {

    if (isset($_GET['id'])) {
        $ID_USER = $_GET['id'];
    }

    $_SESSION['pos'] = $_POST;

    function generateRandomString($length = 20)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    $RANDOM = generateRandomString();

    $NAMA = $_POST['nama'];
    $EMAIL = $_POST['email'];
    $TANGGAL_BAYAR = $_POST['tanggalBayar'];
    $BULAN_REIMBURSE = $_POST['bulanReimburse'];
    $JUMLAH_BAYAR = $_POST['jumlahBayar'];
    $KETERANGAN = $_POST['keterangan'];

    $NAMA_KOST = $_POST['namaKost'];
    $ALAMAT_KOST = $_POST['alamatKost'];
    $HP_KOST = $_POST['hpKost'];
    $EMAIL_KOST = $_POST['emailKost'];
    $WEB_KOST = $_POST['websiteKost'];
    $PEMILIK_KOST = $_POST['pemilikKost'];

    $q = "INSERT INTO TAGIHAN (ID_USER, PAYMENT_ID, NAMA, TANGGAL_BAYAR, BULAN_REIMBURSE, TOTAL_BAYAR, KETERANGAN, TGL_INPUT, NAMA_KOST, ALAMAT_KOST, NO_TELEPON, EMAIL_KOST, WEBSITE_KOST, NAMA_PEMILIK, FLAG_HAPUS)
        VALUES ('$ID_USER', '$RANDOM', '$NAMA', '$TANGGAL_BAYAR', '$BULAN_REIMBURSE', '$JUMLAH_BAYAR', '$KETERANGAN', SYSDATE(), '$NAMA_KOST', '$ALAMAT_KOST', '$HP_KOST', '$EMAIL_KOST', '$WEB_KOST', '$PEMILIK_KOST', 0);";
    $sql = mysqli_query($conn, $q);

    // CURL FOR SEND TO WA
    $sql = mysqli_query($conn, "SELECT NO_HP FROM LOGIN WHERE ID = '$ID_USER'");
    $row = mysqli_fetch_assoc($sql);
    $no_hp = $row["NO_HP"];

    $isi_pesan = "*Receipt ID : ".$RANDOM."*
    --------------------------------------------
    Hello Mr/Mrs. ".$NAMA."
    *Here your Receipt Payment Doc (.pdf) :* http://e-receipt.website/cetakInvoice.php?id=$RANDOM
    --------------------------------------------
    Thank you for using E-Receipt.
    ";
    $v_isi_pesan = str_replace("<br>", CHR(13), $isi_pesan);

    $curl = curl_init();
    $token = "iJMqQmOZxQ9JPLj5KyKCQoD2FNik6Z3PjORO0dcMs7puRlsjPp";
    $data = [
        "receiver" => $no_hp,
        "device" => "6282118009042",
        "message" => $v_isi_pesan,
        "type" => "chat"
    ];
    // 083101058830

    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
            "Accept: application/json",
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer $token",
        ));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "https://app.whatspie.com/api/messages");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);

    if ($sql) {
        $_SESSION['pesan'] = "Your Receipt Payment Was Successfully Added!";
        header('location: indexInvoice.php');
    } else {
        $_SESSION['pesanError'] = "Your Receipt Payment Was Fail Added!";
        header('location: indexInvoice.php');
    }

    // UPDATE PROFILE PICTURE
} else if (isset($_POST['updateFoto'])) {

    $gambar = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    $id = $_POST['id'];
    $ukuran = $_FILES['foto']['size'];

    if ($ukuran > 2000000) {
        $_SESSION['pesanError'] = "<b>Your Photo Too Large! (Max. 2mb)</b>";
        header('location: updateProfile.php');
    } else {
        $q = "UPDATE LOGIN
        SET FOTO = '$gambar'
        WHERE ID = '$id' ";
        $sql = mysqli_query($conn, $q);

        if ($sql) {
            $_SESSION['pesan'] = "Your Profile Picture Was Updated!";
            header('location: updateProfile.php');
        } else {
            $_SESSION['pesanError'] = "There Was an Error When Update Your Profile Picture, Please Try Again!";
            header('location: updateProfile.php');
        }
    }

    // UPDATE PASSWORD
} else if (isset($_POST['updatePass'])) {

    $passAsli = $_POST['passAsli'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $id = $_POST['id'];

    $qCek = "SELECT PASSWORD FROM LOGIN WHERE ID = '$id'";
    $sqlCek = mysqli_query($conn, $qCek);
    $rowCek = mysqli_fetch_assoc($sqlCek);

    $PASS_DB = $rowCek['PASSWORD'];

    if ($passAsli != $PASS_DB) {
        $_SESSION['pesanErrorPass'] = "Your Old Password Are Wrong, Please Try Again!";
        header('location: updateProfile.php');
    } else {
        if ($pass1 != $pass2) {
            $_SESSION['pesanErrorPass'] = "Your Password Are Not Match, Please Try Again!";
            header('location: updateProfile.php');
        } else {
            $q = "UPDATE LOGIN
                    SET PASSWORD = '$pass1'
                    WHERE ID = '$id'";
            $sql = mysqli_query($conn, $q);

            if ($sql) {
                $_SESSION['pesanPass'] = "Your Password Was Successfully Change!";
                header('location: updateProfile.php');
            } else {
                $_SESSION['pesanErrorPass'] = "There Was an Error When Update Your Password, Please Try Again!";
                header('location: updateProfile.php');
            }
        }
    }
} else if ($VAL == "delete") {

    $id = $_GET["id"];

    $sql = mysqli_query($conn, "UPDATE TAGIHAN SET FLAG_HAPUS = 1 WHERE ID = '$id'");

    if ($sql) {
        $_SESSION['pesan'] = "Your Invoice Successfully Move to Trash. Check it From Your Trash on Sidebar!";
        header('location: indexInvoice.php');
    } else {
        $_SESSION['pesanError'] = "There Was an Error When Move Your Invoice to Your Trash, Please Try Again!";
        header('location: indexInvoice.php');
    }

} else if ($VAL == "restore") {

    $id = $_GET["id"];

    $sql = mysqli_query($conn, "UPDATE TAGIHAN SET FLAG_HAPUS = 0 WHERE ID = '$id'");

    if ($sql) {
        $_SESSION['pesan'] = "Your Invoice Successfully Move to Your Main List. Check it From Your Receipt Payment Menu!";
        header('location: trash.php');
    } else {
        $_SESSION['pesanError'] = "There Was an Error When Move Your Invoice to Your Main List, Please Try Again!";
        header('location: trash.php');
    }

} else if (isset($_POST["verifikasi_no_hp"])) {

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_sekarang = date('Y-m-d H:i:s');
    $tanggal_expired = date("Y-m-d H:i:s", strtotime("+3 minutes", strtotime($tanggal_sekarang)));

    $no_hp = $_POST["phone_no"];
    $id = $_POST["id"];
    $nama = $_POST["nama"];

    // GENERATE CODE
    function randomString($length = 6) {
        $str = "";
        $characters = array_merge(range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
    $code = randomString(6);

    $formated_phone_number = substr($no_hp,1);
    $number_code = "62" . $formated_phone_number;

    $sql = mysqli_query($conn, "SELECT COUNT(1) AS COUNT_CODE FROM CODE WHERE ID_USER = '$id'");
    $row = mysqli_fetch_assoc($sql);
    $count_code = $row["COUNT_CODE"];

    if ($count_code == 0) {
        // INSERT CODE FOR COMPARE
        $sql = mysqli_query($conn, "INSERT INTO CODE(id_user, phone_number, code, tgl_input) VALUES('$id', '$number_code', '$code', now())");
    } else {
        // UPDATE CODE FOR COMPARE
        $sql = mysqli_query($conn, "UPDATE CODE SET CODE = '$code', PHONE_NUMBER = '$number_code', TGL_INPUT = now() WHERE ID_USER = '$id'");
    }

    $isi_pesan = "Your E-Receipt verification code is : *".$code."*";

    // UPDATE PHONE_NO FOR LOGIN
    $sql = mysqli_query($conn, "UPDATE LOGIN SET NO_HP = '$number_code' WHERE ID = '$id'");

    // CURL FOR SEND TO WA
    $curl = curl_init();
    $token = "iJMqQmOZxQ9JPLj5KyKCQoD2FNik6Z3PjORO0dcMs7puRlsjPp";
    $data = [
        "receiver" => $number_code,
        "device" => "6282118009042",
        "message" => $isi_pesan,
        "type" => "chat"
    ];
    // 083101058830

    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
            "Accept: application/json",
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer $token",
        ));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "https://app.whatspie.com/api/messages");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);

    header('location: updatePhone.php?cnt=2');

} else if (isset($_POST["verification_code"])) {

    $verification_code = $_POST["code"];
    $id_user = $_POST["id"];

    $sql = mysqli_query($conn, "SELECT MAX(ID) AS MAX_ID FROM CODE WHERE ID_USER = '$id_user'");
    $row = mysqli_fetch_assoc($sql);
    $max_id = $row["MAX_ID"];

    $sql = mysqli_query($conn, "SELECT CODE AS CODE_DB FROM CODE WHERE ID = '$max_id'");
    $row = mysqli_fetch_assoc($sql);
    $code_db = $row["CODE_DB"];

    if ($verification_code != $code_db) {
        $_SESSION['pesanError'] = "Your code is wrong, please insert corectly!";
        header('location: updatePhone.php?cnt=2');
    } else {
        $sql = mysqli_query($conn, "UPDATE LOGIN SET VERIFIKASI_NO_HP = '1' WHERE ID = '$id_user'");
        $_SESSION['pesan'] = "Your Number Was Successfully Verified!";
        header('location: indexInvoice.php');
    }
    
} else if (isset($_POST["notifikasi"])) {

    $ijin_notifikasi = $_POST["ijin_notifikasi"];
    $id = $_POST["id"];

    $sql = mysqli_query($conn, "UPDATE LOGIN SET NOTIFIKASI = '$ijin_notifikasi' WHERE ID = '$id'");

    if ($sql) {
        // $_SESSION['pesan'] = "Your notification was Enabled";
        header('location: notifikasi.php');
    } else {
        // $_SESSION['pesanError'] = "Ther is an error whern enabled your notification";
        header('location: notifikasi.php');
    }
} else if (isset($_POST["suratpernyataan"])) {

    if (isset($_GET['id'])) {
        $ID_USER = $_GET['id'];
    }

    $_SESSION['pos'] = $_POST;

    $NIK = $_POST['nik'];
    $NAMA_KARYAWAN = $_POST['nama'];
    $JENIS_LISTRIK = $_POST['jenislistrik'];
    $NOMOR_METER = $_POST['nomormeter'];
    $NAMA_PELANGGAN = $_POST['namapelanggan'];
    $ALAMAT_KOST = $_POST['alamatKost'];
    $PEMILIK_KOST = $_POST['pemilikKost'];

    function generateRandomString($length = 20)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    date_default_timezone_set("Asia/Bangkok");
    $ID_LETTER = "ERECEIPT-SL-" . generateRandomString() . "-" . date('dmY-His');

    $q = "INSERT INTO PERNYATAAN (ID_USER, ID_LETTER, NIK, NAMA_KARYAWAN, JENIS_LISTRIK, NOMOR_METER, NAMA_PELANGGAN, ALAMAT, PEMILIK_KOST, TGL_INPUT)
        VALUES ('$ID_USER', '$ID_LETTER', '$NIK', '$NAMA_KARYAWAN', '$JENIS_LISTRIK', '$NOMOR_METER', '$NAMA_PELANGGAN', '$ALAMAT_KOST', '$PEMILIK_KOST', SYSDATE());";
    $sql = mysqli_query($conn, $q);

    // CURL FOR SEND TO WA
    $sql = mysqli_query($conn, "SELECT NO_HP FROM LOGIN WHERE ID = '$ID_USER'");
    $row = mysqli_fetch_assoc($sql);
    $no_hp = $row["NO_HP"];

    $isi_pesan = "
    Hello Mr/Mrs. ".$NAMA_KARYAWAN."
    
    *Here Your Statement Letter Doc (.pdf) :* http://e-receipt.website/cetak_pernyataan.php?id=$ID_LETTER
    
    Thank you for using E-Receipt :)
    ";
    $v_isi_pesan = str_replace("<br>", CHR(13), $isi_pesan);

    $curl = curl_init();
    $token = "iJMqQmOZxQ9JPLj5KyKCQoD2FNik6Z3PjORO0dcMs7puRlsjPp";
    $data = [
        "receiver" => $no_hp,
        "device" => "6282118009042",
        "message" => $v_isi_pesan,
        "type" => "chat"
    ];
    // 083101058830

    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
            "Accept: application/json",
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer $token",
        ));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "https://app.whatspie.com/api/messages");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);

    if ($sql) {
        $_SESSION['pesan'] = "Your Statement Letter Was Successfully Added!";
        $_SESSION['statement'] = "1";
        header('location: statement_letter.php');
    } else {
        $_SESSION['pesanError'] = "Your Statement Letter Was Fail Added!";
        $_SESSION['statement'] = "0";
        header('location: statement_letter.php');
    }

} else if (isset($_POST['updatestatement'])) {

    $ID_USER = $_POST["id_user"];
    $STATEMENT = $_POST["statement"];

    $sql = mysqli_query($conn, "UPDATE LOGIN SET STATEMENT = '$STATEMENT' WHERE ID = '$ID_USER'");

    if ($sql) {
        $_SESSION['pesan'] = "Access Granted";
        header('location: admin_statement_letter.php');
    } else {
        $_SESSION['pesanError'] = "Access Blocked";
        header('location: admin_statement_letter.php');
    }


}
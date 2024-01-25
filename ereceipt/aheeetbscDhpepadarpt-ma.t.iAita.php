<?php

session_start();

if (!isset($_SESSION['email']) && (!isset($_SESSION['password']))) {

    header('location:index.php');
}

include('header.php');

include('koneksi.php');

if (isset($_GET['id'])) {
    $ID_USER = $_GET['id'];
}

// GET MAX ID
$q = "SELECT MAX(ID) AS MAX_ID FROM TAGIHAN WHERE ID_USER = '$ID_USER'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$MAX_ID = $row['MAX_ID'];

$qCek = "SELECT COUNT(*) AS CNT_CEK FROM TAGIHAN WHERE ID_USER = '$ID_USER'";
$sqlCek = mysqli_query($conn, $qCek);
$row = mysqli_fetch_assoc($sqlCek);

$CNT_CEK = $row['CNT_CEK'];

if ($CNT_CEK > 0) {

    $q1 = "SELECT NAMA, NAMA_KOST, ALAMAT_KOST, NO_TELEPON, EMAIL_KOST, WEBSITE_KOST, NAMA_PEMILIK, KETERANGAN, TOTAL_BAYAR FROM TAGIHAN WHERE ID_USER = '$ID_USER' AND ID = '$MAX_ID' ";
    $sql1 = mysqli_query($conn, $q1);
    $row = mysqli_fetch_assoc($sql1);

    $NAMA = $row['NAMA'];
    $NAMA_KOST = $row['NAMA_KOST'];
    $ALAMAT_KOST = $row['ALAMAT_KOST'];
    $NO_TELEPON = $row['NO_TELEPON'];
    $EMAIL_KOST = $row['EMAIL_KOST'];
    $WEBSITE_KOST = $row['WEBSITE_KOST'];
    $NAMA_PEMILIK = $row['NAMA_PEMILIK'];

    $KETERANGAN = $row['KETERANGAN'];
    $TOTAL_BAYAR = $row['TOTAL_BAYAR'];

    $STATE = "readonly";
} else {
    $NAMA = "";
    $NAMA_KOST = "";
    $ALAMAT_KOST = "";
    $NO_TELEPON = "";
    $EMAIL_KOST = "";
    $WEBSITE_KOST = "";
    $NAMA_PEMILIK = "";

    $KETERANGAN = "";
    $TOTAL_BAYAR = "";

    $STATE = "";
}

?>

<div class="page-wrap">

    <?php include('sidebar.php') ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-6 col-sm-12 mb-4">
                    <h3>Create Receipt Payment | <?= $NAMA ?></h3>
                    <!-- <a href="cetakInvoice.php" target="_blank" type="button" class="btn btn-warning">Download</a>   -->
                </div>
            </div>

            <div class="card">
                <!-- <div class="card-header row"> -->
                <div class="col col-sm-12">
                    <!-- <div class="card-options d-inline-block">
                                        <h3>Keterangan Invoice</h3>
                                    </div> -->
                    <!-- <div class="alert alert-info mt-3" role="alert">
                        <b>Please make sure your data is right for not to re-print your receipt payment.</b>
                    </div> -->
                    <!-- </div> -->
                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive">
                        <form action="proses.php?id=<?= $ID_USER ?>" method="POST">
                            <table class="table">
                                <tr>
                                    <th colspan="2">
                                        <div class="alert alert-info mt-3" role="alert">
                                            <b>Boarding House Details</b>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="30%">Boarding House Name <i>(Nama Kost)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input type="text" class="form-control" id="namaKost" name="namaKost" value="<?= $NAMA_KOST ?>" required>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Boarding House Address <i>(Alamat Kost)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input type="text" class="form-control" id="alamatKost" name="alamatKost" value="<?= $ALAMAT_KOST ?>" required>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Boarding House Phone <i>(Nomor Telepon Kost)</i></th>
                                    <th>
                                        <input type="text" class="form-control" id="hpKost" name="hpKost" value="<?= $NO_TELEPON ?>">
                                    </th>
                                </tr>
                                <tr>
                                    <th>Boarding House Email <i>(Email Kost)</i></th>
                                    <th>
                                        <input type="text" class="form-control" id="emailKost" name="emailKost" value="<?= $EMAIL_KOST ?>">
                                    </th>
                                </tr>
                                <tr>
                                    <th>Boarding House Website <i>(Website Kost)</i></th>
                                    <th>
                                        <input type="text" class="form-control" id="websiteKost" name="websiteKost" value="<?= $WEBSITE_KOST ?>">
                                    </th>
                                </tr>
                                <tr>
                                    <th>Boarding House Owner's Name <i>(Nama Pemilik Kost)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input type="text" class="form-control" id="pemilikKost" name="pemilikKost" value="<?= $NAMA_PEMILIK ?>" required>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        <div class="alert alert-info mt-3" role="alert">
                                            <b>Your Details</b>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Full Name <i>(Nama Lengkap)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input type="text" class="form-control" id="nama" name="nama" onkeyup="this.value = this.value.toUpperCase()" value="<?= $NAMA ?>" <?= $STATE ?> />
                                    </th>
                                </tr>
                                <tr>
                                    <th>Date of Payment <i>(Tanggal Pembayaran)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input type="date" class="form-control" id="tanggalBayar" name="tanggalBayar" required>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Month of Reimburse <i>(Bulan Reimburse)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input class="form-control" type="month" id="bulanReimburse" name="bulanReimburse" required />
                                    </th>
                                </tr>
                                <tr>
                                    <th>Amount of Payment <i>(Jumlah Pembayaran)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input type="text" class="form-control" id="jumlahBayar" name="jumlahBayar" value="<?= $TOTAL_BAYAR ?>" required>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Payment Information <i>(Keterangan Pembayaran)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input type="text" class="form-control" id="keterangan" name="keterangan" onkeyup="this.value = this.value.toUpperCase()" value="<?= $KETERANGAN ?>" required>
                                    </th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th><button type="submit" name="tambah" class="btn btn-success"><i class="fas fa-plus-circle"></i> Create Receipt Payment</button></th>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('sidebarMessage.php') ?>

    <?php include('footer1.php') ?>

</div>
</div>

<script type="text/javascript">
    var rupiah = document.getElementById('jumlahBayar');
    rupiah.addEventListener('keyup', function(e) {
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>

<?php

include('panelSetting.php');

include('footer.php')

?>
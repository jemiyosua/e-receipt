<?php

session_start();

include('header.php');

if (isset($_SESSION['pos'])) {

    $NAMA = $_SESSION['pos']['nama'];
    $TANGGAL_BAYAR = $_SESSION['pos']['tanggalBayar'];
    $BULAN_REIMBURSE = $_SESSION['pos']['bulanReimburse'];
    $JUMLAH_BAYAR = $_SESSION['pos']['jumlahBayar'];
    $KETERANGAN = $_SESSION['pos']['keterangan'];

    $NAMA_KOST = $_SESSION['pos']['namaKost'];
    $ALAMAT_KOST = $_SESSION['pos']['alamatKost'];
    $HP_KOST = $_SESSION['pos']['hpKost'];
    $EMAIL_KOST = $_SESSION['pos']['emailKost'];
    $WEB_KOST = $_SESSION['pos']['websiteKost'];
    $PEMILIK_KOST = $_SESSION['pos']['pemilikKost'];
} else {
    $NAMA = "";
    $TANGGAL_BAYAR = "";
    $BULAN_REIMBURSE = "";
    $JUMLAH_BAYAR = "";
    $KETERANGAN = "";

    $NAMA_KOST = "";
    $ALAMAT_KOST = "";
    $HP_KOST = "";
    $EMAIL_KOST = "";
    $WEB_KOST = "";
    $PEMILIK_KOST = "";
}

?>

<div class="page-wrap">

    <?php include('sidebar.php') ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-6 col-sm-12 mb-4">
                    <h3>Boarding House | Create Receipt Payment</h3>
                    <!-- <a href="cetakInvoice.php" target="_blank" type="button" class="btn btn-warning">Download</a>   -->
                </div>
            </div>

            <?php
            if (isset($_SESSION['pesan'])) {
                echo "<div class='alert alert-success' role='alert' style='border-radius:10px;'>" . $_SESSION['pesan'] . "</div>";
                unset($_SESSION['pesan']);
            } else if (isset($_SESSION['pesanError'])) {
                echo "<div class='alert alert-warning' role='alert' style='border-radius:10px;'>" . $_SESSION['pesanError'] . "</div>";
                unset($_SESSION['pesanError']);
            }
            ?>

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
                        <form action="proses.php" method="POST">
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
                                        <input type="text" class="form-control" id="hpKost" name="hpKost" value="<?= $HP_KOST ?>">
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
                                        <input type="text" class="form-control" id="websiteKost" name="websiteKost" value="<?= $WEB_KOST ?>">
                                    </th>
                                </tr>
                                <tr>
                                    <th>Boarding House Owner's Name <i>(Nama Pemilik Kost)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input type="text" class="form-control" id="pemilikKost" name="pemilikKost" value="<?= $PEMILIK_KOST ?>" required>
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
                                        <input type="text" class="form-control" id="nama" name="nama" onkeyup="this.value = this.value.toUpperCase()" value="<?= $NAMA ?>" required>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Date of Payment <i>(Tanggal Pembayaran)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input type="date" class="form-control" id="tanggalBayar" name="tanggalBayar" value="<?= $TANGGAL_BAYAR ?>" required>
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
                                        <input type="text" class="form-control" id="jumlahBayar" name="jumlahBayar" value="<?= $JUMLAH_BAYAR ?>" required>
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
                                    <th><button type="submit" name="tambah" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add Receipt</button></th>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('sidebarMessage.php') ?>

    <div class="chat-panel" hidden>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <a href="javascript:void(0);"><i class="ik ik-message-square text-success"></i></a>
                <span class="user-name">John Doe</span>
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="card-body">
                <div class="widget-chat-activity flex-1">
                    <div class="messages">
                        <div class="message media reply">
                            <figure class="user--online">
                                <a href="#">
                                    <img src="img/users/3.jpg" class="rounded-circle" alt="">
                                </a>
                            </figure>
                            <div class="message-body media-body">
                                <p>Epic Cheeseburgers come in all kind of styles.</p>
                            </div>
                        </div>
                        <div class="message media">
                            <figure class="user--online">
                                <a href="#">
                                    <img src="img/users/1.jpg" class="rounded-circle" alt="">
                                </a>
                            </figure>
                            <div class="message-body media-body">
                                <p>Cheeseburgers make your knees weak.</p>
                            </div>
                        </div>
                        <div class="message media reply">
                            <figure class="user--offline">
                                <a href="#">
                                    <img src="img/users/5.jpg" class="rounded-circle" alt="">
                                </a>
                            </figure>
                            <div class="message-body media-body">
                                <p>Cheeseburgers will never let you down.</p>
                                <p>They'll also never run around or desert you.</p>
                            </div>
                        </div>
                        <div class="message media">
                            <figure class="user--online">
                                <a href="#">
                                    <img src="img/users/1.jpg" class="rounded-circle" alt="">
                                </a>
                            </figure>
                            <div class="message-body media-body">
                                <p>A great cheeseburger is a gastronomical event.</p>
                            </div>
                        </div>
                        <div class="message media reply">
                            <figure class="user--busy">
                                <a href="#">
                                    <img src="img/users/5.jpg" class="rounded-circle" alt="">
                                </a>
                            </figure>
                            <div class="message-body media-body">
                                <p>There's a cheesy incarnation waiting for you no matter what you palete preferences are.</p>
                            </div>
                        </div>
                        <div class="message media">
                            <figure class="user--online">
                                <a href="#">
                                    <img src="img/users/1.jpg" class="rounded-circle" alt="">
                                </a>
                            </figure>
                            <div class="message-body media-body">
                                <p>If you are a vegan, we are sorry for you loss.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="javascript:void(0)" class="card-footer" method="post">
                <div class="d-flex justify-content-end">
                    <textarea class="border-0 flex-1" rows="1" placeholder="Type your message here"></textarea>
                    <button class="btn btn-icon" type="submit"><i class="ik ik-arrow-right text-success"></i></button>
                </div>
            </form>
        </div>
    </div>

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
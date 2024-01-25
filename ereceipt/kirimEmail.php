<?php

session_start();

if (!isset($_SESSION['email']) && (!isset($_SESSION['password']))) {

    header('location:index.php');
}

include('header.php');

require_once('koneksi.php');

if (isset($_GET['id']) && isset($_GET['idUser'])) {
    $ID = $_GET['id'];
    $ID_USER = $_GET['idUser'];
}

// GET MAX ID
// $q = "SELECT MAX(ID) AS MAX_ID FROM TAGIHAN WHERE ID_USER = '$ID_USER'";
// $sql = mysqli_query($conn, $q);
// $row = mysqli_fetch_assoc($sql);

// $MAX_ID = $row['MAX_ID'];

// GET ALL DATA
$q1 = "SELECT EMAIL FROM LOGIN WHERE ID = '$ID_USER' ";
$sql1 = mysqli_query($conn, $q1);
$row = mysqli_fetch_assoc($sql1);

$EMAIL = $row['EMAIL'];

?>

<div class="page-wrap">

    <?php include('sidebar.php') ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-6 col-sm-12 mb-4">
                    <h3>Sending E-receipt</h3>
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
                        <form action="kirim.php?id=<?= $ID ?>" method="POST">
                            <table class="table">
                                <tr>
                                    <th colspan="2">
                                        <div class="alert alert-info mt-3" role="alert">
                                            <b>Please check your email address before send your E-receipt</b>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="30%">Where do you will send this receipt? <i>(Alamat Email Penerima)</i> <text style="color:red">*</text></th>
                                    <th>
                                        <input type="email" class="form-control" id="emailPenerima" name="emailPenerima" value="<?= $EMAIL ?>" required>
                                    </th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th><button type="submit" name="kirim" class="btn btn-success"><i class='fas fa-paper-plane'></i> Send</button></th>
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
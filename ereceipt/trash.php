<?php

require_once('koneksi.php');

session_start();

if (!isset($_SESSION['email']) && (!isset($_SESSION['password']))) {

    header('location:index.php');
}

include('header.php');

$email = $_SESSION['email'];
$password = $_SESSION['password'];

$q = "SELECT ID, EMAIL FROM LOGIN WHERE EMAIL = '$email'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$ID_USER = $row['ID'];
$EMAIL = $row['EMAIL'];

// ===============================================

$qCek = "SELECT COUNT(*) AS CNT_CEK FROM TAGIHAN WHERE ID_USER = '$ID_USER'";
$sqlCek = mysqli_query($conn, $qCek);
$row = mysqli_fetch_assoc($sqlCek);

$CNT_CEK = $row['CNT_CEK'];

// ===============================================

$q = "SELECT COUNT(1) AS CNT_TOTAL FROM TAGIHAN WHERE ID_USER = '$ID_USER' AND FLAG_HAPUS = 1";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$TOTAL = $row['CNT_TOTAL'];

// ===============================================

$q = "SELECT FOTO FROM LOGIN WHERE ID = '$ID_USER'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$FOTO = $row['FOTO'];

if ($FOTO == "") {
    $src = "img/profile.png";
} else {
    $src = "LihatGambar.php?id=$ID_USER";
}

// ===============================================

$TAHUN = date('Y');

?>


<div class="page-wrap">

    <?php include('sidebar.php') ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>Receipt Payment in Trash</h6>
                                    <div class="mt-3"></div>
                                    <h2><?= $TOTAL ?></h2>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                            </div>
                        </div>
                        <HR>
                        <div class="card-body">
                            <form>
                                <label>Search Month of Your Invoice Reimburse</label>
                                <div class="input-group input-group-sm">

                                    <input class="form-control" type="month" id="cari" name="cari" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (isset($_SESSION['pesan'])) {
                // echo "<div class='alert alert-success' role='alert' style='border-radius:10px;'>" . $_SESSION['pesan'] . "</div>";
                echo "<script>
                Swal.fire({
                    allowEnterKey: false,
                    allowOutsideClick: false,
                    icon: 'success',
                    title: 'Good Job :)',
                    text: '".$_SESSION['pesan']."'
                }).then(function() {
                    window.location.href='trash.php';
                });
                </script>";
                unset($_SESSION['pesan']);
            } else if (isset($_SESSION['pesanError'])) {
                // echo "<div class='alert alert-warning' role='alert' style='border-radius:10px;'>" . $_SESSION['pesanError'] . "</div>";
                echo "<script>
                Swal.fire({
                    allowEnterKey: false,
                    allowOutsideClick: false,
                    icon: 'error',
                    title: 'Sorry :(',
                    text: '".$_SESSION['pesanError']."'
                }).then(function() {
                    window.location.href='trash.php';
                });
                </script>";
                unset($_SESSION['pesanError']);
            }
            ?>

            <div class="card">
                <div class="card-header">
                    <h3 style="font-weight: bold;">List of Your Receipt</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Profile</th>
                                <th scope="col">No</th>
                                <th scope="col">Payment ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date of Payment</th>
                                <th scope="col">Month of Reimburse</th>
                                <th scope="col">Amount of Payment</th>
                                <th scope="col">Payment Information</th>
                                <th scope="col">Create Date</th>
                                <th scope="col">Restore Data</th>
                                <!-- <th scope="col">Send to Your Email</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $page = (isset($_GET['page'])) ? $_GET['page'] : 1;

                            $limit = 5; // Jumlah data per halamannya

                            // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
                            $limit_start = ($page - 1) * $limit;

                            $NO = $limit_start + 1;

                            if (isset($_GET['cari'])) {
                                $cari = $_GET['cari'];

                                if ($cari == "") {
                                    $q = "SELECT ID, PAYMENT_ID, NAMA, TANGGAL_BAYAR, BULAN_REIMBURSE, TOTAL_BAYAR, KETERANGAN, TGL_INPUT FROM TAGIHAN WHERE ID_USER = '$ID_USER' AND FLAG_HAPUS = 1 ORDER BY TGL_INPUT DESC LIMIT $limit_start, $limit";
                                    $sql = mysqli_query($conn, $q);
                                } else {
                                    $q = "SELECT ID, PAYMENT_ID, NAMA, TANGGAL_BAYAR, BULAN_REIMBURSE, TOTAL_BAYAR, KETERANGAN, TGL_INPUT FROM TAGIHAN WHERE ID_USER = '$ID_USER' AND BULAN_REIMBURSE LIKE '%" . $cari . "%' AND FLAG_HAPUS = 1 ORDER BY NAMA DESC";
                                    $sql = mysqli_query($conn, $q);
                                }
                            } else {
                                $q = "SELECT ID, PAYMENT_ID, NAMA, TANGGAL_BAYAR, BULAN_REIMBURSE, TOTAL_BAYAR, KETERANGAN, TGL_INPUT FROM TAGIHAN WHERE ID_USER = '$ID_USER' AND FLAG_HAPUS = 1 ORDER BY TGL_INPUT DESC LIMIT $limit_start, $limit";
                                $sql = mysqli_query($conn, $q);
                            }

                            // $NO = 0;

                            if ($CNT_CEK == 0) {
                                echo "<tr>
                                    <td colspan='11'>
                                        <div class='alert alert-warning' role='alert'>
                                            <h5 class='alert-heading'>Hello, <b>$EMAIL</b></h5>
                                            <b>You don't have any history from your receipt payment</b>
                                        </div>
                                    </td>
                                </tr>";
                            }

                            while ($row = mysqli_fetch_assoc($sql)) {

                                // $NO++;
                                $ID = $row['ID'];
                                $PAYMENT_ID = $row['PAYMENT_ID'];
                                $NAMA = $row['NAMA'];
                                $TANGGAL_BAYAR = $row['TANGGAL_BAYAR'];
                                $VTANGGAL_BAYAR = date('d F Y', strtotime($TANGGAL_BAYAR));
                                $BULAN_REIMBURSE = $row['BULAN_REIMBURSE'];
                                $VBULAN_REIMBURSE = date('F Y', strtotime($BULAN_REIMBURSE));
                                $TOTAL_BAYAR = $row['TOTAL_BAYAR'];
                                $KETERANGAN = $row['KETERANGAN'];
                                $TGL_INPUT = $row['TGL_INPUT'];

                                echo "
                                <tr>
                                    <td><img src='$src' style='border-radius: 50%;width:50px;height:50px'></td>
                                    <td>$NO</td>
                                    <td>$PAYMENT_ID</td>
                                    <td><b>$NAMA</b></td>
                                    <td>$VTANGGAL_BAYAR</td>
                                    <td>$VBULAN_REIMBURSE</td>
                                    <td>$TOTAL_BAYAR</td>
                                    <td>$KETERANGAN</td>
                                    <td>$TGL_INPUT</td>
                                    <td>
                                        <a href='proses.php?id=$ID&val=restore' type='button' class='btn btn-success'><i class='fas fa-undo-alt'></i> Restore Your Invoice</a>
                                    </td>
                                </tr>
                                ";

                                $NO++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Page navigation example" style="padding-top: 30px;padding-left: 15px">
                    <ul class="pagination">
                        <!-- LINK FIRST AND PREV -->
                        <?php

                        if ($page == 1) { // Jika page adalah page ke 1, maka disable link PREV
                            echo "<li class='page-item disbled'><a class='page-link' href='#'>First</a></li>";
                            echo "<li class='page-item disbled'><a class='page-link' href='#'>&laquo;</a></li>";
                        } else { // Jika page bukan page ke 1
                            $link_prev = ($page > 1) ? $page - 1 : 1;
                            echo "<li class='page-item'><a class='page-link' href='indexInvoice.php?page=1'>First</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='indexInvoice.php?page=$link_prev'>&laquo;</a></li>";
                        }

                        // Buat query untuk menghitung semua jumlah data
                        $q = "SELECT COUNT(*) AS CNT FROM TAGIHAN WHERE ID_USER = '$ID_USER' AND FLAG_HAPUS = 1 ";
                        $sql = mysqli_query($conn, $q);
                        $row = mysqli_fetch_assoc($sql);
                        $jumlah = $row['CNT'];

                        $jumlah_page = ceil($jumlah / $limit); // Hitung jumlah halamannya
                        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                        $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
                        $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

                        for ($i = $start_number; $i <= $end_number; $i++) {

                            $link_active = ($page == $i) ? ' class="page-item active"' : '';

                            echo "<li$link_active><a class='page-link' href='indexInvoice.php?page=$i'>$i</a></li>";
                        }

                        // LINK NEXT AND LAST

                        // Jika page sama dengan jumlah page, maka disable link NEXT nya
                        // Artinya page tersebut adalah page terakhir 
                        if ($page == $jumlah_page) { // Jika page terakhir
                            echo "<li class='page-item disbled'><a class='page-link' href='#'>&raquo;</a></li>";
                            echo "<li class='page-item disbled'><a class='page-link' href='#'>Last</a></li>";
                        } else { // Jika Bukan page terakhir
                            $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

                            echo "<li class='page-item'><a class='page-link' href='indexInvoice.php?page=$link_next'>&raquo;</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='indexInvoice.php?page=$jumlah_page'>Last</a></li>";
                        }

                        ?>
                    </ul>
                </nav>

            </div>
        </div>
    </div>

    <?php

    include('sidebarMessage.php');

    include('footer1.php');

    ?>

</div>
</div>

<?php

include('panelSetting.php');

include('footer.php')

?>
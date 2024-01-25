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

$qCek = "SELECT COUNT(*) AS CNT_CEK FROM PERNYATAAN WHERE ID_USER = '$ID_USER'";
$sqlCek = mysqli_query($conn, $qCek);
$row = mysqli_fetch_assoc($sqlCek);

$CNT_CEK = $row['CNT_CEK'];

// ===============================================

$q = "SELECT COUNT(1) AS CNT_TOTAL FROM PERNYATAAN WHERE ID_USER = '$ID_USER'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$TOTAL = $row['CNT_TOTAL'];

// ===============================================

$sql = mysqli_query($conn, "SELECT NAMA FROM TAGIHAN WHERE ID_USER = '$ID_USER'");
$row = mysqli_fetch_assoc($sql);

$NAMA = $row['NAMA'];

if ($NAMA == "") {
    $VNAMA = $EMAIL;
} else {
    $VNAMA = $NAMA;
}

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

// GET VERIFICATION NO HP
$sql = mysqli_query($conn, "SELECT VERIFIKASI_NO_HP FROM LOGIN WHERE ID = '$ID_USER' ");
$row = mysqli_fetch_assoc($sql);
$cnt_hp = $row["VERIFIKASI_NO_HP"];

$q = "SELECT COUNT(1) AS CNT FROM PERNYATAAN WHERE ID_USER = '$ID_USER'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$CNT_PERNYATAAN = $row['CNT'];

if ($cnt_hp == 0 && $CNT_PERNYATAAN == 0) {
    // belum verifikasi nomor HP
    // - button ilang
    // - tulisan : Please verification your phone number
    $message = "<div style='padding-top:20px'><div class='alert alert-info' role='alert' style='border-radius:10px;'><b>Sorry for the interuption</b><hr>You cannot create your Receipt Payment, <br> Please verification your phone number first at Verification Phone Number Menu, Thank You :)</div></div>";
    $button = "";
    $PESAN_ALL = "";
} else if ($cnt_hp == 1 && $CNT_PERNYATAAN == 0) {
    // sudah verifikasi nomor HP tapi belum membuat surat pernyataan
    // - button muncul
    // - tulisan : Your Number is Verified! 
    $message = "";
    $button = '<div class="mt-3">
    <a href="create_statement_letter.php?id=' . $ID_USER . '" type="button" class="btn btn-warning btn-block"><i class="fas fa-file-invoice"></i> Create Statement Letter</a>
    </div>';
    $PESAN_ALL = '<div class="alert alert-warning" role="alert" style="border-radius:10px;font-weight: bold;">You only can create Statement Letter <b>1 time</b>, please be wise when create your letter</div>';
} else {
    $message = "";
    $button = "";
    $PESAN_ALL = '<div class="alert alert-success" role="alert" style="border-radius:10px;font-weight: bold;">Congratulations! You already create your Statement Letter!</div>';
}

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
                                    <h6>Statement Letter</h6>
                                    <div class="mt-3"></div>
                                    <h2><?= $TOTAL ?></h2>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                            </div>
                            <hr>
                            <?= $PESAN_ALL; ?>
                            <?= $button; ?>
                            <?= $message ?>
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
                    window.location.href='statement_letter.php';
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
                    window.location.href='statement_letter.php';
                });
                </script>";
                unset($_SESSION['pesanError']);
            }
            ?>
            
            <div class="col-lg-9 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 style="font-weight: bold;">Your Statement Letter</h3>
                    </div>
                    <div class="card-body">
                    <!-- <div class="alert alert-info" role="alert" style="border-radius:10px;font-weight: bold;">You can manage your schedule notification from Schedule Notification Menu.</div> -->
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Profile</th>
                                    <th scope="col">NIK</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Type of Electricity</th>
                                    <th scope="col">Electricity Number</th>
                                    <th scope="col">Electricity Customer Name</th>
                                    <th scope="col">Create Date</th>
                                    <th scope="col">Statement Letter</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $page = (isset($_GET['page'])) ? $_GET['page'] : 1;

                                $limit = 10; // Jumlah data per halamannya

                                // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
                                $limit_start = ($page - 1) * $limit;

                                $NO = $limit_start + 1;

                                $q = "SELECT ID_LETTER, NIK, NAMA_KARYAWAN, JENIS_LISTRIK, NOMOR_METER, NAMA_PELANGGAN, ALAMAT, PEMILIK_KOST, TGL_INPUT FROM PERNYATAAN WHERE ID_USER = '$ID_USER' ORDER BY TGL_INPUT DESC LIMIT $limit_start, $limit";
                                $sql = mysqli_query($conn, $q);

                                // $NO = 0;

                                if ($CNT_CEK == 0) {
                                    echo "<tr>
                                        <td colspan='10'>
                                            <div class='alert alert-warning' role='alert'>
                                                <h5 class='alert-heading'>Hello, <b>$VNAMA</b></h5>
                                                <b>You don't have any history from your Statement Letter before</b>
                                            </div>
                                        </td>
                                    </tr>";
                                }

                                while ($row = mysqli_fetch_assoc($sql)) {

                                    // $NO++;
                                    $ID_LETTER = $row['ID_LETTER'];
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
                                    $TGL_INPUT = $row['TGL_INPUT'];

                                    echo "
                                    <tr>
                                        <td><img src='$src' style='border-radius: 50%;width:50px;height:50px'></td>
                                        <td>$NIK</td>
                                        <td><b>$NAMA_KARYAWAN</b></td>
                                        <td>$VJENIS_LISTRIK</td>
                                        <td>$NOMOR_METER</td>
                                        <td>$NAMA_PELANGGAN</td>
                                        <td>$TGL_INPUT</td>
                                        <td>
                                            <a href='cetak_pernyataan.php?id=$ID_LETTER' target='_blank' type='button' class='btn btn-success btn-block'><i class='fas fa-print'></i> Print Letter</a>
                                        </td>
                                    </tr>
                                    ";

                                    $NO++;
                                }
                                ?>
                            </tbody>
                            <thead>
                                <tr>
                                    <th scope="col">Profile</th>
                                    <th scope="col">NIK</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Type of Electricity</th>
                                    <th scope="col">Electricity Number</th>
                                    <th scope="col">Electricity Customer Name</th>
                                    <th scope="col">Create Date</th>
                                    <th scope="col">Statement Letter</th>
                                </tr>
                            </thead>
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
                            $q = "SELECT COUNT(1) AS CNT FROM PERNYATAAN WHERE ID_USER = '$ID_USER' ";
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

        </div>
    </div>

    <?php include('sidebarMessage.php') ?>

    <?php include('footer1.php') ?>

</div>
</div>

<?php

include('panelSetting.php');

include('footer.php')

?>
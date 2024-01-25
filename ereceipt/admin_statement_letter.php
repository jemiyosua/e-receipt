<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:index.php');
}

require_once('koneksi.php');

include('header.php');

$email = $_SESSION['email'];
$password = $_SESSION['password'];

$q = "SELECT ID FROM LOGIN WHERE EMAIL = '$email'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$ID_USER = $row['ID'];

// ===============================================

$q = "SELECT COUNT(1) AS CNT_TOTAL FROM LOGIN";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$TOTAL = $row['CNT_TOTAL'];

$TAHUN = date('Y');

?>


<div class="page-wrap">

    <?php include('sidebarAdmin.php') ?>

    <div class="main-content">
        <div class="container-fluid">
            <!-- <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>E - Receipt Account</h6>
                                    <div class="mt-3"></div>
                                    <h2><?= $TOTAL ?></h2>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>

                            </div>
                            <div class="mt-3"><a href="tambahDataAda.php?id=<?= $ID_USER ?>" type="button" class="btn btn-warning btn-block"><i class="fas fa-file-invoice-dollar"></i> Create Receipt</a></div>
                        </div>
                    </div>
                </div>
            </div> -->

            <?php
                    if (isset($_SESSION['pesan'])) {
                        // echo "<div class='alert alert-success' role='alert' style='border-radius:10px;'>" . $_SESSION['pesan'] . "</div>";
                        echo "<script>
                        Swal.fire({
                            allowEnterKey: false,
                            allowOutsideClick: false,
                            icon: 'success',
                            title: 'Good Job :)',
                            text: '" . $_SESSION['pesan'] . "'
                        }).then(function() {
                            window.location.href='admin_statement_letter.php';
                        });
                        </script>";
                        unset($_SESSION['pesan']);
                    } else if (isset($_SESSION['pesanError'])) {
                        // echo "<div class='alert alert-warning' role='alert' style='border-radius:10px;'><b>" . $_SESSION['pesanError'] . "</b></div>";
                        echo "<script>
                        Swal.fire({
                            allowEnterKey: false,
                            allowOutsideClick: false,
                            icon: 'error',
                            title: 'Sorry :(',
                            text: '" . $_SESSION['pesanError'] . "'
                        }).then(function() {
                            window.location.href='admin_statement_letter.php';
                        });
                        </script>";
                        unset($_SESSION['pesanError']);
                    }
                ?>

            <div class="card">
                <div class="card-header row">
                    <div class="col col-sm-9">
                        <div class="card-options d-inline-block">
                            <h3>Statement Letter</h3>
                            <form>
                                <div class="input-group input-group-sm" style="padding-top:20px">
                                    <input type="text" name="cari" id="cari" class="form-control" placeholder="Cari Nama ... ">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID User</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
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
                                    $q = "SELECT DISTINCT a.ID, a.EMAIL, b.NAMA, a.STATEMENT FROM LOGIN a, TAGIHAN b WHERE a.ID = b.ID_USER ORDER BY b.ID ASC LIMIT $limit_start, $limit";
                                    $sql = mysqli_query($conn, $q);
                                } else {
                                    $q = "SELECT DISTINCT a.ID, a.EMAIL, b.NAMA, a.STATEMENT FROM LOGIN a, TAGIHAN b WHERE a.ID = b.ID_USER AND b.NAMA LIKE '%" . $cari . "%' ORDER BY b.ID ASC";
                                    $sql = mysqli_query($conn, $q);
                                }
                            } else {
                                $q = "SELECT DISTINCT a.ID, a.EMAIL, b.NAMA, a.STATEMENT FROM LOGIN a, TAGIHAN b WHERE a.ID = b.ID_USER ORDER BY b.ID ASC LIMIT $limit_start, $limit";
                                $sql = mysqli_query($conn, $q);
                            }

                            // $NO = 0;

                            while ($row = mysqli_fetch_assoc($sql)) {

                                // $NO++;
                                $ID_USER_JOIN = $row['ID'];
                                $EMAIL = $row['EMAIL'];
                                $NAMA = $row['NAMA'];
                                $STATEMENT = $row['STATEMENT'];

                                if ($STATEMENT == 0) {
                                    $STATUS = '
                                    <span class="badge rounded-pill bg-danger text-light">Access Blocked</span>
                                    ';
                                    $SELECTED = "selected";
                                } else {
                                    $STATUS = '
                                    <span class="badge rounded-pill bg-success">Access Granted</span>
                                    ';
                                    $SELECTED = "selected";
                                }

                                echo "
                                <tr>
                                    <td>$NO</td>
                                    <td>$ID_USER_JOIN</td>
                                    <td><b>$NAMA</b></td>
                                    <td>$STATUS</td>
                                    <td>
                                        <a href='update_admin_statement_letter.php?id=$ID_USER_JOIN' class='btn btn-outline-primary' >Update</a>
                                    </td>
                                </tr>
                                ";

                                $NO++;
                                // }
                            }

                            ?>
                        </tbody>
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID User</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
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
                            echo "<li class='page-item'><a class='page-link' href='admin_statement_letter.php?page=1'>First</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='admin_statement_letter.php?page=$link_prev'>&laquo;</a></li>";
                        }

                        // Buat query untuk menghitung semua jumlah data
                        $q = "SELECT COUNT(DISTINCT a.email) AS CNT_TOTAL FROM LOGIN a, TAGIHAN b WHERE a.ID = b.ID_USER";
                        $sql = mysqli_query($conn, $q);
                        $row = mysqli_fetch_assoc($sql);
                        $jumlah = $row['CNT_TOTAL'];

                        $jumlah_page = ceil($jumlah / $limit); // Hitung jumlah halamannya
                        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                        $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
                        $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

                        for ($i = $start_number; $i <= $end_number; $i++) {

                            $link_active = ($page == $i) ? ' class="page-item active"' : '';

                            echo "<li$link_active><a class='page-link' href='admin_statement_letter.php?page=$i'>$i</a></li>";
                        }

                        // LINK NEXT AND LAST

                        // Jika page sama dengan jumlah page, maka disable link NEXT nya
                        // Artinya page tersebut adalah page terakhir 
                        if ($page == $jumlah_page) { // Jika page terakhir
                            echo "<li class='page-item disbled'><a class='page-link' href='#'>&raquo;</a></li>";
                            echo "<li class='page-item disbled'><a class='page-link' href='#'>Last</a></li>";
                        } else { // Jika Bukan page terakhir
                            $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;

                            echo "<li class='page-item'><a class='page-link' href='admin_statement_letter.php?page=$link_next'>&raquo;</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='admin_statement_letter.php?page=$jumlah_page'>Last</a></li>";
                        }

                        ?>
                    </ul>
                </nav>

            </div>
        </div>
    </div>

    <?php include('sidebarMessage.php') ?>

    <?php include('footer1.php') ?>

</div>
</div>

<?php

include('panelSetting.php');

include('footer.php');

?>
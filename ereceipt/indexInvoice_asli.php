<?php

require_once('koneksi.php');

include('header.php');

$q = "SELECT COUNT(1) AS CNT_TOTAL FROM TAGIHAN";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$TOTAL = $row['CNT_TOTAL'];

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
                                    <h6>Receipt Payment</h6>
                                    <h2><?= $TOTAL ?></h2>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>

                            </div>
                            <div class="mt-3"><a href="tambahData.php" type="button" class="btn btn-warning btn-block"><i class="fas fa-file-invoice-dollar"></i> Create Receipt</a></div>
                        </div>
                    </div>
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
                <div class="card-header row">
                    <div class="col col-sm-9">
                        <div class="card-options d-inline-block">
                            <h3>List of Receipt</h3>
                        </div>
                    </div>
                    <form>
                        <div class="input-group input-group-sm" style="padding-top:20px">
                            <input type="text" name="cari" id="cari" class="form-control" placeholder="Cari Nama Anda ... ">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                    <!-- <div class="col col-sm-6">
                                    <div class="card-search with-adv-search dropdown">
                                        <form action=""> -->
                    <!-- <input type="text" class="form-control global_filter" id="global_filter" placeholder="Search.." required> -->
                    <!-- <button type="submit" class="btn btn-icon"><i class="ik ik-search"></i></button> -->
                    <!-- <button type="button" id="adv_wrap_toggler" class="adv-btn ik ik-chevron-down dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button> -->
                    <!-- <div class="adv-search-wrap dropdown-menu dropdown-menu-right" aria-labelledby="adv_wrap_toggler">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control column_filter" id="col0_filter" placeholder="Name" data-column="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control column_filter" id="col1_filter" placeholder="Position" data-column="1">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control column_filter" id="col2_filter" placeholder="Office" data-column="2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control column_filter" id="col3_filter" placeholder="Age" data-column="3">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control column_filter" id="col4_filter" placeholder="Start date" data-column="4">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control column_filter" id="col5_filter" placeholder="Salary" data-column="5">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-theme">Search</button>
                                            </div> -->
                    <!-- </form>
                                    </div>
                                </div> -->
                    <!-- <div class="col col-sm-3">
                                    <div class="card-options text-right">
                                        <span class="mr-5" id="top">1 - 50 of 2,500</span>
                                        <a href="#"><i class="ik ik-chevron-left"></i></a>
                                        <a href="#"><i class="ik ik-chevron-right"></i></a>
                                    </div>
                                </div> -->
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Payment ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date of Payment</th>
                                <th scope="col">Month of Reimburse</th>
                                <th scope="col">Amount of Payment</th>
                                <th scope="col">Payment Information</th>
                                <th scope="col">Create Date</th>
                                <th scope="col">Receipt of Payment</th>
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
                                    $q = "SELECT ID, PAYMENT_ID, NAMA, TANGGAL_BAYAR, BULAN_REIMBURSE, TOTAL_BAYAR, KETERANGAN, TGL_INPUT FROM TAGIHAN ORDER BY TGL_INPUT DESC LIMIT $limit_start, $limit";
                                    $sql = mysqli_query($conn, $q);
                                } else {
                                    $q = "SELECT ID, PAYMENT_ID, NAMA, TANGGAL_BAYAR, BULAN_REIMBURSE, TOTAL_BAYAR, KETERANGAN, TGL_INPUT FROM TAGIHAN WHERE NAMA LIKE '%" . $cari . "%' ORDER BY NAMA DESC";
                                    $sql = mysqli_query($conn, $q);
                                }
                            } else {
                                $q = "SELECT ID, PAYMENT_ID, NAMA, TANGGAL_BAYAR, BULAN_REIMBURSE, TOTAL_BAYAR, KETERANGAN, TGL_INPUT FROM TAGIHAN ORDER BY TGL_INPUT DESC LIMIT $limit_start, $limit";
                                $sql = mysqli_query($conn, $q);
                            }

                            // $NO = 0;

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
                                    <td>$NO</td>
                                    <td>$PAYMENT_ID</td>
                                    <td><b>$NAMA</b></td>
                                    <td>$VTANGGAL_BAYAR</td>
                                    <td>$VBULAN_REIMBURSE</td>
                                    <td>$TOTAL_BAYAR</td>
                                    <td>$KETERANGAN</td>
                                    <td>$TGL_INPUT</td>
                                    <td>
                                        <a href='cetakInvoice.php?id=$ID' target='_blank' type='button' class='btn btn-success btn-block'><i class='fas fa-print'></i> Print Payment</a>
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
                        $q = "SELECT COUNT(*) AS CNT FROM TAGIHAN";
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

<?php

include('panelSetting.php');

include('footer.php')

?>
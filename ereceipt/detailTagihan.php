<?php

require_once('koneksi.php');

include('header.php');

if (isset($_GET['nama'])) {
    $NAMA_ORANG = $_GET['nama'];
}

$q = "SELECT COUNT(1) AS CNT_TOTAL FROM TAGIHAN WHERE NAMA = '$NAMA_ORANG'";
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
                <div class="col-lg-12 col-md-6 col-sm-12">
                    <h3>Receipt Payment History | <?= $NAMA_ORANG ?></h3>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div style="padding-top:30px"></div>
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>Your Receipt Payment</h6>
                                    <h2><?= $TOTAL ?></h2>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>

                            </div>
                            <div class="mt-3"><a href="tambahDataAda.php?nama=<?= $NAMA_ORANG ?>" type="button" class="btn btn-warning btn-block"><i class="fas fa-file-invoice-dollar"></i> Create Receipt</a></div>
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
                    <div class="col col-sm-12">
                        <div class="card-options d-inline-block">
                            <h3>Receipt History | <?= $NAMA_ORANG ?></h3>
                        </div>
                    </div>
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

                            $NO = 0;
                            $q = "SELECT ID, PAYMENT_ID, NAMA, TANGGAL_BAYAR, BULAN_REIMBURSE, TOTAL_BAYAR, KETERANGAN, TGL_INPUT FROM TAGIHAN WHERE NAMA = '$NAMA_ORANG' ORDER BY TGL_INPUT DESC";
                            $sql = mysqli_query($conn, $q);
                            while ($row = mysqli_fetch_assoc($sql)) {

                                $NO++;
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
                            }

                            ?>
                        </tbody>
                    </table>
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

<?php

include('panelSetting.php');

include('footer.php')

?>
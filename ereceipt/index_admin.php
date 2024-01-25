<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:index.php');
}

require_once('koneksi.php');

include('header.php');

$email = $_SESSION['email'];
$password = $_SESSION['password'];

// echo $email;
// exit;

$q = "SELECT ID, EMAIL FROM LOGIN WHERE EMAIL = '$email'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$ID_USER = $row['ID'];
$EMAIL = $row['EMAIL'];

// ===================================================

$qCek = "SELECT COUNT(*) AS CNT_CEK FROM TAGIHAN WHERE ID_USER = '$ID_USER'";
$sqlCek = mysqli_query($conn, $qCek);
$row = mysqli_fetch_assoc($sqlCek);

$CNT_CEK = $row['CNT_CEK'];

if ($CNT_CEK > 0) {
    $q = "SELECT DISTINCT NAMA AS NAMA_USER FROM TAGIHAN WHERE ID_USER = '$ID_USER'";
    $sql = mysqli_query($conn, $q);
    $row = mysqli_fetch_assoc($sql);

    $NAMA = $row['NAMA_USER'];
} else {
    $NAMA = $EMAIL;
}

?>

<div class="page-wrap">

    <?php include('sidebarAdmin.php') ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-6 col-sm-12">
                    <div class="jumbotron">
                        <h1 class="display-4">Welcome, Admin</h1>
                        <!-- <p class="lead">This site will help you to create your receipt payment for your
                            boarding house</p> -->
                        <!-- <hr class="my-4"> -->
                        <!-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> -->
                        <!-- <a class="btn btn-primary btn-lg" href="indexInvoice.php" type="button"><i class="fas fa-file-invoice-dollar"></i> Create Your Payment Here</a> -->
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
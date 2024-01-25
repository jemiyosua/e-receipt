<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:index.php');
}

include('header.php');

require_once('koneksi.php');

if (isset($_GET['id'])) {
    $ID_USER = $_GET['id'];
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];

// GET ID USER
$q = "SELECT ID FROM LOGIN WHERE EMAIL = '$email'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$ID_USER = $row['ID'];

// =======================================================

$q = "SELECT FOTO FROM LOGIN WHERE ID = '$ID_USER'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$FOTO = $row['FOTO'];

// =======================================================

$q1 = "SELECT DISTINCT b.NAMA FROM LOGIN a, TAGIHAN b WHERE a.ID = b.ID_user AND A.ID = '$ID_USER' ";
$sql1 = mysqli_query($conn, $q1);
$row = mysqli_fetch_assoc($sql1);

$NAMA = $row['NAMA'];

if ($NAMA == "") {
    $VNAMA = $email;
} else {
    $VNAMA = $NAMA;
}

// =======================================================

if ($FOTO == "") {
    $src = "img/profile.png";
} else {
    $src = "LihatGambar.php?id=$ID_USER";
}

?>

<div class="page-wrap">

    <?php include('sidebar.php') ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-6 col-sm-12 mb-4">
                    <h3>Update Profile</h3>
                    <!-- <a href="cetakInvoice.php" target="_blank" type="button" class="btn btn-warning">Download</a>   -->
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
                    text: '" . $_SESSION['pesan'] . "'
                }).then(function() {
                    window.location.href='updateProfile.php';
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
                    window.location.href='updateProfile.php';
                });
                </script>";
                unset($_SESSION['pesanError']);
            }
            ?>
            
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body p-0 table-border-style">
                            <div class="table-responsive">
                                <form action="proses.php" method="POST" enctype="multipart/form-data">
                                    <table class="table">
                                        <tr>
                                            <th colspan="2">
                                                <div class="alert alert-info mt-3" role="alert">
                                                    <b>Profile Picture</b>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td align="center"><img src="<?= $src ?>" style="border-radius:50%;width:200px;height:200px"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="file" class="file-input" id="foto" name="foto" required></td>
                                        </tr>
                                        <tr>
                                            <td><button type="submit" class="btn btn-outline-primary" name="updateFoto">Submit</button></td>
                                            <td><input type="hidden" class="file-input" id="id" name="id" value="<?= $ID_USER ?>"></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (isset($_SESSION['pesanPass'])) {
                    // echo "<div class='alert alert-success' role='alert' style='border-radius:10px;'>" . $_SESSION['pesanPass'] . "</div>";
                    echo "<script>
                Swal.fire({
                    allowEnterKey: false,
                    allowOutsideClick: false,
                    icon: 'success',
                    title: 'Good Job :)',
                    text: '" . $_SESSION['pesanPass'] . "'
                }).then(function() {
                    window.location.href='logout.php';
                });
                </script>";
                    unset($_SESSION['pesanPass']);
                } else if (isset($_SESSION['pesanErrorPass'])) {
                    // echo "<div class='alert alert-warning' role='alert' style='border-radius:10px;'><b>" . $_SESSION['pesanErrorPass'] . "</b></div>";
                    echo "<script>
                Swal.fire({
                    allowEnterKey: false,
                    allowOutsideClick: false,
                    icon: 'error',
                    title: 'Sorry :(',
                    text: '" . $_SESSION['pesanErrorPass'] . "'
                }).then(function() {
                    window.location.href='updateProfile.php';
                });
                </script>";
                    unset($_SESSION['pesanErrorPass']);
                }
                ?>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="col col-sm-12">
                        </div>
                        <div class="card-body p-0 table-border-style">
                            <div class="table-responsive">
                                <form action="proses.php" method="POST" enctype="multipart/form-data">
                                    <table class="table">
                                        <tr>
                                            <th colspan="2">
                                                <div class="alert alert-info mt-3" role="alert">
                                                    <b>Change Your Password</b>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td width="15%"><b>Your Password</b></td>
                                            <td><input type="password" class="form-control" id="passAsli" name="passAsli" required></td>
                                        </tr>
                                        <tr>
                                            <td width="15%"><b>New Password</b></td>
                                            <td><input type="password" class="form-control" id="pass1" name="pass1" required></td>
                                        </tr>
                                        <tr>
                                            <td width=15%"><b>Confirm New Password</b></td>
                                            <td><input type="password" class="form-control" id="pass2" name="pass2" required></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="alert alert-warning mt-3" role="alert">
                                                    <b>After Submit to Change Your Password, You'll Auto Redirect to Login Page and Try to Log In!</b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><button type="submit" class="btn btn-outline-primary" name="updatePass">Submit</button></td>
                                            <td><input type="hidden" class="file-input" id="id" name="id" value="<?= $ID_USER ?>"></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
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

include('footer.php');

?>
<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:index.php');
}

include('header.php');

require_once('koneksi.php');

if (isset($_GET['cnt'])) {
    $counter = $_GET['cnt'];
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];

// GET ID USER
$q = "SELECT ID FROM LOGIN WHERE EMAIL = '$email'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$ID_USER = $row['ID'];

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

?>

<div class="page-wrap">

    <?php 
    
    include('sidebar.php');

    ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <h3>Phone Number Verification</h3>
                    <!-- <a href="cetakInvoice.php" target="_blank" type="button" class="btn btn-warning">Download</a>   -->
                </div>
            </div>

            <?php
            
            if ($counter == 1) {

                $sql = mysqli_query($conn, "SELECT VERIFIKASI_NO_HP FROM LOGIN WHERE ID = '$ID_USER'");
                $row = mysqli_fetch_assoc($sql);
                $cnt = $row["VERIFIKASI_NO_HP"];

                if ($cnt == 0) {
                    
                    if (isset($_SESSION['pesan'])) {
                        echo "<div class='alert alert-success' role='alert' style='border-radius:10px;'>" . $_SESSION['pesan'] . "</div>";
                        unset($_SESSION['pesan']);
                    } else if (isset($_SESSION['pesanError'])) {
                        echo "<div class='alert alert-warning' role='alert' style='border-radius:10px;'><b>" . $_SESSION['pesanError'] . "</b></div>";
                        unset($_SESSION['pesanError']);
                    }

                ?>

                    <div class="card">
                        <div class="col col-sm-6"></div>
                        <div class="card-body p-0 table-border-style">
                            <div class="table-responsive">
                                <form action="proses.php" method="POST" enctype="multipart/form-data">
                                    <table class="table">
                                        <tr>
                                            <th colspan="2">
                                                <div class="alert alert-info mt-3" role="alert">
                                                    Please insert your phone number below to send your verification code and verified your number
                                                    <hr>
                                                    Insert your number like this : 082118009042
                                                    <br>
                                                    <font style="color: red;">Do not insert your number like this : 6282118009042 or 0821-1800-9042, etc</font>
                                                    <hr>
                                                    <b>Your details of your Receipt Payment will send to your Phone Number using WhatsApp aplication every you create your Receipt Payment.</b>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td width="15%"><b>Your Phone Number</b></td>
                                            <td><input type="text" class="form-control" id="phone_no" name="phone_no" required></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><button type="submit" class="btn btn-outline-primary" name="verifikasi_no_hp">Send Verification Code</button></td>
                                            <td>
                                                <input type="hidden" class="file-input" id="id" name="id" value="<?= $ID_USER ?>">
                                                <input type="hidden" class="file-input" id="id" name="nama" value="<?= $VNAMA ?>">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php

                } else if ($cnt == 1) {

                ?>

                    <div class="alert alert-info mt-3" role="alert">
                        Hello, <?=$VNAMA?> 
                        <hr>
                        <b> Your number is verified!</b>
                    </div>

                    <div class="alert alert-warning mt-3" role="alert"> 
                        <b>If you want to change your Phone Number, please contact our support to manage your account!</b>
                    </div>

                <?php
                
                }

            } else if ($counter == 2) {

                $sql = mysqli_query($conn, "SELECT VERIFIKASI_NO_HP FROM LOGIN WHERE ID = '$ID_USER'");
                $row = mysqli_fetch_assoc($sql);
                $permission = $row["VERIFIKASI_NO_HP"];

                if ($permission == 1) {
                    ?>

                    <div class="alert alert-info mt-3" role="alert">
                        Hello, <?=$VNAMA?> 
                        <hr>
                        <b> Your number is verified!</b>
                    </div>

                    <div class="alert alert-warning mt-3" role="alert"> 
                        <b>If you want to change your Phone Number, please contact our support to manage your account!</b>
                    </div>

                    <?php

                } else {

                    if (isset($_SESSION['pesanError'])) {
                        // echo "<div class='alert alert-warning' role='alert' style='border-radius:10px;'><b>" . $_SESSION['pesanError'] . "</b></div>";
                        echo "<script>
                        Swal.fire({
                            allowEnterKey: false,
                            allowOutsideClick: false,
                            icon: 'error',
                            title: 'Sorry :(',
                            text: '".$_SESSION['pesanError']."'
                        }).then(function() {
                            window.location.href='updatePhone.php?cnt=2';
                        });
                        </script>";
                        unset($_SESSION['pesanError']);
                    }

                    ?>

                    <div class="card">
                        <div class="col col-sm-6"></div>
                        <div class="card-body p-0 table-border-style">
                            <div class="table-responsive">
                                <form action="proses.php" method="POST">
                                    <table class="table">
                                        <tr>
                                            <th colspan="2">
                                                <div class="alert alert-info mt-3" role="alert">
                                                    <b>Verification Phone Number</b> was sent to your WhatsApp
                                                    <hr>
                                                    Please cek your WhatsApp to get your code and fill your code below
                                                </div>
                                                <!-- <div class="alert alert-danger mt-3" role="alert">
                                                    <b>Please input your verification code before : </b>
                                                </div>
                                            </th> -->
                                        </tr>
                                        <tr>
                                            <td width="15%"><b>Your Code</b></td>
                                            <td>
                                                <input type="text" class="form-control" id="code" name="code" required>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <a href="updatePhone.php?cnt=1" class="btn btn-outline-danger"><i class="fas fa-pen-alt"></i> Change Number</a>
                                                <button type="submit" class="btn btn-success" name="verification_code">Verifiy Now</button>
                                            </td>
                                            <td><input type="hidden" class="file-input" id="id" name="id" value="<?= $ID_USER ?>"></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php

                }
            }
                
                ?>

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
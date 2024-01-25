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

$q1 = "SELECT NOTIFIKASI FROM LOGIN WHERE ID = '$ID_USER' ";
$sql1 = mysqli_query($conn, $q1);
$row = mysqli_fetch_assoc($sql1);

$NOTIFIKASI = $row['NOTIFIKASI'];

if ($NOTIFIKASI == 0) {
    $alert = "<div class='alert alert-warning' role='alert' style='border-radius:10px;'><i class='fas fa-times-circle'></i> Your notification is Disabled</div>";
} else {
    $alert = "<div class='alert alert-success' role='alert' style='border-radius:10px;'><i class='fas fa-check-circle'></i> Your Notification is Enabled</div>";
}

$q1 = "SELECT VERIFIKASI_NO_HP FROM LOGIN WHERE ID = '$ID_USER' ";
$sql1 = mysqli_query($conn, $q1);
$row = mysqli_fetch_assoc($sql1);

$VERIFIKASI_NO_HP = $row['VERIFIKASI_NO_HP'];

if ($VERIFIKASI_NO_HP == 0) {
    $form = "disabled";
    $button = "<div class='alert alert-danger' role='alert' style='border-radius:10px;'><i class='fas fa-times-circle'></i> Please verify your Phone Number first before using this feature at Verification Phone Number Menu.</div>";
} else {
    $form = "";
    $button = "";
}

?>

<div class="page-wrap">

    <?php 
    
    include('sidebar.php');

    ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-6 col-sm-12 mb-4">
                    <h3>Verification Phone Number</h3>
                    <!-- <a href="cetakInvoice.php" target="_blank" type="button" class="btn btn-warning">Download</a>   -->
                </div>
            </div>

            <div class="card">
                <div class="col col-sm-6"></div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive">
                        <form action="proses.php" method="POST" enctype="multipart/form-data">
                            <table class="table">
                                <tr>
                                    <th colspan="2">
                                        <div class="alert alert-info mt-3" role="alert">
                                            <b>Notification Alert</b>
                                            <hr>
                                            Enabled Notification : Reminder you every 28th in a month to create your Receipt Payment.
                                            <br>
                                            <font style="color: red;">Disabled Notification : The Reminder will off and you never get the message to reminder you.</font>
                                        </div>
                                        <?=$alert?>
                                        <?=$button?>
                                    </th>
                                </tr>
                                <tr>
                                    <td width="15%"><b>Notifcation Alert</b></td>
                                    <td>
                                        <select class="form-control" id="ijin_notifikasi" name="ijin_notifikasi" <?=$form?>>
                                            <option value="0" <?php if ($NOTIFIKASI == 0) echo 'selected="selected"'?> >Disabled Notifiaction</option>
                                            <option value="1" <?php if ($NOTIFIKASI == 1) echo 'selected="selected"'?>>Enabled Notification</option>
                                        </select> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="submit" class="btn btn-outline-primary" name="notifikasi" <?=$form?>>Submit</button>
                                    </td>
                                    <td>
                                        <input type="hidden" class="file-input" id="id" name="id" value="<?= $ID_USER ?>">
                                    </td>
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

<?php

include('panelSetting.php');

include('footer.php');

?>
<?php

session_start();

if (!isset($_SESSION['username']) && (!isset($_SESSION['password']))) {

    header('location:index.php');
}

require_once('koneksi.php');

include('header.php');

if (isset($_GET['id'])) {
    $ID_USER = $_GET['id'];
}

$q = "SELECT STATEMENT FROM LOGIN WHERE ID = '$ID_USER'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$STATEMENT = $row["STATEMENT"];

?>

<div class="page-wrap">

    <?php include('sidebarAdmin.php') ?>

    <div class="main-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header row">
                    <div class="col col-sm-9">
                        <div class="card-options d-inline-block">
                            <h3>Update Statement Letter</h3>
                        </div>
                    </div>
                </div>
            
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="card-body">
                        <form action="proses.php" method="POST">
                        <table>
                            <thead>
                                <tr>
                                    <td width="75%">
                                        <select class="form-control" name="statement">
                                            <option value="1" <?php $STATEMENT == 1 ? 'selected' : '' ?>>Open Access</option>
                                            <option value="0" <?php $STATEMENT == 0 ? 'selected' : '' ?>>Close Access</option>
                                        </select>
                                        <input type="hidden" value="<?= $ID_USER ?>" name="id_user">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <button type="submit" class="btn btn-outline-primary" name="updatestatement">Update</button>
                                    </td>
                                </tr>
                            </thead>
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
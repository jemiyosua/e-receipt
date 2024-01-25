<?php

require_once('koneksi.php');

$email = $_SESSION['email'];
$password = $_SESSION['password'];

$q = "SELECT ID, EMAIL, STATEMENT FROM LOGIN WHERE EMAIL = '$email'";
$sql = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($sql);

$ID_USER = $row['ID'];
$EMAIL = $row['EMAIL'];
$STATEMENT = $row['STATEMENT'];

?>

<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="index_.php">
            <!-- <div class="logo-img">
                <img src="src/img/brand-white.svg" class="header-brand-img" alt="lavalite">
            </div> -->
            <text>Boarding House</text>
        </a>
        <!-- <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button> -->
        <!-- <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button> -->
    </div>

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">

                <div class="nav-lavel">Navigation</div>
                <div class="nav-item active">
                    <a href="index_.php"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                </div>

                <div class="nav-item active">
                    <a href="indexInvoice.php"><i class="fas fa-file-invoice-dollar"></i><span>Receipt Payment</span></a>
                </div>

                <?php 

                // if ($ID_USER == 1 || $ID_USER == 2 || $ID_USER == 9) {
                if ($STATEMENT == 1) {
                
                ?>
                    
                <div class="nav-item active">
                    <a href="statement_letter.php"><i class="fas fa-file-invoice"></i><span>Statement Letter</span></a>
                </div>

                <?php
                }

                ?>

                <div class="nav-item active">
                    <a href="trash.php"><i class="fas fa-trash-alt"></i><span>Trash</span></a>
                </div>

                <div class="nav-lavel">Profile & Notification</div>
                <div class="nav-item active">
                    <a href="updateProfile.php"><i class="fas fa-user-circle"></i><span>Update Profile</span></a>
                </div>
                <div class="nav-item active">
                    <a href="updatePhone.php?cnt=1"><i class="fab fa-whatsapp"></i><span>Phone Number Verification</span></a>
                </div>
                <div class="nav-item active">
                    <a href="notifikasi.php"><i class="fas fa-clock"></i><span>Schedule Notification</span></a>
                </div>

                <div class="nav-lavel">Logout</div>
                <div class="nav-item active">
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
                </div>

            </nav>
        </div>
    </div>
</div>
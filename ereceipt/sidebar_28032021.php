<?php

include('koneksi.php');

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
                    <a href="indexInvoice.php"><i class="fas fa-file-invoice"></i></i><span>Receipt Payment</span></a>
                </div>
                
                <div class="nav-lavel">Setting</div>
                <div class="nav-item active">
                    <a href="updateProfile.php"><i class="fas fa-user-circle"></i><span>Edit Profile</span></a>
                </div>
                
                <div class="nav-lavel">Logout</div>
                <div class="nav-item active">
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
                </div>
                
            </nav>
        </div>
    </div>
</div>
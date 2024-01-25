<?php

require_once('koneksi.php');

session_start();

if (isset($_POST['login'])) {

    $EMAIL = $_POST['email'];
    $PASSWORD = $_POST['password'];

    $q = "SELECT COUNT(*) AS CNT_LOGIN FROM LOGIN WHERE EMAIL = '$EMAIL' AND PASSWORD = '$PASSWORD'";
    $sql = mysqli_query($conn, $q);
    $row = mysqli_fetch_assoc($sql);

    $CNT_LOGIN = $row['CNT_LOGIN'];
    // echo $CNT_LOGIN;exit;

    if ($EMAIL == "admin@gmail.com" && $PASSWORD == "adminadmin") {
        session_start();
        $_SESSION['email'] = $EMAIL;
        $_SESSION['password'] = $PASSWORD;
        header('location:index_admin.php');
        exit;
    } else if ($CNT_LOGIN == 1) {
        session_start();
        $_SESSION['email'] = $EMAIL;
        $_SESSION['password'] = $PASSWORD;
        header('location:index_.php');
        exit;
    } else {
        $_SESSION['pesanError'] = "Your Email or Password Are Wrong. Please Try Again.";
        header('location:index.php');
        exit;
    }
}

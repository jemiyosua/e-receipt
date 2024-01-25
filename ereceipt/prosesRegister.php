<?php

require_once('koneksi.php');

session_start();

if (isset($_POST['register'])) {

    $EMAIL = $_POST['email'];
    $PASSWORD = $_POST['password'];
    $PASSWORD2 = $_POST['password2'];

    $PASSWORD_COUNT = count($PASSWORD);
    echo $PASSWORD_COUNT;exit;

    $q = "SELECT COUNT(*) AS CNT_LOGIN FROM LOGIN WHERE EMAIL = '$EMAIL' ";
    $sql = mysqli_query($conn, $q);
    $row = mysqli_fetch_assoc($sql);

    $CNT_LOGIN = $row['CNT_LOGIN'];

    if ($CNT_LOGIN > 0) {
        $_SESSION['pesanError'] = "Email is Already Taken! Please Use Another Email.";
        header('location:register.php');
    } else if ($PASSWORD <> $PASSWORD2 || $PASSWORD != $PASSWORD2) {
        $_SESSION['pesanError'] = "Your Password is Not Match!";
        header('location:register.php');
    } else {
        if ($PASSWORD )
        $q = "INSERT INTO LOGIN (EMAIL, PASSWORD) VALUES ('$EMAIL', '$PASSWORD'); ";
        $sql = mysqli_query($conn, $q);

        if ($sql) {
            $_SESSION['pesan'] = "Your Account Was Created! Please Login For More Information!";
            header('location:index.php');
        } else {
            $_SESSION['pesanError'] = "Something Went Wrong When Create Your Account, Try Again Later.";
            header('location:register.php');
        }
    }
}

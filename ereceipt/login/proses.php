<?php

require_once('koneksi.php');

session_start();

if (isset($_POST['login'])) {
    $USERNAME = $_POST['username'];
    $PASSWORD = $_POST['password'];

    $q = "SELECT PASSWORD FROM TB_LOGIN WHERE USERNAME = '$USERNAME' ";
    $sql = mysqli_query($conn, $q);
    $row = mysqli_fetch_assoc($sql);

    $password_database = $row['PASSWORD'];

    if (md5($PASSWORD) == $password_database) {
        $VPASSWORD = md5($PASSWORD);

        $q = "SELECT COUNT(1) AS CNT_LOGIN FROM TB_LOGIN WHERE USERNAME = '$USERNAME' AND PASSWORD = '$VPASSWORD' ";
        $sql = mysqli_query($conn, $q);
        $row = mysqli_fetch_assoc($sql);

        $CNT_LOGIN = $row['CNT_LOGIN'];

        if ($CNT_LOGIN == 0) {
            session_start();
            $_SESSION['username'] = $USERNAME;
            // echo "masuk sini";w
            $_SESSION['validasiErr'] = "Username atau Password anda salah! silahkan cek kembali Username dan Password anda.";
            header('location:index.php');
        } else {
            session_start();
            $_SESSION['username'] = $USERNAME;
            $_SESSION['password'] = $PASSWORD;
            header('location:dashboard');
        }
    }
    echo "GALAT! PASSWORD SALAH";
}

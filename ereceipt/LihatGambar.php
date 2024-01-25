<?php

require_once('koneksi.php');

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $q = "SELECT FOTO FROM LOGIN WHERE ID = $id ";
    $sql = mysqli_query($conn, $q);
    $row = mysqli_fetch_array($sql);

    echo $row["FOTO"];
}

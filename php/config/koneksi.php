<?php

/* koneksi database */
$host = "localhost";
$user = "root";
$password = "";
$database = "iuran_desa";

/* membuat koneksi */
$conn = mysqli_connect($host, $user, $password, $database);

/* cek koneksi */
if (!$conn) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}
?>
<?php

session_start();

include "../config/koneksi.php";

/* ambil data dari form tambah keluarga */
$nama = $_POST['nama'];
$no_telepon = $_POST['no_telepon'];

/* simpan ke database */
mysqli_query(
    $conn,
    "INSERT INTO keluarga (nama_kepala_keluarga,no_telepon)
VALUES ('$nama','$no_telepon')"
);

$_SESSION['notifikasi'] = "Data keluarga berhasil ditambahkan";

header("Location: ../../html/public/dashboard.php");
?>
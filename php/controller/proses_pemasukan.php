<?php
session_start();

include "../config/koneksi.php";

/* ambil data dari form dana tambahan*/
$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];
$sumber = $_POST['sumber'];
$keterangan = $_POST['keterangan'];

/* simpan ke database */
mysqli_query(
    $conn,
    "INSERT INTO pemasukan (tanggal,jenis_dana,sumber_dana,keterangan,jumlah)
VALUES ('$tanggal','Pemasukan','$sumber','$keterangan','$jumlah')"
);

$_SESSION['notifikasi'] = "Dana tambahan berhasil ditambahkan";

header("Location: ../../html/public/dashboard.php");

?>
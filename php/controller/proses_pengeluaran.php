<?php
session_start();

include "../config/koneksi.php";

/* ambil data dari form pengeluaran*/

$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];
$penanggung_jawab = $_POST['penanggung_jawab'];

/* simpan ke database */

$query = mysqli_query($conn, "
INSERT INTO pengeluaran
(tanggal,keterangan,penanggung_jawab,jumlah)
VALUES
('$tanggal','$keterangan','$penanggung_jawab','$jumlah')
");

$_SESSION['notifikasi'] = "Pengeluaran berhasil ditambahkan";

/* redirect dengan status */

if ($query) {
    header("Location: ../../html/public/pengeluaran.php?status=sukses");
} else {
    header("Location: ../../html/public/pengeluaran.php?status=gagal");
}

?>
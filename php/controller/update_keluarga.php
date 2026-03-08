<?php
session_start();
include "../config/koneksi.php";

/* ambil data dari form edit keluarga */
$id = $_POST['id'];
$nama = $_POST['nama'];
$no_telepon = $_POST['no_telepon'];

/* update data/ edit data  */
mysqli_query($conn, "
UPDATE keluarga
SET 
nama_kepala_keluarga='$nama',
no_telepon='$no_telepon'
WHERE id_keluarga='$id'
");

$_SESSION['notifikasi'] = "Data keluarga berhasil diperbarui";

header("Location: ../../html/public/dashboard.php");

?>
<?php

include "../config/koneksi.php";

$id = $_GET['id'];

$bulan = date("F");
$tahun = date("Y");

/* ambil nama keluarga */
$ambil = mysqli_query($conn, "
SELECT nama_kepala_keluarga 
FROM keluarga
WHERE id_keluarga='$id'
");

$data = mysqli_fetch_assoc($ambil);
$nama = $data['nama_kepala_keluarga'];

/* update pembayaran menjadi lunas */
mysqli_query($conn, "
INSERT INTO pembayaran 
(id_keluarga,nama_kepala_keluarga,bulan,tahun,jumlah,tanggal_bayar,status)
VALUES 
('$id','$nama','$bulan','$tahun','50000',NOW(),'Lunas')
");

header("Location: ../../html/public/dashboard.php");

?>
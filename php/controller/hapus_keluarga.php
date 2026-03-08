<?php

include "../config/koneksi.php";

$id = $_GET['id'];

/* putuskan hubungan pembayaran dengan keluarga */

mysqli_query($conn, "
UPDATE pembayaran 
SET id_keluarga = NULL
WHERE id_keluarga = '$id'
");

/* hapus keluarga */
mysqli_query($conn, "DELETE FROM keluarga WHERE id_keluarga='$id'");

/* reset auto increment */
mysqli_query($conn, "ALTER TABLE keluarga AUTO_INCREMENT = 1");

header("Location: ../../html/public/dashboard.php");

?>
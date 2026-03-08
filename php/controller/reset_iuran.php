<?php

include __DIR__ . "/../config/koneksi.php";
include __DIR__ . "/../interfaceandmodel/reset_pembayaran.php";

/* membuat object */

$reset = new ResetPembayaran($conn);

/* menjalankan reset */

$reset->resetBulanan();
?>

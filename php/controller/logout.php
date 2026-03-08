<?php

session_start();

/* Menghancurkan sesi dan mengarahkan pengguna ke halaman login */
session_destroy();

header("Location: ../../html/public/login.php");
exit;
?>
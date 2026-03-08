<?php
session_start();
include "../config/koneksi.php";

/* Mengambil data username dan password dari form login */
$username = $_POST['username'];
$password = $_POST['password'];

/* query untuk memeriksa kecocokan username dan password */
$query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
$data = mysqli_fetch_array($query);

if ($data) {

    $_SESSION['admin'] = $data['username']; // ini yang membuat login aktif

    header("Location: ../../html/public/dashboard.php?status=login");
} else {

    /* jika login gagal, tampilkan pesan dan arahkan kembali ke halaman login */
    echo "<script>
    alert('Login gagal');
    window.location='../../html/public/login.php';
    </script>";
}
?>
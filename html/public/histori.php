<?php
session_start();

if (empty($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include "../../php/config/koneksi.php";

/* histori iuran */

$iuran = mysqli_query($conn, "
SELECT 
tanggal_bayar AS tanggal,
nama_kepala_keluarga,
bulan,
jumlah
FROM pembayaran
WHERE status='Lunas'
ORDER BY tanggal_bayar DESC
");

/* histori pemasukan */

$pemasukan = mysqli_query($conn, "
SELECT 
tanggal,
jenis_dana,
sumber_dana,
keterangan,
jumlah
FROM pemasukan
ORDER BY tanggal DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Histori Dana Desa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
        }

        .content {
            margin-left: 220px;
            width: 100%;
        }
    </style>

</head>

<body class="bg-light">

    <div class="d-flex">

        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white p-3 d-flex flex-column">

            <h4 class="text-center mb-4">Pencatatan Dana Desa Sengguan</h4>

            <ul class="nav flex-column mb-auto">

                <li class="nav-item">
                    <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="pengeluaran.php">Pengeluaran Dana</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="histori.php">Histori Dana</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="laporan.php">Laporan Dana</a>
                </li>

            </ul>

            <hr class="text-white">

            <a href="../../php/controller/logout.php" class="btn btn-danger w-100">
                Logout
            </a>

        </div>


        <!-- Content -->
        <div class="content p-4">

            <h3 class="mb-4">Histori Dana Desa</h3>


            <!-- tabel histori iuran -->

            <div class="card shadow mb-4">

                <div class="card-header bg-primary text-white">
                    Histori Pembayaran Iuran Warga
                </div>

                <div class="card-body">

                    <table class="table table-striped">

                        <thead>

                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Kepala Keluarga</th>
                                <th>Bulan</th>
                                <th>Jumlah</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($row = mysqli_fetch_assoc($iuran)) { ?>

                                <tr>

                                    <td><?php echo $row['tanggal']; ?></td>

                                    <td><?php echo $row['nama_kepala_keluarga']; ?></td>

                                    <td><?php echo $row['bulan']; ?></td>

                                    <td>Rp <?php echo number_format($row['jumlah']); ?></td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>



            <!-- tabel pemasukan dana tambahan -->

            <div class="card shadow">

                <div class="card-header bg-success text-white">
                    Histori Pemasukan Dana Tambahan
                </div>

                <div class="card-body">

                    <table class="table table-striped">

                        <thead>

                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Dana</th>
                                <th>Sumber Dana</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($row = mysqli_fetch_assoc($pemasukan)) { ?>

                                <tr>

                                    <td><?php echo $row['tanggal']; ?></td>

                                    <td><?php echo $row['jenis_dana']; ?></td>

                                    <td><?php echo $row['sumber_dana']; ?></td>

                                    <td><?php echo $row['keterangan']; ?></td>

                                    <td>Rp <?php echo number_format($row['jumlah']); ?></td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>


        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
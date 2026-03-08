<?php
session_start();

if (empty($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include "../../php/config/koneksi.php";

/* filter tanggal */

$tanggal_awal = $_GET['tanggal_awal'] ?? '';
$tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

/* query iuran  */

$queryIuran = "
SELECT 
tanggal_bayar AS tanggal,
nama_kepala_keluarga AS sumber,
bulan,
jumlah
FROM pembayaran
WHERE status='Lunas'
";

if ($tanggal_awal && $tanggal_akhir) {
    $queryIuran .= " AND pembayaran.tanggal_bayar BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
}

$queryIuran .= " ORDER BY pembayaran.tanggal_bayar DESC";

$iuran = mysqli_query($conn, $queryIuran);


/* query pemasukan tambahan*/

$queryPemasukan = "
SELECT 
tanggal,
jenis_dana,
sumber_dana,
keterangan,
jumlah
FROM pemasukan
WHERE 1
";

if ($tanggal_awal && $tanggal_akhir) {
    $queryPemasukan .= " AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
}

$queryPemasukan .= " ORDER BY tanggal DESC";

$pemasukan = mysqli_query($conn, $queryPemasukan);


/* query pengeluaran */

$queryPengeluaran = "
SELECT 
tanggal,
keterangan,
penanggung_jawab,
jumlah
FROM pengeluaran
WHERE 1
";

if ($tanggal_awal && $tanggal_akhir) {
    $queryPengeluaran .= " AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
}

$queryPengeluaran .= " ORDER BY tanggal DESC";

$pengeluaran = mysqli_query($conn, $queryPengeluaran);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Laporan Dana Desa</title>

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

        <!-- sidebar -->

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

        <!-- content -->
        <div class="content p-4">

            <h3 class="mb-4">Laporan Keuangan Dana Desa</h3>

            <div class="card mb-4 shadow">

                <div class="card-body">
                    <!-- filter tanggal -->
                    <form method="GET">

                        <div class="row">

                            <div class="col-md-4">

                                <label>Tanggal Mulai</label>
                                <input type="date" name="tanggal_awal" class="form-control">

                            </div>

                            <div class="col-md-4">

                                <label>Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" class="form-control">

                            </div>

                            <div class="col-md-4 d-flex align-items-end gap-2">

                                <button class="btn btn-primary">
                                    Tampilkan Laporan
                                </button>
                                <!-- download laporan PDF -->
                                <a href="../../php/controller/download_laporan.php?tanggal_awal=<?php echo $tanggal_awal ?>&tanggal_akhir=<?php echo $tanggal_akhir ?>"
                                    class="btn btn-success">
                                    Download PDF
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            <!-- tabel iuran -->

            <div class="card shadow mb-4">

                <div class="card-header bg-primary text-white">
                    Laporan Iuran Warga
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
                                    <td><?php echo $row['sumber']; ?></td>
                                    <td><?php echo $row['bulan']; ?></td>
                                    <td>Rp <?php echo number_format($row['jumlah']); ?></td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>



            <!-- tabel pemasukan tambahan -->

            <div class="card shadow mb-4">

                <div class="card-header bg-success text-white">
                    Laporan Pemasukan Tambahan
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



            <!-- tabel pengeluaran-->

            <div class="card shadow">

                <div class="card-header bg-danger text-white">
                    Laporan Pengeluaran Dana
                </div>

                <div class="card-body">

                    <table class="table table-striped">

                        <thead>

                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Penanggung Jawab</th>
                                <th>Jumlah</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($row = mysqli_fetch_assoc($pengeluaran)) { ?>

                                <tr>
                                    <td><?php echo $row['tanggal']; ?></td>
                                    <td><?php echo $row['keterangan']; ?></td>
                                    <td><?php echo $row['penanggung_jawab']; ?></td>
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
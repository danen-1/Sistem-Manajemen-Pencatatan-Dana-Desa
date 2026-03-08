<?php
session_start();

if (empty($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include "../../php/config/koneksi.php";

$data = mysqli_query($conn, "SELECT * FROM pengeluaran ORDER BY tanggal DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Pengeluaran Dana Desa</title>

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

    <?php
    if (isset($_SESSION['notifikasi'])) {
        echo "<script>alert('" . $_SESSION['notifikasi'] . "');</script>";
        unset($_SESSION['notifikasi']);
    }
    ?>

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

            <a href="../../controller/php/logout.php" class="btn btn-danger w-100">
                Logout
            </a>

        </div>


        <!-- content -->
        <div class="content p-4">

            <h3 class="mb-4">Pengeluaran Dana Desa</h3>

            <div class="card shadow">

                <div class="card-header bg-warning text-dark">
                    Pengeluaran Dana
                </div>

                <div class="card-body">

                    <!-- tombol tambah pengeluaran -->
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalPengeluaran">
                        Tambah Pengeluaran
                    </button>

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

                            <?php while ($row = mysqli_fetch_assoc($data)) { ?>

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


    <!-- modal tambah pengeluaran -->

    <div class="modal fade" id="modalPengeluaran">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Tambah Pengeluaran Dana</h5>

                    <button class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <form action="../../php/controller/proses_pengeluaran.php" method="POST">

                    <div class="modal-body">

                        <div class="mb-3">

                            <label>Tanggal Pengeluaran</label>

                            <input type="date"
                                name="tanggal"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Jumlah Pengeluaran</label>

                            <input type="number"
                                name="jumlah"
                                class="form-control"
                                placeholder="Masukkan jumlah uang"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Keterangan Penggunaan</label>

                            <textarea name="keterangan"
                                class="form-control"
                                rows="3"
                                required></textarea>

                        </div>

                        <div class="mb-3">

                            <label>Penanggung Jawab</label>

                            <input type="text"
                                name="penanggung_jawab"
                                class="form-control"
                                placeholder="Nama penanggung jawab"
                                required>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button class="btn btn-primary">
                            Simpan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
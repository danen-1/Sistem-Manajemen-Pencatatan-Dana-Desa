<?php
session_start();

if (empty($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include "../../php/config/koneksi.php";
include "../../php/interfaceandmodel/functions.php";
include "../../php/controller/reset_iuran.php";
include "../../php/interfaceandmodel/manajemen_dana.php";

use SistemIuran\SaldoDana;
use function SistemHelper\formatRupiah;
use function SistemHelper\statusPembayaran;

/* =========================
STATISTIK
========================= */

$totalKeluarga = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) as total FROM keluarga
"));

$totalIuran = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT SUM(jumlah) as total 
FROM pembayaran 
WHERE status='Lunas'
"));

$totalPemasukanTambahan = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT SUM(jumlah) as total 
FROM pemasukan
"));

$totalPengeluaran = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT SUM(jumlah) as total 
FROM pengeluaran
"));

$totalDanaMasuk = ($totalIuran['total'] ?? 0) + ($totalPemasukanTambahan['total'] ?? 0);

// menggunakan class OOP dari manajemen_dana.php
$saldo = new SaldoDana($totalDanaMasuk, $totalPengeluaran['total'] ?? 0);

// polymorphism method
$sisaDana = $saldo->hitungSaldo();


/* membaca data keluarga*/

$data = mysqli_query($conn, "
SELECT 
keluarga.id_keluarga,
keluarga.nama_kepala_keluarga,
keluarga.no_telepon,
pembayaran.bulan,
pembayaran.status
FROM keluarga
LEFT JOIN pembayaran
ON keluarga.id_keluarga = pembayaran.id_keluarga
GROUP BY keluarga.id_keluarga
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Sistem Pencatatan Dana Desa</title>

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
    <!-- sidebar -->
    <div class="d-flex">

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
        <div class="content w-100 p-4">

            <h3 class="mb-4">Dashboard</h3>
            <?php
            if (isset($_GET['status'])) {
                $status = $_GET['status'];

                if ($status == "login") {
                    echo "<script>alert('Login berhasil!, Admin');</script>";
                }
            }
            ?>



            <div class="row">

                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h6>Total Keluarga</h6>
                            <h4 class="text-primary">

                                <?php echo $totalKeluarga['total']; ?>

                            </h4>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h6>Total Dana Masuk</h6>
                            <h4 class="text-success">

                                <?php echo formatRupiah($totalDanaMasuk); ?>

                            </h4>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h6>Total Pengeluaran</h6>
                            <h4 class="text-danger">

                                <?php echo formatRupiah($totalPengeluaran['total'] ?? 0); ?>

                            </h4>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h6>Sisa Dana</h6>
                            <h4 class="text-dark">

                                <?php echo formatRupiah($sisaDana); ?>

                            </h4>
                        </div>
                    </div>
                </div>

            </div>
            <!-- tabel data keluarga -->
            <div class="card mt-4 shadow">

                <div class="card-header bg-primary text-white">
                    Data Kepala Keluarga
                </div>
                <!-- button tambah keluarga dan pemasukan dana -->
                <div class="card-body">

                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        Tambah Data Keluarga
                    </button>

                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalPemasukan">
                        Tambah Pemasukan Dana
                    </button>

                    <table class="table table-striped">

                        <thead>

                            <tr>
                                <th>Nama Kepala Keluarga</th>
                                <th>Nomor Telepon</th>
                                <th>Bulan</th>
                                <th>Status Bayar</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($row = mysqli_fetch_assoc($data)) { ?>

                                <tr>

                                    <td><?php echo $row['nama_kepala_keluarga']; ?></td>

                                    <td><?php echo $row['no_telepon']; ?></td>

                                    <td><?php echo $row['bulan'] ?? "-"; ?></td>

                                    <td>

                                        <?php echo statusPembayaran($row['status']); ?>

                                    </td>
                                    <!-- aksi approve, edit, delete -->
                                    <td>

                                        <a href="../../php/controller/approve_pembayaran.php?id=<?php echo $row['id_keluarga']; ?>" class="btn btn-success btn-sm">
                                            Accept
                                        </a>

                                        <button class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit<?php echo $row['id_keluarga']; ?>">
                                            Edit
                                        </button>

                                        <a href="../../php/controller/hapus_keluarga.php?id=<?php echo $row['id_keluarga']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data keluarga ini?')"> Hapus </a>

                                    </td>

                                </tr>

                                <!-- Modal Edit Data Keluarga -->

                                <div class="modal fade" id="modalEdit<?php echo $row['id_keluarga']; ?>">

                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Data Kepala Keluarga</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="../../php/controller/update_keluarga.php" method="POST">

                                                <div class="modal-body">

                                                    <input type="hidden" name="id"
                                                        value="<?php echo $row['id_keluarga']; ?>">

                                                    <div class="mb-3">
                                                        <label>Nama Kepala Keluarga</label>

                                                        <input type="text"
                                                            name="nama"
                                                            value="<?php echo $row['nama_kepala_keluarga']; ?>"
                                                            class="form-control"
                                                            required>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label>Nomor Telepon</label>

                                                        <input type="text"
                                                            name="no_telepon"
                                                            value="<?php echo $row['no_telepon']; ?>"
                                                            class="form-control"
                                                            required>

                                                    </div>

                                                </div>

                                                <div class="modal-footer">

                                                    <button class="btn btn-secondary"
                                                        data-bs-dismiss="modal">

                                                        Batal

                                                    </button>

                                                    <button class="btn btn-warning">

                                                        Update

                                                    </button>

                                                </div>

                                            </form>

                                        </div>
                                    </div>

                                </div>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>
            </div>

        </div>

    </div>

    <!-- tambah keluarga -->
    <div class="modal fade" id="modalTambah">

        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kepala Keluarga</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="../../php/controller/proses_tambah_keluarga.php" method="POST">

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Nama Kepala Keluarga</label>

                            <input type="text"
                                name="nama"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Nomor Telepon</label>

                            <input type="text"
                                name="no_telepon"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary"
                            data-bs-dismiss="modal">

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


    <!-- tambah pemasukan dana -->
    <div class="modal fade" id="modalPemasukan">

        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Tambah Pemasukan Dana</h5>

                    <button class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <form action="../../php/controller/proses_pemasukan.php" method="POST">

                    <div class="modal-body">

                        <div class="mb-3">

                            <label>Tanggal</label>

                            <input type="date"
                                name="tanggal"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Jumlah Dana</label>

                            <input type="number"
                                name="jumlah"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Sumber Dana</label>

                            <input type="text"
                                name="sumber"
                                class="form-control">

                        </div>

                        <div class="mb-3">

                            <label>Keterangan</label>

                            <textarea name="keterangan"
                                class="form-control"></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button class="btn btn-success">

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
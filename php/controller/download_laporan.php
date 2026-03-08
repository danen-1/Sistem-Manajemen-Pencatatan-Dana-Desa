<?php
session_start();
include "../config/koneksi.php";

require('../fpdf/fpdf.php');

/* filter tanggal */
$tanggal_awal = $_GET['tanggal_awal'] ?? '';
$tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

/* query iuran*/

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
    $queryIuran .= " AND tanggal_bayar BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
}

$queryIuran .= " ORDER BY tanggal_bayar DESC";


$iuran = mysqli_query($conn, $queryIuran);


/* query pemasukan tambahan */
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

$pengeluaran = mysqli_query($conn, $queryPengeluaran);


/* membuat PDF */

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

/* judul */

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'LAPORAN KEUANGAN DANA DESA', 0, 1, 'C');
$pdf->Ln(5);


/* tabel iuran */

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'Laporan Iuran Warga', 0, 1);

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(50, 8, 'Tanggal', 1);
$pdf->Cell(50, 8, 'Nama Kepala Keluarga', 1);
$pdf->Cell(60, 8, 'Bulan', 1);
$pdf->Cell(50, 8, 'Jumlah', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

$total_iuran = 0;

while ($row = mysqli_fetch_assoc($iuran)) {

    $pdf->Cell(50, 8, $row['tanggal'], 1);
    $pdf->Cell(50, 8, $row['sumber'], 1);
    $pdf->Cell(60, 8, $row['bulan'], 1);
    $pdf->Cell(50, 8, 'Rp ' . number_format($row['jumlah']), 1);
    $pdf->Ln();

    $total_iuran += $row['jumlah'];
}

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(160, 8, 'Total Iuran', 1);
$pdf->Cell(50, 8, 'Rp ' . number_format($total_iuran), 1);

$pdf->Ln(12);


/* tabel pemasukan tambahan */

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'Laporan Pemasukan Tambahan', 0, 1);

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(40, 8, 'Tanggal', 1);
$pdf->Cell(50, 8, 'Jenis Dana', 1);
$pdf->Cell(70, 8, 'Sumber Dana', 1);
$pdf->Cell(80, 8, 'Keterangan', 1);
$pdf->Cell(30, 8, 'Jumlah', 1);

$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

$total_pemasukan = 0;

while ($row = mysqli_fetch_assoc($pemasukan)) {

    $pdf->Cell(40, 8, $row['tanggal'], 1);
    $pdf->Cell(50, 8, $row['jenis_dana'], 1);
    $pdf->Cell(70, 8, $row['sumber_dana'], 1);
    $pdf->Cell(80, 8, $row['keterangan'], 1);
    $pdf->Cell(30, 8, 'Rp ' . number_format($row['jumlah']), 1);

    $pdf->Ln();

    $total_pemasukan += $row['jumlah'];
}

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(240, 8, 'Total Pemasukan Tambahan', 1);
$pdf->Cell(30, 8, 'Rp ' . number_format($total_pemasukan), 1);

$pdf->Ln(12);


/* tabel pengeluaran */

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'Laporan Pengeluaran Dana', 0, 1);

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(50, 8, 'Tanggal', 1);
$pdf->Cell(120, 8, 'Keterangan', 1);
$pdf->Cell(70, 8, 'Penanggung Jawab', 1);
$pdf->Cell(30, 8, 'Jumlah', 1);

$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

$total_pengeluaran = 0;

while ($row = mysqli_fetch_assoc($pengeluaran)) {

    $pdf->Cell(50, 8, $row['tanggal'], 1);
    $pdf->Cell(120, 8, $row['keterangan'], 1);
    $pdf->Cell(70, 8, $row['penanggung_jawab'], 1);
    $pdf->Cell(30, 8, 'Rp ' . number_format($row['jumlah']), 1);

    $pdf->Ln();

    $total_pengeluaran += $row['jumlah'];
}

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(240, 8, 'Total Pengeluaran', 1);
$pdf->Cell(30, 8, 'Rp ' . number_format($total_pengeluaran), 1);

$pdf->Ln(10);


/* perhitungan saldo akhir */

$total_pemasukan_semua = $total_iuran + $total_pemasukan;
$saldo = $total_pemasukan_semua - $total_pengeluaran;

$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(240, 10, 'Saldo Akhir', 1);
$pdf->Cell(30, 10, 'Rp ' . number_format($saldo), 1);


/* output PDF */

$pdf->Output('I', 'laporan_dana_desa.pdf');
